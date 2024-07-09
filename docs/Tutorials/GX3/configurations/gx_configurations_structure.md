## Struktur "gx_configurations"


| Spalte          | Typ          |
| --------------- | -----------: |
| id              | INT          |
| key             | VARCHAR(255) |
| language_id     | INT/NULL     |
| value           | INT          |
| default         | MEDIUMTEXT   |
| type            | MEDIUMTEXT   |
| sort_order      | INT          |
| legacy_group_id | INT          |
| last_modified   | TIMESTAMP    |

##### id
Primärer Schlüssel, der automatisch hochgezählt wird. Der Wert wird automatish vom System
verteilt. 

##### key
Eindeutiger Schlüssel zur Identifizierung einer Konfigurationseinstellung. Alle Konfigurationswerte
können mit Hilfe des Schlüssels ausgelesen und bearbeitet werden.

##### language_id
Für sprachabhängige Konfigurationswerte die Sprach-ID der verwendeten Sprache. Ist NULL wenn die Konfiguration
nicht sprachabhängig ist (was meisten der Fall ist).

##### value
Der Konfigurationswert in Form eines Strings. Konfigurationen, die einen anderen Typ als String erwarten müssen den
Wert zuerst weiterverarbeiten, bevor er genutzt werden kann, z.B.:

| Schlüssel         | "Roher" Wert | "Finaler" Wert |
| ----------------- | :----------: | :------------: |
| vendor/foo/active | '1'          | true           |
| vendor/bar/active | 'false'      | false          |

##### default
Der Standard Wert einer Konfiguration, der nach der Installation verteilt worden ist. Die Spalte ist neu und
soll zukünftig ermöglicchen, Einstellungswerte auf den Standard zurücksetzen zu können.

##### type
Ein willkürlicher Wert, der vom Konfigurationsystem weiterverarbetet wird, um den User-Interface
extra Informationen zum anzuzeigenden Eingabefeld bereitzustellen.

##### sort_order
Eine Nummer die zum Sortieren der Einträge verwendet wird.

##### legacy_group_id
Der Wert der Spalte "group_id" aus der alten "configuration" Tabelle oder NULL.

##### last_modified
Der Zeitstempel an dem ein Eintrag das letzte Mal bearbeitet worden ist.
