# PHP Richtlinien

**Hinweis:** Diese Seite enthält veraltete Informationen und wird bald überarbeitet.


## Allgemein

- Benennung von Variablen und Funktionen erfolgt in lowerCamelCase-Notation

- Konstanten werden in Großbuchstaben definiert

- Es wird `E_NOTICE`-, `E_STRICT`-, und `E_DEPRECATED`-sicher programmiert

- PHP-Short-Tags sind nicht erlaubt: `<?php` statt `<?`

- Keinen schließenden PHP-Tag `?>` in reinen PHP-Dateien, die keine Ausgaben erzeugen

- Globale Variablen sind verboten

- Dateien, die PHP-Code enthalten, haben die Dateiendung `.php`

- Inkludierte Dateien haben die Dateieindung `.inc.php` und liegen niemals im Haupt- oder Admin-Verzeichnis

- Funktionen gehören in den `inc`-, nicht in den `gm/inc`-Ordner

- Klassen gehören in den passenden `system/GxEngine`-Ordner, nicht in den `gm/classes`-Ordner

- Ein `xtc_db_fetch_array()`, das nicht in einer `while`-Schleife ist, wird erst ausgeführt,
 wenn sichergestellt wurde, dass das `result` ein Ergebnis geliefert hat. Hierfür bietet
 sich `xtc_db_num_rows()` an

- Kein `exit` oder `die()`, ohne voherhiges Schließen der Datenbankverbindung über `xtc_db_close()`

- Jede PHP-Datei hat einen `Gambio-GPL-Header`

- Dateien, wie z. B. Log-Dateien, die sensible Daten enthalten und von außen erreichbar sind, sind mit einem
  Token im Namen zu schützen. Ein Token kann mittels `LogControl::get_secure_token()` generiert werden.

- **Keine hardgecodeten Texte nutzen**. Texte gehören in die Datenbank/Sprachdateien

- Leerzeichen in Datei- und Ordnernamen sind nicht erlaubt. Erlaubte Zeichen sind `a-Z, 0-9, -, _, .`

- Dateien, die Klassen oder Funktionen enthalten, sind mittels `require_once` oder `include_once` einzubinden

- Öffnende, geschweifte Klammern gehören in eine eigene Zeile

- Beim Casten kommt zwischen Datentyp und Variable kein Leerzeichen


## Prä- und Suffixe

- `_count`, als Zählervariable außerhalb einer Schleife

- `_` -Präfix für protected- und private Methoden

```php
<?php

class MyClass
{
    private function _myPrivateMethod()
    {
        // Code
    } 
}
```

## Dokumentation

- PHPDoc ist Pflicht


## Legacy Code

- Globale Variablen sollten nicht in Funktionen oder Methoden genutzt, sondern stattdessen als
  Klassenvariable oder Parameter übergeben werden. Gibt es keinen anderen Weg, sollte das `$GLOBALS`-Array
  zum Ansprechen der Variable verwendet werden.


## Regeln aus _"Objektorientierte Programmierung"_ von thePHP.cc

**Regel: Eine Bildschirmseite**
Eine Methode darf nicht länger als eine Bildschirmseite sein. 
Längere Methoden müssen in mehrere kleinere Methoden heruntergebrochen werden.

**Regel: Kleine öffentliche APIs**
Die öffentliche API einer Klasse ist immer so klein wie möglich. 
Methoden sind standardmäßig private/protected und werden nur dann öffentlich gemacht, 
wenn ihre Funktionalität auch tatsächlich außerhalb der Klasse benötigt wird.

**Regel: Deklarierte Instanzvariablen**
Alle Instanzvariablen werden am Beginn der Klasse deklariert.

**Regel: Minimale Sichtbarkeit**
Attribute sind immer private/protected. Es gibt keine öffentlichen Attribute.

**Regel: Keine echte Arbeit im Konstruktor**
Im Konstruktor werden Objekte in einen sinnvollen Ausgangszustand versetzt. 
Es findet keine produktive Arbeit statt, insbesondere wird nicht auf das Dateisystem oder
auf externe Prozesse oder Systeme zugegriffen.

**Regel: Dokumentierte APIs**
Die API jeder Klasse wird immer mit DocBlocks kommentiert, 
die neben einer @return-Annotation für jeden Parameter eine @param-Annotation enthalten.

**Regel: Type Hints**
Für Arrays und Objekte als Methoden- und Konstruktorparameter werden immer Type
Hints verwendet.

**Regel: Code-Duplikation vermeiden**
Code-Duplikation wird vermieden, indem Funktionalität an ein kollaborierendes Objekt delegiert wird.

**Regel: Interfaces dokumentieren**
Jede in einem Interface definierte Methode wird mit DocBlocks kommentiert, 
welche neben einer @return-Annotation für jeden Parameter eine @param-Annotation enthalten.

**Regel: Interfaces als Type Hints**
Anstatt Klassen als Type Hints zu verwenden, definieren Sie ein Interface, 
das die aufzurufenden Methoden enthält, und verwenden dieses als Type Hint.

**Regel: Durchgängig Autoload**
Klassen werden immer per Autoload geladen. Ein Autoloader sucht nicht, sondern
weiß bereits, aus welchen Dateien der benötigte Code zu laden ist.

