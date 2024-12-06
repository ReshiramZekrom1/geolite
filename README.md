# __GeoLite__ (SQLite)

# UPDATE DECEMBER 2024

I've managed to update the country database only since the old one was indeed just too old. It's based on the [IP2LocationLite](https://lite.ip2location.com/database/db1-ip-country) database though. 

In case you'd like to update it again, you can use the crappy but functioning tool I made with PHP. Just follow those passages:

1. Download the IP2Location Lite Country DB in .CSV from [here](https://lite.ip2location.com/database/db1-ip-country) (Requires signing-up). The CSV db should look like the one in the repository.
2. Open the CSV file with Notepad++.
3. Copy all the content and paste it in the PHP page you can find it in the repository (just upload it on a free website or smth).
4. Click on "Genera" and copy the output.
5. Now you have to convert the text in SQL, I used this [website](https://konbert.com/convert/txt/to/sqlite).
6. Download the SQL file, and replace that table to the "country_block" table of the "maxmind_country.db" of GeoLite. You can use any SQL editor to do so.
7. Make sure that the file structure is exactly the same of the original and Try it :)




-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

It is based on the free product [GeoLite2](https://dev.maxmind.com/geoip/geoip2/geolite2/) by [MaxMind](https://www.maxmind.com/en/home).

I was updating the country database every month for MySQL and decided to update the GeoIp databases by Whitetiger's include as many people requested. It turned out I was unable to, the way the databases were structured. I converted my version to SQLite and started comparing the two includes with geolite.inc being victorious. But this was to be expected with not only the good database structure and the use of indexes but also the appropriate queries to avoid range scans. Even though latest database provide more data than last year, it did not affect the performance in any way.

The past days, I managed to import Autonomous System (AS) and City databases with the original databases having big flows.

* Certain organizations in Autonomous System list did have many unique identifiers (ASN - Autonomous System Number) registered to IANA. All duplicates were removed and kept only their initial ASN.
* Certain ip ranges in City database:
  * did not provide a city name. Country name was used in replacement.
  * did not provide a city name, nor a country name. Continent name was used in replacement.

The above issue arose another problem related to time zones.
* Antarctica, Asia and Europe have time zone set as +00:00
* Cities with country name as replacement have central standard time set mostly, with few exceptions. Some examples are:
  * United States is set to have UTC -05:00 (Washington, DC) whereas Central Standard Time is in Chicago (-06:00)
  * Russia is set to Moscow Standard Time (+03:00)

I initially posted these changes and improvements in Whitetiger's thread but due to their absence, I decided to create a new thread. I was also unaware if Whitetiger would accept the changes, nor how the updates would be done.

# __Installation__

Repository: https://github.com/George480/geolite

Releases: https://github.com/George480/geolite/releases

Include: https://raw.githubusercontent.com/George480/geolite/master/geolite.inc

Save as geolite.inc into _pawno\include_ folder. Include in your code and begin using the library:

```Pawn
#include <geolite>
```

Place the database you want to use into _scriptfiles_ folder.

# __Functions__
IP-Based Functions:
```Pawn
GetIpAutonomousSystem(const geolite_ip[], geolite_dest[], geolite_len = sizeof (geolite_dest))
```
  * Stores the Autonomous System organization (ISP is an Autonomous System) according to given IP, passed by reference.
  * Returns 1 on success (database file exists in _scriptfiles_ folder) or 0 on failure.

```Pawn
GetIpCountry(const geolite_ip[], geolite_dest[], geolite_len = sizeof (geolite_dest))
```
  * Stores the Country name according to given IP, passed by reference.
  * Returns 1 on success (database file exists in _scriptfiles_ folder) or 0 on failure.

```Pawn
GetIpCity(const geolite_ip[], geolite_dest[], geolite_len = sizeof (geolite_dest))
```
  * Stores the City name according to given IP, passed by reference.
  * Returns 1 on success (database file exists in _scriptfiles_ folder) or 0 on failure.

```Pawn
GetIpUTC(const geolite_ip[], geolite_dest[], geolite_len = sizeof (geolite_dest))
```
  * Stores the UTC offset according to given IP, passed by reference.
  * Returns 1 on success (database file exists in _scriptfiles_ folder) or 0 on failure.
  
```Pawn
IsIpProxy(const geolite_ip[])
```
  * Requires country database. 
  * Returns 1 if the given ip is public proxy otherwise 0. It will also return 0 if database file does not exist in _scriptfiles_ folder

Player-Based Functions:
```Pawn
GetPlayerAutonomousSystem(playerid, geolite_dest[], geolite_len = sizeof (geolite_dest))
```
  * Stores the Autonomous System organization (ISP is an Autonomous System) according to given player's IP, passed by reference.
  * Returns 1 on success (database file exists in _scriptfiles_ folder and player is connected) or 0 on failure.
  
```Pawn
GetPlayerCountry(playerid, geolite_dest[], geolite_len = sizeof (geolite_dest))
```
  * Stores the Country name according to given player's IP, passed by reference.
  * Returns 1 on success (database file exists in _scriptfiles_ folder and player is connected) or 0 on failure.
  
```Pawn
GetPlayerCity(playerid, geolite_dest[], geolite_len = sizeof (geolite_dest))
```
  * Stores the City name according to given player's IP, passed by reference.
  * Returns 1 on success (database file exists in _scriptfiles_ folder and player is connected) or 0 on failure.
  
```Pawn
GetPlayerUTC(playerid, geolite_dest[], geolite_len = sizeof (geolite_dest))
```
  * Stores the UTC offset according to given player's IP, passed by reference.
  * Returns 1 on success (database file exists in _scriptfiles_ folder and player is connected) or 0 on failure.
  
```Pawn
IsPlayerUsingProxy(playerid)
```
  * Requires country database. 
  * Returns 1 if the ip of the given player is public proxy otherwise 0. It will also return 0 if database file does not exist in _scriptfiles_ folder


# __Usage__
```Pawn
#include <a_samp>
#include <sscanf2>
#include <geolite>

main() {}

public OnPlayerConnect(playerid)
{
    new player_name[MAX_PLAYER_NAME], player_country[MAX_COUNTRY_LENGTH], connection_text[80];
	    
    GetPlayerName(playerid, player_name, MAX_PLAYER_NAME);
    GetPlayerCountry(playerid, player_country, MAX_COUNTRY_LENGTH);

    format(connection_text, sizeof (connection_text), "%s joined from %s", player_name, player_country);
    SendClientMessageToAll(0xFFFF00FF, connection_text);
    return 1;
}
```

# __Extra Notes__
127.0.0.1 is given as "Unknown" because it is a private IP.

Country, City and ASN databases will be updated every first Wednesday of every month.

It opens the databases on startup according to which database exists in _scriptfiles_ folder, therefore if you prefer to use the Country database only, place maxmind_country.db into _scriptfiles_ folder and not the other two databases.

It only detects public proxies and not VPNs.

A MySQL version would require non-threaded queries to keep the same usage of functions. If you have any suggestion, please inform me.

Constants:
```Pawn
#define MAX_AUTONOMOUS_SYSTEM_LENGTH    95
#define MAX_COUNTRY_LENGTH              45
#define MAX_CITY_LENGTH                 109
#define MAX_UTC_LENGTH                  7
```

# __Requirements__
sscanf: https://github.com/maddinat0r/sscanf/releases

# __Credits__

* [MaxMind](https://www.maxmind.com/en/home) - [GeoLite2](https://dev.maxmind.com/geoip/geoip2/geolite2/)
* [TimeZoneDB.com](https://timezonedb.com/) - time zones
* [Alex "Y_Less" Cole](https://github.com/Y-Less) - [sscanf](https://github.com/maddinat0r/sscanf/releases)
* [Andy Skelton](https://andy.wordpress.com/author/andy/) - ordering by `ip_to` (avoidance of range scan)
* Nikolay Bachiyski - ordering by `ip_to` (avoidance of range scan)
* Mark Robson - highest `ip_from` which is less than or equal to the given IP (avoidance of next country returned due to gaps)
