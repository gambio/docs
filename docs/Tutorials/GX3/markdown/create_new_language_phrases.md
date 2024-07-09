# Anlegen und Bearbeiten von Sprachdateien

In diesem Tutorial wird beschrieben, wie du neue Texte anlegen und bestehende verändern kannst sowie die
generelle Nutzung von Sprach-Phrasen.


**Inhalt:**

* <a href="#Sprachdatei allgemein">Sprachdatei allgemein</a>
    * <a href="# Was ist eine Sprachdatei und wo kann man sie finden?"> Was ist eine Sprachdatei und wo kann man sie finden?</a>
    * <a href="#Was ist eine Section?">Was ist eine Section?</a>
    * <a href="#Was sind Phrasen?">Was sind Phrasen?</a>
* <a href="#Aufbau der Sprachdateien">Aufbau der Sprachdateien</a>
    * <a href="#Phrasenerweiterung mit Verwendung von Zusatz">Phrasenerweiterung mit Verwendung von Zusatz</a>
    * <a href="#Überschreiben von Texten">Überschreiben von Texten</a>
* <a href="#Verwenden der Sprachdateien in ...">Verwenden der Sprachdateien in ...</a>
    * <a href="#PHP">PHP</a>
    * <a href="#Smarty-Template">Smarty-Template</a>
    * <a href="#Javascript">Javascript</a>
        * <a href="#Initialisierung für das Backend">Initialisierung für das Backend</a>
        * <a href="#Initialisierung für das Frontend">Initialisierung für das Frontend</a>
* <a href="#Mögliche Probleme und Lösungen">Mögliche Probleme und Lösungen</a>


## <a name="Sprachdatei allgemein"></a>Sprachdatei allgemein


### <a name=" Was ist eine Sprachdatei und wo kann man sie finden?"></a> Was ist eine Sprachdatei und wo kann man sie finden?

Standardmäßig werden alle Texte aus der Datenbank geliefert. Mit einer Spachdatei besteht die Möglichkeit, die im
Shop verwendeten Texte zu erstellen und zu ändern.

Sprachdateien legst du für dein Module unter `GXModules/{Modulherstellername}/{Modulname}/Shop/TextPhrases/{Sprache}/`
ab, wobei `{Sprache}` zum Beispiel `german` oder `englisch` sein kann.

**Wichtig**: Die Originaltexte befinden sich ausschließlich in den Sprachdateien im `lang/{Sprache}/original_sections`
Ordner. Die Datenbanktexte setzen sich dann aus den Original-Sprachdateien und anderen Sprachdateien (aus Module etc.)
zusammen sowie Textanpassungen.


### <a name="Was ist eine Section?"></a>Was ist eine Section?

Eine Section ist eine Zuordnung für die Variablen. Alle zu einem Vorgang/Modul benötigten Texte werden kategorisiert.
Beim Erstellen einer Sprachdatei wird folgende Namenskonvention verwendet:

> **[SECTIONNAME]**.lang.inc.php

oder

> **[SECTIONNAME].[ZUSATZ]**.lang.inc.php

`[ZUSATZ]` kann z. B. für eine Sortiernummer benutzt werden oder, um einen Entwickler- oder Modulnamen unterzubringen.
Das ergibt besonders dann Sinn, wenn eine bereits vorhandene Section erweitert und sichergestellt werden soll, 
dass die Datei nicht durch ein fremdes Modul überschrieben wird, das zufällig die gleiche Section nutzt.


### <a name="Was sind Phrasen?"></a>Was sind Phrasen?

Phrasen sind Texte und unterteilen sich in zwei Teile - Phrasen*namen* und Phrasen*text*. Beim Phrasennamen handelt es
sich um den Variablennamen, der später im Code verwendet wird, um den Phrasentext auszugeben.


## <a name="Aufbau der Sprachdateien"></a>Aufbau der Sprachdateien

Der typische Aufbau einer Sprachdatei sieht wie folgt aus:

```php
$t_language_text_section_content_array = array(
    'phrasen_name' => 'Ein Phrasentext, der ausgegeben wird.',
    'button_ok'    => 'Weiter'
);
```

Erkennbar ist, wie oben bereits beschrieben, dass dem Phrasennamen *button_ok* der Phrasentext *Weiter* zugewiesen
wurde.


### <a name="Phrasenerweiterung mit Verwendung von Zusatz"></a>Phrasenerweiterung mit Verwendung von Zusatz

Wird eine neue Sprachdatei `buttons.module_name.lang.inc.php` angelegt, so erweitert diese die Section `buttons` um
eine neue Phrase. Der Aufbau ist wieder derselbe:

```php
$t_language_text_section_content_array = array(
    'button_cancel' => 'Abbrechen'
);
```


### <a name="Überschreiben von Texten"></a>Überschreiben von Texten

Wenn Texte überschrieben werden sollen, müssen die Sprachdateien mit dem Section-Namen `[SECTIONNAME].lang.inc.php`
angelegt werden. Deine Sprachdateien haben eine höhere Priorität als die Original-Sprachdateien. Höchste Priorität
haben weiterhin individuelle Anpassungen, die im Admin unter dem Menüpunkt **Toolbox > Texte anpassen** vorgenommen
werden können. Diese Textanpassungen werden in der Datenbank gespeichert.
Dein Verzeichnis für Sprachdateien wird rekursiv ausgelesen, weshalb es keine Rolle spielt, wo sich eine Sprachdatei
darin befindet. Zur besseren Übersicht kann also eine Ordnerstruktur angelegt werden.


## <a name="Verwenden der Sprachdateien in ..."></a>Verwenden der Sprachdateien in ...

