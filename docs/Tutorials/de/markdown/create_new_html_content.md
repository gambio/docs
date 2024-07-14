# Anlegen neuer HTML Inhalte

Derzeit gibt es im Shop zwei verschiedene Systeme im Frontend, einmal das neue Theme-System, dass es seit GX v3.13 gibt
und das davor verwendete Template-System. Generell empfehlen wir, das neue Theme-System zu verwenden, jedoch kann es
natürlich auch sinnvoll sein, dass alte Template-System zu unterstützen. Daher wird hier auf beides eingegangen. Neben
dem Frontend gibt es aber auch noch das Backend bzw. den Gambio Admin, dessen HTML ebenfalls angepasst werden kann.

Bevor du nun jedoch direkt mit dem Einbinden neuer HTML Inhalt beginnen kannst, ist es grundsätzlich sehr hilfreich
zu verstehen, wie man mittels Smarty Blöcke updatesichere Änderungen an bestehende HTML Dateien vornimmt. Daher gehen
wir an dieser Stelle auch zunächst einmal auf das System der Smarty Blöcke ein.

Im Anschluss wird dann erklärt wie Templates/Theme Dateien im Frontend und Backend erweitert werden können bzw. wie
du eigene Inhalte einbindest.


## Smarty Blöcke

Mit Smarty 3 ist es möglich geworden, Vererbung zu realisieren. Hiermit ist es möglich, von einem Basis-HTML-Datei
Inhalte auf ein oder mehrere Kind-HTML-Dateien zu übertragen. Auch das Überschreiben bestimmter Bereiche ist möglich.

Hierfür gibt es unterschiedliche Vorgehensweisen. Einerseits kann mit der Smarty-Funktion `{extends}` gearbeitet
werden, wodurch ein bestimmte HTML-Datei um mehrere Bereiche erweitert werden kann. Andererseits kann auch das
`{block}`-Element um die Attribute `append` oder `prepend` erweitert werden.

Was es damit genau auf sich hat und wie du diese Funktionen zum Erweitern der HTML-Dateien verwenden kannst, soll
in diesem Tutorial erklärt werden. 


### Das {block}-Tag

Ein Smarty-Block wird immer mit dem `{block}`-Tag ausgewiesen. Es kennzeichnet einen Bereich, den du erweitern oder
austauschen kannst. Um gezielt einen bestimmmten Block überschreiben oder erweitern zu können, braucht er einen Namen.
Diesen kannst du wie folgt vergeben:

```html
{block name="example-block"}{/block}
```

Es gibt hierfür auch eine Kurzschreibweise, die du wie folgt verwenden kannst:

```html
{block "example-block"}{/block}
```


### Allgemeines Arbeiten mit Blöcken

Zunächst definieren wir uns ein Basis-HTML-Datei `basic.html`, in welchem wir nach Belieben Inhalte überschreiben oder
erweitern können. Dieses könnte wie folgt aussehen:

```html
{block name="example-block"}
    <div class="example-content">
        {block name="example-block-text"}
            <p>Some random text.</p>
        {/block}
    </div>
{/block}
```

Willst du dieses Basis jetzt erweitern beziehungsweise überschreiben, benötigst du ein Kind-HTML-Datei, welches von
deinem Basis-HTML-Datei `basic.html` erbt. Der Inhalt der Kind-HTML-Datei könnte dann wie folgt aussehen:

```html
{extends file="basic.html"}

{block name="example-block"}
    <h1>Overridden Content</h1>
{/block}
```

Das obige Beispiel hätte zur Folge, dass der `div`-Block aus dem Basis-HTML-Datei durch eine `h1`-Überschrift
ausgetauscht werden würde. Möchte man die Basis-HTML- allerdings nur um eigene Inhalte erweitern, die vor oder nach
dem eigentlichen Inhalt angezeigt werden sollen, empfiehlt sich die Verwendung der `append`- und `prepend`-Attribute.

```html
{extends file="basic.html"}

{block name="example-block" prepend}
    <h1>New Headline</h1>
{/block}
```

Würde zum Beispiel eine Überschrift vor dem div-Block einfügen. Während folgendes Beispiel einen neuen `div`-Block
unterhalb des ersten erzeugen würde:

```html
{extends file="basic.html"}

{block name="example-block" append}
    <div class="new-content">
        Some new Content
    </div>
{/block}
```


