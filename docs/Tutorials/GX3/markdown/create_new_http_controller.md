# Anlegen neuer HTTP-Controller

Bevor man einen neuen HTTP-Controller anlegen möchte, sollte man den HTTP-Service verstanden haben. Daher wird in
diesem Abschnitt primär auf den HTTP-Service eingegangen und daran erläutert, wie du einen eigenen Controller für
HTTP Requests schreiben kannst.


**Inhalt:**

* <a href="#Was ist der HTTP-Service und wofür wird er benötigt? ">Was ist der HTTP-Service und wofür wird er benötigt? </a>
* <a href="#Was ist ein Front-Controller?">Was ist ein Front-Controller?</a>
* <a href="#Was ist der HttpViewController und wofür wird er benötigt?">Was ist der HttpViewController und wofür wird er benötigt?</a>
    * <a href="#HttpViewController `protected` Helfer">HttpViewController `protected` Helfer</a>
    * <a href="#Valide Rückgabewerte der Action-Methoden">Valide Rückgabewerte der Action-Methoden</a>
    * <a href="#Arbeit mit Template-Dateien">Arbeit mit Template-Dateien</a>
    * <a href="#HttpViewController Klassen im System registrieren">HttpViewController Klassen im System registrieren</a>
* <a href="#Zusammenfassung">Zusammenfassung</a>
    * <a href="#Häufige Fehlerquellen">Häufige Fehlerquellen</a>
    * <a href="#Sample Controller">Sample Controller</a>


## <a name="Was ist der HTTP-Service und wofür wird er benötigt? "></a>Was ist der HTTP-Service und wofür wird er benötigt? 

Der HTTP-Service ist ein fundamentaler Bestandteil der GXEngine. Der Client, zum Beispiel ein Browser, interagiert 
mittels HTTP mit einen Web-Server, auf dem der Shop installiert ist. Der Dialog zwischen dem Server und dem Client 
findet mittels wohldefinierter Nachrichten statt. Der Client schickt einen sogenannten "Request" zum Web-Server, der 
wiederum mit einer "Response"-Nachricht antwortet. 
In PHP wird der Request des Clients von den globalen Variablen "$_GET", "$_POST", "$_FILE", "$_COOKIE", "$_SESSION"
 repräsentiert. Die Response-Nachricht wird mit Funktionen wie "echo" oder "header" generiert. 

Ein Ziel des HTTP-Service ist, die globalen PHP-Variablen und Funktionen mit einer objekt-orientierten Schicht zu 
ersetzen. Die Front-Controller des Shops "admin/admin.php | shop.php" steuern mithilfe des Services, welche
***HttpViewController-Kindklassen*** für den aktuellen Request genutzt werden sollen, die wiederum die Response-
Nachricht für den Client erzeugen. Das heißt, es wird für jeden Request das gleiche Skript an einer zentralen Stelle 
in der Software genutzt. Neue Seiten lassen sich einfach mithilfe eines ***HttpViewControllers*** und einer
Template-Datei, die im Controller definiert wird, anlegen.


## <a name="Was ist ein Front-Controller?"></a>Was ist ein Front-Controller?

Der Front-Controller ist ein zentrales Skript, das alle Requests des Clients empfängt und an einen bestimmten 
Controller *(HttpViewController)* delegiert. Generische Aufgaben, die bei jedem Seitenaufruf erledigt werden müssen,
werden vor der Delegation ausgeführt. 

Im Shop gibt es zwei Skripte, die die Aufgabe des Front-Controllers übernehmen.

- **Frontend** - `shop.php`
- **Gambio Admin** - `admin/admin.php`

Damit der Front-Controller zu einem HttpViewController delegiert, muss der Aufruf des Skripts mit den $_GET - Parameter
"do" erfolgen.

`shop.php?do=NewFrontendModule` - Delegation zum NewFrontendModuleController

`admin/admin.php?do=NewBackendModule` - Delegation zum NewBackendModuleController

Die HttpViewController besitzen verschiedene Action-Methoden (Näheres im nächsten Abschnitt). 
Die `::actionDefault`-Methode existiert in jedem Controller. Sie gibt ein Response-Objekt zurück und
der Front-Controller kann zu ihr delegieren. 

Angenommen, der NewBackendModuleController besitzt eine Action-Methode mit dem Namen `::actionInstall`, zu der delegiert 
werden soll. Damit der Front-Controller das tut, muss die Request-Url wie folgt aussehen:

`admin/admin.php?do=NewBackendModule/Install` - Delegation zur Methode *NewBackendModuleController::actionInstall*

Der Wert des $_GET - Parameters mit dem Schlüssel "do", der hinter dem Slash steht, spezifiziert die Action-Methode. 
Zusätzliche $_GET - Parameter können ganz normal hinzugefügt werden. 

`admin/admin.php?do=NewBackendModule/Install&module=moduleToInstall`


## <a name="Was ist der HttpViewController und wofür wird er benötigt?"></a>Was ist der HttpViewController und wofür wird er benötigt?

Von der HttpViewController-Klasse erben alle Controller-Klassen, die vom Front-Controller angesteuert werden können. 
Sie stellt einige Hilfsmethoden zum Zugriff auf die Requests-Variablen bereit sowie die Möglichkeit, eine Template-Datei
zu definieren und zu rendern.

Jeder HttpViewController besitzt so genannte *action*-Methoden, die die Steuerung des Requests weiter spezifizieren. 
Sie geben Instanzen von Objekten zurück, die das **HttpControllerResponseInterface** implementieren *(die Response
Nachricht)* . Die Response-Instanzen werden automatisch vom HTTP-Service weiter verarbeitet und an den Client
(Browser) übermittelt.  Action-Mehoden können wie oben beschrieben vom Front-Controller angesteuert werden. Sie müssen
als `public` definiert sein, einen *action*-Präfix im Methodennamen besitzen und ein Objekt vom Typen
*HttpControllerResponseInterface* zurückgeben. Wenn man im "do"-Parameter keine Action-Methode angibt, wird die
*actionDefault*-Methode ausgeführt. 

