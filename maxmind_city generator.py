import csv
import ipaddress
import math
import sqlite3
import unicodedata
import time
from collections import defaultdict

# ================== CONFIG ==================

IP2L_DB11_CIDR_CSV = "IP2LOCATION-LITE-DB11.CIDR.CSV"
GEONAMES_CITIES5000 = "cities5000.txt"
OUTPUT_DB = "maxmind_city.db"

EARTH_RADIUS_KM = 6371.0
PRIMARY_MATCH_RADIUS_KM = 20.0
SECONDARY_MATCH_RADIUS_KM = 80.0


# ================== UTILITY ==================

def normalize_city(name: str) -> str:
    if not name:
        return ""
    name = name.strip()
    name = unicodedata.normalize("NFKD", name)
    name = "".join(c for c in name if not unicodedata.combining(c))
    return name.casefold()


def haversine_km(lat1, lon1, lat2, lon2):
    lat1, lon1, lat2, lon2 = map(math.radians, (lat1, lon1, lat2, lon2))
    dlat = lat2 - lat1
    dlon = lon2 - lon1
    a = (math.sin(dlat / 2) ** 2
         + math.cos(lat1) * math.cos(lat2) * math.sin(dlon / 2) ** 2)
    c = 2 * math.asin(math.sqrt(a))
    return EARTH_RADIUS_KM * c


# ================== LOADERS ==================

def load_ip2location_db11_cidr(path):
    rows = []
    with open(path, encoding="utf-8") as f:
        reader = csv.reader(f)
        for r in reader:
            if not r:
                continue

            cidr = r[0].strip()
            country_code = r[1].strip() or "-"
            city = r[4].strip() if len(r) > 4 else ""

            try:
                lat = float(r[5]) if len(r) > 5 and r[5] else 0.0
                lon = float(r[6]) if len(r) > 6 and r[6] else 0.0
            except ValueError:
                lat, lon = 0.0, 0.0

            tz_offset = r[8].strip() if len(r) > 8 else ""

            if country_code == "-" and (city == "-" or city == ""):
                continue

            rows.append({
                "cidr": cidr,
                "country_code": country_code,
                "city": city,
                "lat": lat,
                "lon": lon,
                "timezone_offset": tz_offset
            })
    return rows


def load_geonames_cities(path):
    by_name_country = defaultdict(list)
    by_country = defaultdict(list)
    capitals = {}

    with open(path, encoding="utf-8") as f:
        for line in f:
            parts = line.rstrip("\n").split("\t")
            if len(parts) < 18:
                continue

            try:
                geoname_id = int(parts[0])
                lat = float(parts[4])
                lon = float(parts[5])
            except ValueError:
                continue

            name = parts[1]
            country_code = parts[8]
            feature_code = parts[7]
            population = int(parts[14]) if parts[14].isdigit() else 0
            timezone = parts[17]

            entry = {
                "geoname_id": geoname_id,
                "name": name,
                "lat": lat,
                "lon": lon,
                "country_code": country_code,
                "population": population,
                "timezone": timezone
            }

            norm_name = normalize_city(name)
            by_name_country[(norm_name, country_code)].append(entry)
            by_country[country_code].append(entry)

            if feature_code == "PPLC" and country_code not in capitals:
                capitals[country_code] = entry

    return by_name_country, by_country, capitals


# ================== MATCHING ==================

def select_best_by_distance(candidates, lat, lon, max_distance_km):
    if not candidates or (lat == 0.0 and lon == 0.0):
        return None

    best = None
    best_dist = None

    for c in candidates:
        d = haversine_km(lat, lon, c["lat"], c["lon"])
        if best is None or d < best_dist:
            best = c
            best_dist = d

    if best is not None and best_dist <= max_distance_km:
        return best
    return None


def select_most_populated(candidates):
    if not candidates:
        return None
    return max(candidates, key=lambda c: c["population"])


def fallback_geoname_by_location(country_code, lat, lon, by_country, capitals):
    candidates = by_country.get(country_code, [])

    if candidates and (lat != 0.0 or lon != 0.0):
        best = select_best_by_distance(candidates, lat, lon, PRIMARY_MATCH_RADIUS_KM)
        if best:
            return best
        best = select_best_by_distance(candidates, lat, lon, SECONDARY_MATCH_RADIUS_KM)
        if best:
            return best

    return capitals.get(country_code)


