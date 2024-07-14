## Konfigurationsspeicher vor GX 4.1

Vor der Version 4.1.1.0 gab es im Shopsystem mehrere Datenbank Tabellen, in denen Konfigurationswerte gespeichert worden
sind. Sie hatten alle eine änhliche Struktur, wurden aber an unterschiedlichen Stellen verwendet. Hierzu gehörten:

- `configuration`
- `configuration_storage`
- `gm_configuration`
- `gm_contents`

Jede Tabelle hatte ein Attribut für den Konfigurationsschlüssel, sowie den Wert. Außerdem hatte jede Tabelle noch
zusätzliche Attribute, die im nächsten Abschnitt beschrieben werden.

Da jedoch mit GX 4.1 das System zum Speichern und Auslesen von Konfigurationswerten überarbeitet wurde, gehen wir aus
Verständnisgründen zunächst einmal auf das alte System ein, bevor wir das neue System erklären.


#### `configuration` Tabelle

Die Tabelle `configuration` ist die wahrscheinlich älteste von allen Konfigurationstabellen gewesen. Ein zentraler 
Mechanismus in der Datei `applcation_top.php` hat die gesamte Datenbank Tabelle ausgelesen und auf Basis der
Konfigurationsschlüssel, sowie deren jeweiligen Werten, Konstanten in PHP definiert. So konnten alle Konfigurationen,
die in der Tabelle gespeichert waren, im gesamten Shopsystem in Form von PHP Konstanten verwendet werden.  

Globale Konstanten werden in der PHP-Community als Bad-Practise betrachtet. Weshalb der neue Anwendugskern die
Werte nicht mehr als Konstante definieren. Für das alte System ist ein Fallback Mechanismus entwickelt worden, so dass 
dort weiterhin die Konfigurationen als Konstante zur Verfügung stehen.

Einstellungen konnten in verschiedenen Bereichen im Gambio Admin vorgenommen werden. Immer wenn die Url auf 
`.../admin/configuration.php?gID=[Nummer]` endete, wurde eine dynamisch generierte Einstellungsseite geladen.  
`[Nummer]` muss entspricht dabei einer bestimmten Zahl, der *group_id*.  
In der alten Datenbank Tabelle gab es ein Attribut mit den selben Namen und mittels dieser Nummer wurden die
Konfigurationen zu verschiedenen Bereichen gruppiert.

Die Versand-, Zahlungs- und Zusammenfassungsmodule, sowie das Module-Center benutzten die Tabelle auch.

Zusätzlich gab es zwei weitere Attribute mit den Namen "use_function" und "set_function", die über einen komplexen
Mechanismus Zusatzinformationen für das User-Interface bereitgestellt haben.


##### Vergleich zu gx_configurations

| Attribute    | gx_configurations              |
|--------------|:------------------------------:|
| group_id     | umbenannt zu 'legacy_group_id' |
| use_function | ersetzt durch 'type'           |
| set_function | ersetzt durch 'type'           |

| Schlüssel     | gx_configurations           |
|---------------|:---------------------------:|
| MY_CONFIG_KEY | configuration/MY_CONFIG_KEY |
| my-config-key | configuration/my-config-key |


#### `configuration_storage` Tabelle

Die Tabelle `configuration_storage` ist die jüngste Konfigurationstabelle gewesen. Ähnlich wie bei die anderen Datenbank
Tabellen besaß sie ein Attribut für den Konfigurationsschlüssel und den dazugehörigen Wert.  
Der Unterschied zu den anderen Tabellen ist hier das Format des Schlüssels und die Art und Weise der Gruppierung von
Konfigurationswerten.

Verschiedene Konfigurationswerte konnten hier mit Hilfe eines *Namespaces* gruppiert werden, wobei Namespace und
Konfigurationsschlüssel durch einen Slash (/) getrennt wurden.

Die Tabelle `configuration_storage` ist in aller Regel für neue Features im Gambio Shop verwendet worden. 
Auch GXModules, sowie Module die eine *GXModules Konfigurationsdatei* benutzen, haben die Einstellungen in der
`configuration_storage` Tabelle gespeichert.

Im Update zur Shop-Version 4.1.1.0 wurden zwar die Schlüssel der Konfigurationstabellen mit einen Prefix versehen (siehe
oben/unten), jedoch stellt die `configuration_storage` Tabelle hier eine Ausnahme dar.
Man kann es sich in etwa so vorstellen, dass die Prefixes der anderen Konfigurationen nun ein Namespace sind, um eine
Unterscheidung zwischen den Tabellen treffen zu können.

| Schlüssel         | gx_configurations |
|-------------------|:-----------------:|
| vendor/module/key | vendor/module/key |


#### `gm_configuration` Tabelle

Die Tabelle `gm_configuration` hat nur ein Attribut für den Konfigurationsschlüssel und dem dazugehörigen Wert. Um
Einstellungen in der Tabelle zu aktualisieren benutzte man die Funktion "gm_set_conf". Zum Abfragen von
Konfigurationswerten stand die Funktion "get_get_conf" zur Verfügung.

Die beiden Funktionen sind in der Version 4.1.1.0 aktualisiert worden, sodass sie auf Basis der neuen Tabelle arbeiten,
ohne dass die Stellen, welche die Funktionen verwenden angepasst werden müssen.

| Schlüssel     | gx_configurations              | language_id |
|---------------|:------------------------------:|: ----------:|
| MY_CONFIG_KEY | gm_configuration/MY_CONFIG_KEY | null        |
| my-config-key | gm_configuration/my-config-key | null        |


#### `gm_contents` Tabelle

Die Tabelle `gm_contents` besitzt alle Attribute der alten `gm_configuration` Tabelle und zusätzlich das Attribut
`language_id`. So konnten Sprachabhängige Konfigurationswerte gespeichert und abgerufen werden, wofür es die Funktionen
`gm_set_content` und `gm_get_content` gab.

Zur Version 4.1.1.0 sind die beiden Funktionen aktualisiert worden, sodass auch sie auf Basis der neuen Tabelle
`gx_configuration` arbeiten.

| Schlüssel     | gx_configurations              | language_id  |
|---------------|:------------------------------:|: -----------:|
| MY_CONFIG_KEY | gm_configuration/MY_CONFIG_KEY | integer      |
| my-config-key | gm_configuration/my-config-key | integer      |