### <a name="PHP"></a>PHP

Für die Verwendung in PHP muss über die MainFactory ein Objekt vom Typ `LanguageTextManager` für die Section (z.B.
`buttons`) erzeugt werden. Mit der Methode `get_text()` kann dann z.B. auf die Texte `button_ok` und `button_cancel`
zugegriffen werden.

```php
$languageTextManager = MainFactory::create('LanguageTextManager', 'buttons');
$okButton            = $languageTextManager->get_text('button_ok'); // OK
$cancelButton        = $languageTextManager->get_text('button_cancel'); // Abbrechen
```

Die Texte werden in der Sprache der aktuellen Sitzung zurückgeliefert. Die Sprache kann auch explizit angegeben
werden. Dazu wird der MainFactory die Sprach-ID als zweites Argument übergeben:

```php
$englishLanguageId = 1 // english language ID

$languageTextManager = MainFactory::create('LanguageTextManager', 'buttons', $englishLanguageId);
$okButton            = $languageTextManager->get_text('button_ok'); // OK
$cancelButton        = $languageTextManager->get_text('button_cancel'); // Cancel
```

Existiert bereits ein `LanguageTextManager`-Objekt, kann dieses ebenso genutzt werden. Falls es noch nicht die
gewünschte Section geladen hat, kann diese in der `get_text()`-Methode angegeben werden. Ebenso die Sprache.

```php
$englishLanguageId = 1; // english language ID

$okButton          = $languageTextManager->get_text('button_cancel', 'buttons'); // Abbrechen
$cancelButton      = $languageTextManager->get_text('button_cancel', 'buttons', $englishLanguageId); // Cancel
```


### <a name="Smarty-Template"></a>Smarty-Template

Das Laden einer Sprachdatei in Smarty erfolgt mit folgender Anweisung:

```
{load_language_text section="buttons"}
```

Anschließend kann innerhalb des Templates die einzelnen Textvariablen in dem Format `{$txt.PHRASEN_NAME}` eingesetzt
werden (z.B. `{$txt.street}` oder `{$txt.city}`).

Es ist auch möglich die Phrasen einer Sprachdatei für das Template über einen Namen zu gruppieren.

```
{load_language_text section="buttons" name="buttons"}
```

Anschließend kann dann über diesen Namen auf die Phrasen zuzugreifen werden: `{$buttons.PHRASEN_NAME}`


### <a name="Javascript"></a>Javascript

Nach der Initialisierung kann in Javascript ein Text wie folgt abgerufen werden:

```js
// jse.core.lang.translate([PHRASEN_NAME], [JS_SECTION_NAME])
const buttonLabel = jse.core.lang.translate('paylink', 'paypal3');
```


#### <a name="Initialisierung für das Backend"></a>Initialisierung für das Backend

Sobald im Controller die gerenderte Seite über ein AdminPageHttpControllerResponse-Objekt erzeugt wird, gibt man bei
der Objekt-Instanziierung als vierten Parameter ein Array der zu ladenden Sections an:

```php
MainFactory::create('AdminPageHttpControllerResponse', $title, $html, null, array('buttons'))
```


#### <a name="Initialisierung für das Frontend"></a>Initialisierung für das Frontend

Über die PHP-Klasse `JSEngineConfiguration` werden die Sections für das JavaScript geladen (ab GX3.1.1). Um eigene
Sections hinzuzuführen ist ein Overload der Methode `_getSections` notwendig. Ein Beispiel:

```php
protected function _getSections()
{
    $additionalSection = array('js_section_name' => 'section_name');
    $this->sections = array_merge($this->sections, $additionalSection);
    
    return parent::_getSections();
}
```

Die Section `section_name` steht nun unter dem Namen `js_section_name` im JavaScript zur Verfügung. In der Regel macht 
es Sinn keinen abweichenden Namen für `js_section_name` zu wählen, also z. B. für das Laden der paypal3-Section so 
vorzugehen:

```php
protected function _getSections()
{
    $additionalSection = array('paypal3' => 'paypal3');
    $this->sections = array_merge($this->sections, $additionalSection);
    
    return parent::_getSections();
}
```


## <a name="Mögliche Probleme und Lösungen"></a>Mögliche Probleme und Lösungen

* **Smarty-Template**:
  Standardmäßig werden die Textvariablen mit dem Präfix `txt` bereitgestellt. Werden mehrere Sprachdateien eingebunden,
  kann es zu Konflikten bei den Namen kommen. Um Konflikte bei mehreren Sprachdateien zu vermeiden, kann man ein Präfix
  angeben.
  ```
  {load_language_text section="buttons" name="button"}
  ```
  Die Texte aus der Section `buttons` stehen nun mit dem Präfix `button` zur Verfügung, z. B. `{$button.ok}` oder
  `{button.cancel}`

* **Die Änderungen an einer Sprachdatei werden nicht angezeigt**:
  Nach dem Hinzufügen neuer Sprachdateien sollten über den Adminbereich auf der Seite **Cache** die Punkte **Cache für
  Seitenausgabe leeren** , **Cache für Modulinformationen leeren** und **Cache für Texte leeren** ausgeführt werden.

* **Manuelle Änderungen in der Datenbank-Tabelle language_phrases_cache werden nicht angezeigt**:
  Es handelt sich um eine reine Cache-Tabelle, in der Änderungen fehl am Platz sind und verlorengehen. Änderungen sind
  über Sprachdateien oder über die **Texte anpassen**-Funktion im Admin durchzuführen.

* Bei Text-Fehlanzeigen sollte geprüft werden, ob das richtige Encoding für die Sprachdatei gewählt wurde:
  **UTF-8 ohne BOM**.
