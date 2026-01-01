import csv
import sqlite3
import time

# ================== CONFIG ==================

INPUT_CSV = "IP2LOCATION-LITE-ASN.CSV"   # il file che hai mostrato
OUTPUT_DB = "maxmind_asn.db"


# ================== LOAD CSV ==================

def load_asn_csv(path):
    rows = []
    with open(path, encoding="utf-8") as f:
        reader = csv.reader(f)
        for r in reader:
            if not r:
                continue

            try:
                ip_from = int(r[0])
                ip_to = int(r[1])
            except:
                continue

            cidr = r[2].strip() if len(r) > 2 else ""

            try:
                asn = int(r[3]) if len(r) > 3 and r[3] else None
            except:
                asn = None

            org = r[4].strip() if len(r) > 4 else ""

            # ignora righe senza ASN
            if not asn:
                continue

            rows.append({
                "ip_from": ip_from,
                "ip_to": ip_to,
                "asn": asn,
                "org": org
            })

    return rows


# ================== BUILD ASN DB WITH PROGRESS ==================

def build_asn_data_with_progress(rows):
    asn_orgs = {}
    asn_blocks = []

    total = len(rows)
    progress_step = max(1, total // 100)
    start_time = time.time()

    for idx, row in enumerate(rows):
        if idx % progress_step == 0 and idx > 0:
            elapsed = time.time() - start_time
            percent = idx * 100 / total
            eta = (elapsed / idx) * (total - idx)
            print(
                f"[{percent:6.2f}%] {idx}/{total} | "
                f"elapsed={elapsed/60:5.1f}m | ETA={eta/60:5.1f}m"
            )

        ip_from = row["ip_from"]
        ip_to = row["ip_to"]
        asn = row["asn"]
        org = row["org"]

        if asn not in asn_orgs:
            asn_orgs[asn] = org

        asn_blocks.append((ip_from, ip_to, asn))

    # ordina per ip_from per performance SA-MP
    asn_blocks.sort(key=lambda x: x[0])

    return asn_orgs, asn_blocks


# ================== SAVE SQLITE ==================

def save_sqlite(asn_orgs, asn_blocks, output_path):
    conn = sqlite3.connect(output_path)
    cur = conn.cursor()

    cur.execute("DROP TABLE IF EXISTS asn_blocks")
    cur.execute("DROP TABLE IF EXISTS asn_organizations")

    cur.execute("""
        CREATE TABLE asn_blocks (
            ip_from UNSIGNED INTEGER NOT NULL,
            ip_to   UNSIGNED INTEGER NOT NULL,
            autonomous_system_number UNSIGNED INTEGER NOT NULL,
            PRIMARY KEY(ip_to)
        )
    """)

    cur.execute("""
        CREATE TABLE asn_organizations (
            autonomous_system_number UNSIGNED INTEGER NOT NULL,
            autonomous_system_organization VARCHAR(94) NOT NULL,
            PRIMARY KEY(autonomous_system_number)
        )
    """)

    # inserisci organizzazioni
    for asn, org in asn_orgs.items():
        cur.execute(
            "INSERT INTO asn_organizations VALUES (?, ?)",
            (asn, org)
        )

    # inserisci blocchi ASN
    cur.executemany(
        "INSERT INTO asn_blocks VALUES (?, ?, ?)",
        asn_blocks
    )

    # indice richiesto
    cur.execute("""
        CREATE INDEX autonomous_system_number
        ON asn_blocks (autonomous_system_number)
    """)

    conn.commit()
    conn.close()


# ================== MAIN ==================

def main():
    print("Carico CSV ASN...")
    rows = load_asn_csv(INPUT_CSV)
    print(f"Righe valide: {len(rows)}")

    print("Costruisco ASN DB...")
    asn_orgs, asn_blocks = build_asn_data_with_progress(rows)

    print(f"asn_organizations: {len(asn_orgs)}")
    print(f"asn_blocks: {len(asn_blocks)}")

    print("Scrivo SQLite...")
    save_sqlite(asn_orgs, asn_blocks, OUTPUT_DB)

    print("Fatto. maxmind_asn.db generato.")


if __name__ == "__main__":
    main()
