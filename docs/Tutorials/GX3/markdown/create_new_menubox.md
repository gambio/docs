# Anlegen neuer Menüboxen

In diesem Tutorial wird beschrieben, wie man mit Hilfe von Class Overloading neue Menüboxen in Frontendtemplates,
wie zum Beispiel Honeygrid, hinzufügen kann. Um zu verstehen, was Class Overloading ist und wie man es richtig einsetzt,
lies auch das Tutorial zum Class [Overloading](create_new_http_controller.md). Außerdem kann es hilfreich sein, wenn du
dir das Tutorial zu [Sprachdateien](create_new_language_phrases.md) ansiehst.


## Hinzufügen einer neuen Box

Um eine neue Box zu erstellen und dem Frontend zu übergeben sind mehrere Schritte notwendig, die sich auch darin
unterscheiden, ob der Gambio StyleEdit3 verwendet wird oder nicht. Folgende Schritte sind aber immer notwenig,
um eine neue Box zu erstellen:

Erstelle dir ein Template für deine Box. Du kannst hier auf die grundlegende Struktur der Gambio-eigenen Boxen
zurückgreifen, damit deine Box im Erscheinungsbild einer jener Boxen gleicht. Ein Beispiel für ein Box-Template im
Honeygrid, sieht wie folgt aus:

```html
{load_language_text section="box_sample"}

{include file="get_usermod:{$tpl_path}snippets/box/default/top.html" class="sample-box" headline=$txt.heading_sample}

<div id="{$content_data.BOX_ID}" class="sample-box-container">
	<p class="sample-box-text">{$txt.sample_greeting}</p>
</div>

{include file="get_usermod:{$tpl_path}snippets/box/default/bottom.html"}
```

Die beiden `includes` der `snippets/box/default/top.html` und der `snippets/box/default/bottom.html` dienen hierbei
dazu, das grundlegende Layout der Boxen im Honeygrid zu übernehmen.

Erstelle dir einen ContentView `GXModules/{Modulherstellername}/{Modulname}/Shop/Classes/SampleBoxContentView.inc.php`
für deine neue Box, um sie mit Inhalten aus dem Backend befüllen zu können. Der Inhalt deiner ContentView könnte zum
Beispiel so aussehen:

```php
class SampleBoxContentView extends ContentView
{
	public function __construct()
	{
		parent::__construct();
		$this->set_content_template('boxes/sample_box.html');
	}
	
	
	public function prepare_data()
	{
		$this->content_array['BOX_ID'] = 'sample_box_1';
	}
}
```

Erstelle dir einen Overload der Klasse LayoutContentView und lege sie unter 
`GXModules/{Modulherstellername}/{Modulname}/Shop/Overloads/LayoutContentView/SampleBoxLayoutContentView.inc.php`
ab. In diesem Overload überladst du nun die `prepare_data()`-Methode und fügst dort eine Abfrage ein, um den Status
deiner Box zu überprüfen. Sollte das Ergebnis dieser Abfrage sein, dass die Box aktiv ist, so kann nun das HTML des
Templates gerendert und die Position der Box an das Frontend übergeben werden. Der Overload könnte folgendermaßen
aussehen:

```php
class SampleBoxLayoutContentView extends SampleBoxLayoutContentView_parent
{
	public function prepare_data()
	{
		parent::prepare_data();
		
		if($GLOBALS['coo_template_control']->get_menubox_status('sample_box'))
		{
			$sampleBox = MainFactory::create_object('SampleBoxContentView');
			$boxHtml = $sampleBox->get_html();
			
			$boxPos = $GLOBALS['coo_template_control']->get_menubox_position('sample_box');
			$this->set_content_data($boxPos, $boxHtml);
		}
	}
}
```

Beachte, dass dieses Beispiel das Vorgehen abbildet, wie man sowohl in Honeygrid, als auch EyeCandy zeitgleich die
gleiche Box mit dem gleichen Inhalt erstellt. Willst du die Boxen templatespezifisch erstellen und mit Inhalt befüllen
so ist ein leicht anderes Vorgehen erforderlich. Im Overload das `LayoutContentViews` Wird nun nicht mehr das HTML
des Box-Templates gerendert und die Position der Box an das Frontend übergeben, sondern eine zusätzliche Datei
inkludiert, in der dies templatespezifisch geschieht. Diese Dateien werden typischerweise in
`templates/Honeygrid/source/boxes` und `templates/EyeCandy/source/boxes` abgelegt. Das obige Beispiel verändert
sich dann wie folgt:

```php
class SampleBoxLayoutContentView extends SampleBoxLayoutContentView_parent
{
	public function prepare_data()
	{
		parent::prepare_data();
		
		if($GLOBALS['coo_template_control']->get_menubox_status('sample_box'))
		{
			include(DIR_WS_BOXES . 'sample_box.php');
		}
	}
}
```

Der Inhalt einer `templates/Honeygrid/source/boxes/sample_box.php` sieht dann wie folgt aus:

```php
$sampleBox = MainFactory::create_object('SampleBoxContentView');
$boxHtml = $sampleBox->get_html();
			
$boxPos = $GLOBALS['coo_template_control']->get_menubox_position('sample_box');
$this->set_content_data($boxPos, $boxHtml);
```

Nun brauchst du noch Sprachdateien, um in deinem Template sprachabhängige Texte anzeigen lassen zu können. Erstelle
dir hierfür in den Ordnern `GXModules/{Modulherstellername}/{Modulname}/Shop/TextPhrases/german/` sowie
`GXModules/{Modulherstellername}/{Modulname}/Shop/TextPhrases/english/` und jeweils eine Datei die
folgendem Namensschema folgt: `box_sample.lang.inc.php.`. Der Inhalt einer solchen Sprachdatei sieht dann wie
folgt aus:

```php
$t_language_text_section_content_array = array(
	'heading_sample' => 'Beispiel Box',
	'sample_greeting' => 'Hallo Welt!',
);
```

Im Template für deine Box kannst du dann so deine Sprachdatei inkludieren und auf die definierten Sprachvariablen
zugreifen:

```html
{load_language_text section="box_sample"}

<p class="sample-box-text">{$txt.sample_greeting}</p>
```

Beachte, dass der Inhalt deiner Sprachdateien erst dann verfügbar ist, wenn du den Textcache des Shops geleert hast.
Im folgenden wird nun beschrieben, was du beachten musst, wenn du eine neue Box hinzufügen willst, wenn der Gambio
StyleEdit3 aktiv ist und was du beachten musst, wenn dieser nicht vorhanden ist.


## Besonderheiten beim Hinzufügen mit Honeygrid und StyleEdit3

Das Hinzufügen einer neuen Box erfordert noch einige zusätzliche Schritte, wenn du StyleEdit3 im Shop installiert hast
und verwendest. Damit dieser die neue Box auch findet und bearbeiten kann sind folgende zusätzliche Schritte notwendig:

Erstelle dir eine `de.<dein-name>.json` und eine `en.<dein-name>.json` und lege sie in
`StyleEdit3/templates/Honeygrid/lang` ab. Diese werden benötigt, um die Namen deiner Box oder Boxen sprachabhängig im
StyleEidt3 anzuzeigen. Der Key des JSON ist dann die Bezeichnung deiner Box und der Value der Name, der im StyleEdit3
angezeigt werden soll. Das Ergebnis sieht dann wie folgt aus:

```json
{
	"sample_box": "Beispiel Box"
}
```

Außerdem benötigt der StyleEdit3 eine zusätzliche JSON-Datei, in der die grundsätzlichen Einstellungen deiner Box
enthalten sind. Diese Konfigurationswerte sehen wie folgt aus:

```json
{
	"name": "sample_box",
	"type": "switch",
	"value": true,
	"position": 99
}
```

Beachte, dass `name` und der Key für den Namen deiner Box in deinen vorher erstellten JSON gleich sein müssen, damit
der StyleEdit3 die passenden Übersetzungen für deine Box findet.


## <a name="addwithoutstyleedit"></a>Besonderheiten beim Hinzufügen ohne StyleEdit

Auch um eine Box hinzuzufügen, wenn der Gambio StyleEdit3 nicht im Shop vorhanden ist, erfordert extra Anpassungen, damit
die Box korrekt angezeigt wird. Erstelle dir hierfür einen Overload der DefaultTemplateSettings-Klasse und lege sie in
`GXModules/{Modulherstellername}/{Modulname}/Shop/Overloads/DefaultTemplateSettings/SampleBoxDefaultTemplateSettings.inc.php`
ab. Überlade hier die Methode `setTemplateSettingsArray()` und erweitere das übergebene $settingsArray mit den notwendigen
Informationen zu deiner neuen Box. Den Aufbau des Arrays kannst du dir zum Beispiel unter
`templates/Honeygrid/template_settings.php` ansehen. Der Overload sieht dann wie folgt aus:
 
```php
class SampleBoxDefaultTemplateSettings extends SampleBoxDefaultTemplateSettings_parent
{
	public function setTemplateSettingsArray(array $settingsArray)
	{
		$settingsArray['MENUBOXES']['sample_box'] = array('POSITION' => 'gm_box_pos_99', 'STATUS' => 1);
		parent::setTemplateSettingsArray($settingsArray);
	}
}
```


## Wichtig zu beachten
Bitte beachte, dass obige Besonderheiten unbedingt beide durchgeführt werden, wenn du ein Modul für Shopbetreiber
erstellst, da du nicht sicherstellen kannst, dass der StyleEdit3 immer vorhanden ist oder nicht. Darüber hinaus
verwende keine doppelten Angaben zur Position von mehreren Boxen, da dies zu Fehlern im Frontend führen kann.

Ein vollständiges Beispiel zum Hinzufügen einer neuen Box im EyeCandy- und Honeygrid-Template findest du
[hier](../samples/menuboxes).