### Arbeiten mit Blöcken im Shop

Innerhalb des Gambio Shopsystems ist es etwas einfacher, mit Smarty-Blöcken zu arbeiten und du musst nicht extra auf
das oben erwähnte `{extend}` zurückgreifen, wenn du bestehendes HTML erweitern oder überladen möchtest.

Ein entsprechender Overload für einen spezifischen ContentView muss nur dann erstellt werden, wenn du weitere
dynamische Inhalte hinzufügen willst. Hierfür musst du dann erst ermitteln, welcher ContentView oder Controller
für den Inhalt verantwortlich ist und diesen dann über das [Overloading-System](change_existing_classes.md) erweitern.


## Anlegen neuer Inhalte

Zunächst einmal muss unterschieden werden, ob du Inhalte für das Frontend (Bereich den die Shopbesucher sehen) oder
Backend (Gambio Admin) erstellen möchtest. Weiter muss für das Frontend nochmals unterschieden werden, ob sich dieser
Inhalt auf ein Theme oder ein Template bezieht.

* Für das Backend müssen diese Inhalte im Ordner `GXModules/{Modulhersteller}/{Modulname}/Admin/Html` abgelegt werden
* Für das Theme `Honeygrid` im Frontend müssen diese Inhalte im Ordner
  `GXModules/{Modulhersteller}/{Modulname}/Shop/Themes/Honeygrid/html/system` abgelegt werden
* Für das Template `Honeygrid` im Frontend müssen diese Inhalte im Ordner
  `GXModules/{Modulhersteller}/{Modulname}/Shop/Templates/Honeygrid` abgelegt werden

Damit wäre dann zwar die Hauptverzeichnis für die entsprechenden Inhalte gegeben, es gibt jedoch weitere Vorgaben,
wie du deine Inhalt gezielt in eine HTML-Datei einbindest. Es folgen daher drei Beispiele für die jeweiligen Bereiche:

1. Angenommen du möchtest Inhalte zur bestehenden `admin/html/content/quick_edit/overview.html` hinzufügen oder
   ersetzen, dann musst du eine neue Datei `GXModules/{Modulhersteller}/{Modulname}/Admin/Html/content/quick_edit/overview.html`
   erstellen und kannst den Inhalt des ursprünglichen HTMLs mit Hilfe der Smarty Blöcken erweitern bzw. verändern.

2. Angenommen du möchtest Inhalte zur bestehenden `themes/Honeygrid/html/system/index.html` hinzufügen oder
   ersetzen, dann musst du eine neue Datei `GXModules/{Modulhersteller}/{Modulname}/Shop/Themes/html/system/index.html`
   erstellen und kannst den Inhalt des ursprünglichen HTMLs mit Hilfe der Smarty Blöcken erweitern bzw. verändern.

3. Angenommen du möchtest Inhalte zur bestehenden `templates/Honeygrid/index.html` hinzufügen oder
   ersetzen, dann musst du eine neue Datei `GXModules/{Modulhersteller}/{Modulname}/Shop/Templates/Honeygrid/index.html`
   erstellen und kannst den Inhalt des ursprünglichen HTMLs mit Hilfe der Smarty Blöcken erweitern bzw. verändern.
   
Für deine eigenen Inhalte musst du dich im Frontend nicht zwingend auf ein Template festlegen. Es besteht auch die
Möglichkeit statt eines expilizen Themes/Templates (z.B. Honeygrid) auch einfach zu sagen, dass diese Inhalt für alle
Themes/Templates gilt. Hierfür müssen diese Inhalte unter `GXModules/{Modulhersteller}/{Modulname}/Shop/Themes/All`
bzw. `GXModules/{Modulhersteller}/{Modulname}/Shop/Templates/All` abgelegt werden.

Natürlich besteht auch die Möglichkeit, statt bestehender HTML-Dateien für das Front- und Backend ganz neue Dateien
zu erstellen. Die Einbindung dieser neuen Dateien erfolgt jedoch nicht automatisch und muss entweder als Einbindung
durch bestehende HTML-Dateien, oder durch das Rendern über eigene HTTP-Controller erfolgen.

Mehr zum Thema HTTP-Controller findest du in Abschnitt [Anlegen neuer HTTP-Controller](create_new_http_controller.md).