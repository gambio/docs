# Erweitern der neuen Bestellübersicht

Die neue Bestellübersicht soll dem Shopbetreiber möglichst schnell einen Überblick über alle Informationen zu einer 
Bestellung liefern. Zu diesem Zweck gibt es die Möglichkeit dynamisch Tabellenspalten hinzuzufügen oder zu entfernen, 
die die Tabelle um zusätzliche Informationen erweitert. Weiter ist es ebenfalls Möglich zusätzliche Bulk- sowie
Zeilen-Aktionen hinzuzufügen.

Dieses Tutorial veranschaulicht zum einen anhand eines Beispiels, wie du die Tabelle der Bestellübersicht, um eine
neue Spalte erweiterst und zum anderen wie du neue Bulk-Aktionen bzw. neue Zeilenaktionen zu der Bestellübersicht
hinzufügen kannst. 

## Erweitern der neuen Bestellübersicht um eine neue Tabellenspalte

Hierfür musst du sowohl PHP-Klassen als auch JavaScripte anpassen. Da für die Anzeige der Tabelle das jQuery-Plugin
'DataTables' verwendet wird, könnte es sinnvoll sein, die Dokumentation dieses Plugins als zusätzliche 
[Informationsquelle](https://datatables.net/manual/index) zu nutzen.

### Anpassen des PHP

Folgende Klassen musst du anpassen, um der Bestellübersicht eine neue Spalte hinzuzufügen:

* OrdersOverviewColumns
* OrdersOverviewController
* OrdersOverviewAjaxController

Beginne mit der OrdersOverviewColumns-Klasse. Im Konstuktor der Klasse findest du eine Reihe von Einträgen, an denen du 
dich orientieren kannst. Um hier die Basis für eine neue Tabellen-Spalte zu schaffen, erstelle einen Overload der Klasse.
In diesem überlädst du den Konstruktor der Original-Klasse wie folgt:

```php
public function __construct()
{
	parent::__construct();
        	
    // Custom
    $this->columns[] = MainFactory::create('DataTableColumn')
                               		->setTitle(new StringType('Test'))
                               		->setName(new StringType('customTest'))
                               		->setType(new DataTableColumnType(DataTableColumnType::STRING));
}
```

Dies erzeugt eine neue Tabellenspalte mit dem Titel 'Test' und dem Namen 'customTest', welche einen String enthalten kann.
Für die setType-Methode kannst du folgende Typen verwenden:

* DataTableColumnType::STRING: Ermöglicht die Suche nach einem bestimmten String.
* DataTableColumnType::NUMBER: Ermöglicht die Suche nach einer bestimmten Nummer oder einem definierten Nummern-Bereich.
* DataTableColumnType::DATE: Erzeugt einen Daterange-Picker für den Filter der Tabelle.

Zusätzlich zu den im Beispiel verwendeten Setter-Methoden, kannst du noch folgende verwenden:

```php
->setOptions([
    ['value' => 'val1', 'text' => 'text1'],
    ['value' => 'val2', 'text' => 'text2']
]);
```

Dies kannst du verwenden, um zusätzliche Parameter zur Filterung zu übergeben.

```php
->setSource('https://example.org/admin/admin.php?do=CustomController/GetOptions');
```

Dies kannst du verwenden, um eine andere Quelle für die Daten der Spalte zu definieren.
Wenn du eine der zusätzlichen Setter-Methoden in Kombination mit dem Typ String verwendest, erzeugt dies im Filter ein
Multiselect-Dropdown, mit den möglichen Filterwerten.

Anschließend musst du den OrdersOverviewController anpassen. Erstelle dir auch hier einen Overload der Klasse in dem du
folgende Methode überlädst:

```php
protected function _getAssetsArray()
{
	$assetsArray = parent::_getAssetsArray();
    $assetsArray[] = MainFactory::create('Asset', DIR_WS_CATALOG.'GXUserComponents/modules/add_custom_column.js');
    		
    return $assetsArray; 
}
```

Dies sorgt dafür, dass du JavaScripte einbinden kannst, die du zum Erweitern der Tabelle benötigst. Solltest du zusätzlich
noch Sprachvariablen benötigen, die bisher nicht zur Verfügung stehen, kannst du auch hier den eben erstellten Overload
benutzen. Erweitere hier das $assetsArray um folgenden Eintrag:

```php
$assetsArray[] = MainFactory::create('Asset', 'your_custom.lang.inc.php');
```

Fahre nun mit dem OrdersOverviewAjaxController fort, um deine neue Tabellenspalte mit Inhalt befüllen zu können.
Erstelle dir auch hier einen Overload der Klasse in welcher du die Methode _getTableData() überlädst.

```php
protected function _getTableData()
	{
		$tableData = parent::_getTableData();
		
		foreach($tableData as &$row) 
		{
			$row['customTest'] = 'Test Data'; 
		}
		
		return $tableData;
	}
```

Dies fügt deiner definierten Spalte 'customTest' den String 'Test1234' als Inhalt hinzu.

### Anpassen des JavaScript

Nachdem du nun die notwendigen PHP-Klassen erweitert hast, musst du nun das JavaScript anpassen, damit die neu hinzu-
gekommene Spalte angezeigt und mit Inhalt befüllt wird. Lege dir hierfür eine neue JavaScript-Datei an. In diesem Beispiel
handelt es sich um die 'add_custom_column.js':

```js
$(function() {
	'use strict';
        
    jse.libs.orders_overview_columns = jse.libs.orders_overview_columns || {};
        
    jse.libs.orders_overview_columns.customTest = {
    	data: 'customTest',
        minWidth: '75px',
        widthFactor: 0.9
    };
});
```

Mit obigen Beispiel erzeugst du ein orders_overview_columns-Objekt mit bestehendem Inhalt - sollte es schon ein solches
Objekt geben - und befüllst es mit Informationen zu deiner neu erstellten Spalte. 
Das orders_overview_columns-Objekt erweiterst du nun mit deiner neuen Spalte, im Beispiel 'customTest'. Hierfür musst du
folgende Werte an das DataTables-Plugin übergeben:

* **data:** Inhalt der Spalte
* **minWidth:** Minimale Breite der Spalte. Kleiner kann die Spalte nicht werden und wird ausgeblendet, sollte sie beim
  Skalieren der Seite nicht mehr auf den Bildschirm passen.
* **widthFactor:** Faktor um den die Mindestbreite vergrößert wird, sollte genug Bildschirmfläche vorhanden sein.

Folgender Teil der Dokumentation von jQuery-DataTables kann dabei helfen, die Tabelle zu erweitern: 
[https://datatables.net/reference/option](https://datatables.net/reference/option) Wähle hier **DataTables - Columns**
aus, um die wichtigsten Informationen zu erhalten.

Alle Anpassungen aus den Beispielen findest du [hier](../samples/orders-overview).


## Erweitern der Bestellübersicht um eine neue Bulk-Aktion

Um eine neue Bulk-Aktion hinzufügen zu können, muss die Tabelle zunächst vollständig initialisiert sein. 
Anschließend kannst du mit Hilfe der `jse.libs.button_dropdown` Bibliothek eine neue Bulk-Aktion hinzufügen. 

```js
$(function() {
    'use strict';
    
    const $table = $('.table-main'); 
    
    $table.on('init.dt', function() {
        const isDefault = $table.data('defaultBulkAction') === 'custom-bulk-action'; 
        jse.libs.button_dropdown.addAction($('.bulk-action'), {
            text: 'Custom Bulk Action', 
            href: 'customModule.php',
            data: {configurationValue: 'custom-bulk-action'},
            isDefault: isDefault,
        });
    });
}); 
```

Die Nutzung der `isDefault` Variable ist notwendig, damit die vom Nutzer zuletzt gewählte Aktion standardmäßig
ausgewählt ist. Weitere Informationen zu den möglichen Optionen findest du in der
[Beispieldatei](../samples/orders-overview/add_custom_bulk_action.js).


## Erweitern der Bestellübersicht um eine neue Zeilenaktion

Um eine neue Zeilenaktion hinzufügen zu können, muss die Tabelle zunächst vollständig initialisiert sein. Zusätzlich
muss die Zeilenaktion jedesmal neu initialisert werden, sobald die Tabelle neu gerendert wird. Anschließend kannst du
mit Hilfe  der `jse.libs.button_dropdown` Bibliothek eine neue Zeilenaktion hinzufügen. 

```js
$(function() {
    'use strict';
    
    const $table = $('.table-main'); 
    $table.on('init.dt', function() {
        function _addRowAction() {
            const isDefault = $table.data('defaultRowAction') === 'custom-row-action';

            $table.find('tbody .btn-group.dropdown').each(function(index, dropdown) {
                const order = $(this).parents('tr').data();
                jse.libs.button_dropdown.addAction($(dropdown), {
                    text: 'Custom Row Action - #' + order.id,
                    href: 'customModule.php?orderId=' + order.id,
                    data: {configurationValue: 'custom-row-action'},
                    isDefault: isDefault,
                });
            });
        }
        
        $table.on('draw.dt', _addRowAction);
        _addRowAction(); 
    });
}); 
```

Die Nutzung der `isDefault` Variable ist notwendig, damit die vom Nutzer zuletzt gewählte Aktion standardmäßig
ausgewählt ist. Weitere Informationen zu den möglichen Optionen findest du in der
[Beispieldatei](../samples/orders-overview/add_custom_row_action.js).