def match_city_to_geoname(row, by_name_country, by_country, capitals):
    city = row["city"]
    country_code = row["country_code"]
    lat = row["lat"]
    lon = row["lon"]

    if city and city != "-":
        norm_city = normalize_city(city)
        candidates = by_name_country.get((norm_city, country_code), [])

        if candidates:
            if len(candidates) == 1:
                return candidates[0]
            best = select_best_by_distance(candidates, lat, lon, PRIMARY_MATCH_RADIUS_KM)
            if best:
                return best
            return select_most_populated(candidates)

    return fallback_geoname_by_location(country_code, lat, lon, by_country, capitals)


# ================== BUILD DB WITH PROGRESS ==================

def build_city_data_with_progress(ip2_rows, by_name_country, by_country, capitals):
    city_locations = {}
    city_blocks = []

    total = len(ip2_rows)
    progress_step = max(1, total // 100)
    start_time = time.time()
    matched = 0

    for idx, row in enumerate(ip2_rows):
        if idx % progress_step == 0 and idx > 0:
            elapsed = time.time() - start_time
            percent = idx * 100 / total
            eta = (elapsed / idx) * (total - idx)
            print(
                f"[{percent:6.2f}%] {idx}/{total} | "
                f"match={matched} | "
                f"elapsed={elapsed/60:5.1f}m | ETA={eta/60:5.1f}m"
            )

        match = match_city_to_geoname(row, by_name_country, by_country, capitals)
        if not match:
            continue

        matched += 1
        geoname_id = match["geoname_id"]
        city_name = row["city"] if row["city"] and row["city"] != "-" else match["name"]
        tz_offset = row["timezone_offset"] or "+00:00"

        if geoname_id not in city_locations:
            city_locations[geoname_id] = (city_name, tz_offset)

        try:
            net = ipaddress.ip_network(row["cidr"], strict=False)
            ip_from = int(net.network_address)
            ip_to = int(net.broadcast_address)
            city_blocks.append((ip_from, ip_to, geoname_id))
        except ValueError:
            continue

    city_blocks.sort(key=lambda x: x[0])

    return city_locations, city_blocks


# ================== SAVE SQLITE ==================

def save_sqlite(city_locations, city_blocks, output_path):
    conn = sqlite3.connect(output_path)
    cur = conn.cursor()

    cur.execute("DROP TABLE IF EXISTS city_locations")
    cur.execute("DROP TABLE IF EXISTS city_blocks")

    cur.execute("""
        CREATE TABLE city_locations (
            geoname_id UNSIGNED INTEGER NOT NULL,
            city_name VARCHAR(108) NOT NULL,
            time_zone CHAR(6) NOT NULL DEFAULT '+00:00',
            PRIMARY KEY(geoname_id)
        )
    """)

    cur.execute("""
        CREATE TABLE city_blocks (
            ip_from UNSIGNED INT(10) NOT NULL,
            ip_to UNSIGNED INT(10) NOT NULL,
            geoname_id UNSIGNED INT(10) NOT NULL,
            PRIMARY KEY(ip_to)
        )
    """)

    for geoname_id, (city_name, tz_offset) in city_locations.items():
        cur.execute(
            "INSERT INTO city_locations VALUES (?, ?, ?)",
            (geoname_id, city_name, tz_offset[:6])
        )

    cur.executemany(
        "INSERT INTO city_blocks VALUES (?, ?, ?)",
        city_blocks
    )

    cur.execute("""CREATE INDEX geoname_id ON city_blocks (geoname_id)""")

    conn.commit()
    conn.close()


# ================== MAIN ==================

def main():
    print("Carico IP2Location DB11 CIDR...")
    ip2_rows = load_ip2location_db11_cidr(IP2L_DB11_CIDR_CSV)
    print(f"Righe caricate: {len(ip2_rows)}")

    print("Carico GeoNames cities5000...")
    by_name_country, by_country, capitals = load_geonames_cities(GEONAMES_CITIES5000)

    print("Matching ultra accurato...")
    city_locations, city_blocks = build_city_data_with_progress(
        ip2_rows, by_name_country, by_country, capitals
    )

    print(f"city_locations: {len(city_locations)}")
    print(f"city_blocks: {len(city_blocks)}")

    print("Scrivo SQLite...")
    save_sqlite(city_locations, city_blocks, OUTPUT_DB)

    print("Fatto.")


if __name__ == "__main__":
    main()