**Regel: Dependency Injection**
Alle Abhängigkeiten eines Objektes werden in der API explizit gemacht und mittels
Dependency Injection an die Objekte übergeben.

**Regel: Pflichtabhängigkeiten als Konstruktorparameter**
Diejenigen Abhängigkeiten, die ein Objekt immer benötigt, werden zu Konstruktorparametern.

**Regel: Komposition statt Vererbung**
Vererbung kommt zur Wiederverwendung von Code nur im Rahmen einer ”ist-ein”-Beziehung zum Einsatz. 
Ansonsten ist Objektkomposition (kollaborierende Objekte) der Vererbung vorzuziehen.

**Regel: Sinnvolle Rückgabewerte oder Exception**
Rückgabewerte müssen verlässlich sein. Wenn Code keinen sinnvollen Rückgabewert
liefern kann, dann muss er eine Exception werfen.

**Regel: Fehlerfortpflanzung vermeiden**
Rückgabewerte von Code, der keine Exceptions verwendet, müssen frühzeitig und
möglichst strikt geprüft werden, um Fehlerfortpflanzung zu vermeiden.

**Regel: Spezifische Exceptions**
Exceptions müssen durch Subklassenbildung oder Exception-Codes spezifisch genug
sein, damit der aufrufende Code den Fehler sinnvoll verarbeiten kann.

**Regel: Benachrichtigungen und Warnungen sind Fehler**
Programme dürfen keinerlei Fehlermeldungen, Warnungen oder Benachrichtigungen
der Typen E_NOTICE, E_USER_NOTICE, E_WARNING, E_USER_WARNING, E_USER_ERROR,
E_STRICT, E_DEPRECATED und E_USER_DEPRECATED erzeugen.

**Regel: Wertobjekte sind unveränderlich**
Wertobjekte können nach Initialisierung durch den Konstruktor nicht mehr verändert
werden.

**Regel: Keine Arbeit im Destruktor**
In Destruktoren wird niemals produktive Arbeit erledigt.

**Regel: Explizite APIs**
Explizite APIs sind impliziten APIs vorzuziehen.

**Regel: Keine Singletons**
Es gibt in PHP keinen validen Anwendungsfall für Singletons. Ihre Verwendung ist daher verboten.


## Quellcode Beispiele

**Präfix und Suffix**

```php
<?php
/* --------------------------------------------------------------
   MySampleClass.inc.php 2016-02-12
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

/**
 * Class MySampleClass
 */
class MySampleClass
{
    /**
     * @var array
     */
    protected $multiselectArray = array();

    /**
     * @var xtcPrice
     */
    protected $xtcPrice;

    /**
     * @var string
     */
    protected $type;


    /**
     * @param array    $multiselectArray
     * @param xtcPrice $xtcPrice
     */
    public function __construct(array $multiselectArray, xtcPrice $xtcPrice)
    {
        $this->multiselectArray = $multiselectArray;
        $this->xtcPrice         = $xtcPrice;
        $this->type             = 'test';
    }


    /**
     * @param array $multiselectArray
     */
    public function setMultiselectArray(array $multiselectArray)
    {
        foreach($multiselectArray as $key => $id)
        {
            $this->multiselectArray[$key] = (int)$id;
        }
    }


    /**
     * execute random sql query build in MySampleClass::_getSampleQuery()
     */
    public function executeSampleQuery()
    {
        xtc_db_query($this->_getSampleQuery());
    }


    /**
     * @return string
     */
    protected function _getSampleQuery()
    {
        $query = 'UPDATE test
                    SET
                            text = "value",
                            nummer = 1
                    WHERE
                            id = 2 AND
                            date < NOW()';

        return $query;
    }


    /**
     * @return array
     */
    public function getMultiselectArray()
    {
        return $this->multiselectArray;
    }


    /**
     * @param xtcPrice $xtcPrice
     */
    public function setXtcPrice(xtcPrice $xtcPrice)
    {
        $this->xtcPrice = $xtcPrice;
    }


    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}

$mySampleClass    = MainFactory::create_object('MySampleClass', array($_POST['multiselect'], $xtcPrice));
$type             = $mySampleClass->getType();
$multiselectArray = $mySampleClass->getMultiselectArray();
$mySampleClass->executeSampleQuery();
```

**Falsche Formatierung**

```php
<?php

$t_flag=0;
$t_name = "Max";
$t_text = "\"".MY_TEXT."\" $t_name Mustermann";
$c_number=(double) $_POST["number"];
foreach ( $t_customer_data AS $t_value ) {
    $t_status = ( $t_value=="true" ) ? true : false;
    if( $t_status ) $t_flag = 1;
}
if ( !empty($t_flag) )
    echo "Tada";
if($_POST['truncate'] == '1') xtc_db_query("TRUNCATE table");
```

**Korrekte Formatierung**

```php
<?php  

$flag = 0;
$name = 'Max';
$text = '"' . MY_TEXT . '" ' . $name . ' Mustermann';
$number = (double)$_POST['number'];

foreach($customerDataArray as $value)
{
    $status = false;

    if($value === 'true')
    {
        $status = true;
    }

    if($status)
    {
        $flag = 1;
    }
}

if(!empty($flag))
{
    echo 'Tada';
}

if(isset($_POST['truncate']) && $_POST['truncate'] === '1')
{
    $sql = 'TRUNCATE table';
    xtc_db_query($sql);
}
```