Folgende Request URL nehmen wir als Beispiel: `shop.php?do=NewFrontendModule/Install`. 
Der dazugehörige HttpViewController sollte wie folgt aufgebaut sein.

```php
// Request Url: shop.php?do=NewFrontendModule/Install
class NewFrontendModuleController extends HttpViewController
{
	public function actionInstall()
	{
		// Execute business logic here!
		
		return new HttpControllerResponse('Hello World!'); // HttpControllerResponseInterface
	}
}
```

Je nachdem, ob die Requests vom Front-Controller des Frontends oder des Gambio Admins delegiert werden, muss die
HttpViewController-Klasse von einer anderen Eltern-Klasse erben.

* **Frontend** - `HttpViewController`
* **Gambio Admin** - `AdminHttpViewController`

Der *AdminHttpViewController* stellt sicher, dass Seiten nur von einen eingeloggten Benutzer mit Admin-Rechten 
aufgerufen werden können. 


### <a name="HttpViewController `protected` Helfer"></a>HttpViewController `protected` Helfer

* `::_callActionMethod` - Ruft eine intern vorhandene Action-Methode auf
* `::_render` - Rendert die übergebene Template-Datei *(1. Argument)* und setzt die Template-Variablen *(2. Argument)*
* `::_getQueryParametersCollection` - Gibt eine Collection-Klasse zurück, die alle Werte der globalen $_GET-Variable enthält.
* `::_getPostDataCollection` - Gibt eine Collection-Klasse zurück, die alle Werte der globalen $_POST-Variable enthält.
* `::_getQueryParameter` - Vergleichbar mit $_GET\[$_getQueryParameterArgument\]
* `::_getPostData` - Vergleichbar mit $_POST\[$_getPostDataArgument\]
* `::_validatePageToken` - Überprüft den Page-Token und erzeugt eine Exception, wenn dieser nicht valide ist.


### <a name="Valide Rückgabewerte der Action-Methoden"></a>Valide Rückgabewerte der Action-Methoden
Alle Action-Methoden müssen Objekte vom Typen **HttpControllerResponseInterface** zurückgeben! Liste von Objekten, die
das **HttpControllerResponseInterface** implementieren:

* `HttpControllerResponse` - Response-Objekt für Seiten im Frontend
* `AdminPageHttpControllerResponse` - Response-Objekt für Seiten im Gambio Admin
* `AdminLayoutHttpControllerResponse` - Response-Objekt für **neue Seiten** im Gambio Admin
* `RedirectHttpControllerResponse` - Response-Objekt zum Weiterleiten
* `JsonHttpControllerResponse` - Response-Objekt für JSON (zum Beispiel bei Ajax-Requests)


### <a name="Arbeit mit Template-Dateien"></a>Arbeit mit Template-Dateien

Die Methode `::_render($templateFile, $keyValuePairs)` gibt ein gerendertes Template zurück. Der erste Parameter gibt
den Pfad zur Template-Datei an, der zweite Parameter muss ein assoziatives Array sein, in dem der Key der Variablenname
des Templates ist und der Value der auszugebende Wert. Der Pfad zur Template-Datei muss relativ zum Template-Verzeichnis
des ContentViews sein. Das Template-Verzeichnis kann innerhalb des Controllers geändert werden:

`$this->contentView->set_template_dir('/absolute/path/to/new/template/directory');`

Den Rückgabewert der `::_render`-Methode kann man anschließend einfach dem Response-Objekt als zweiten Parameter 
übergeben. z. B.:

```php
return new AdminPageHttpControllerResponse(
	'Seiten Title', 
	$this->_render('template_file.html', array('templateVariable', 'templateValue'))
);
```


### <a name="HttpViewController Klassen im System registrieren"></a>HttpViewController Klassen im System registrieren

Die Controller-Klassen werden automatisch vom System erkannt und registriert. Die Controller müssen einfach von der 
HttpViewController-Klasse erben und in einem der folgenden Verzeichnisse liegen: 

* `GXEngine`
* `GXMainComponents`
* `GXUserComponents`


## <a name="Zusammenfassung"></a>Zusammenfassung

* Front-Controller: **Frontend** - `shop.php` | **Gambio Admin** - `admin/admin.php`
* Erstellen einer neuen Controller-Klasse
	* Klasse muss im Klassennamen als Suffix **Controller** enthalten
	* Klasse muss von **HttpViewController** erben. Falls vom Gambio Admin Front-Controller delegiert wird, muss sie
	  vom **AdminHttpViewController** erben
* Falls benötigt, weitere Action-Methoden hinzufügen und zugehörige Template-Datei entwickeln
* Cache leeren
	* Damit die MainFactory die neue Controller-Klasse findet, muss der Class Registry Cache geleert werden


### <a name="Häufige Fehlerquellen"></a>Häufige Fehlerquellen

* Class Registry Cache nicht geleert
* Neuer Controller erbt nicht von \[Admin\]HttpViewController
* Nicht existierende Action-Methode
* Falscher Rückgabewert der ausgeführten Action-Methode
* Template-Verzeichnis im ContentView falsch gesetzt

### <a name="Sample Controller"></a>Sample Controller

Man findet im Verzeichnis 'docs/PHP/samples/http-service' Beispiel-Controller mit einer Anleitung, wie sie genutzt 
werden können.