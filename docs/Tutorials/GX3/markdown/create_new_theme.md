# Entwicklung eines neuen Themes

Mit Version GX 3.13.1 haben wir ein neues Theme-System eingeführt, das zunächst neben dem bisherigen Template-System
existieren und dieses später komplett ablösen wird. Es bietet eine verbesserte, neue Struktur, die es Entwicklern
einfacher macht, Themes für Gambio zu entwickeln. Wichtig dafür ist eine klare, verständliche und selbsterklärende
Ordner- und Dateistruktur innerhalb des Theme-Ordners “Honeygrid”. Deshalb gibt es nun verbindliche Konventionen für
die Namensgebung z.B. von Ordnern und Dateien. Für die Entwicklung neuer oder die Individualisierung bestehender Themes
sind ausschließlich Anpassungen an HTML-Templates, Stylesheets und am Javascript erforderlich. Diese drei Bereiche
bilden den Kern des Themes und sind intuitiv zugänglich. Zudem gibt es die Möglichkeit, zu einem Parent-Theme mehrere
Child-Themes anzulegen, die dann mit deutlich weniger Aufwand angepasst werden können und bei Aktualisierungen des
Parent-Themes mit upgedatet werden.

Den Inhalt dieses Tutorials gibt es auch als Video:

<iframe width="840" height="472" src="https://www.youtube.com/embed/AniwyC4qHe0" frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen="">
</iframe>


**Inhalt:**

* <a href="#Begriffserläuterung zu Themes und Templates">Begriffserläuterung zu Themes und Templates</a>
* <a href="#Verzeichnisstruktur">Verzeichnisstruktur</a>
* <a href="#Theme-Konfigurationsdatei">Theme-Konfigurationsdatei</a>
    * <a href="#Definition der Metadaten">Definition der Metadaten</a>
    * <a href="#Erzeugung neuer Content-Manager-Einträge">Erzeugung neuer Content-Manager-Einträge</a>
        * <a href="#Inhaltsseiten (infoPages): Zum Gestalten eigener Inhaltsseiten">Inhaltsseiten (infoPages): Zum Gestalten eigener Inhaltsseiten</a>
        * <a href="#Verlinkungen (linkPages): Zum Erzeugen von Verlinkungen zu externen Seiten">Verlinkungen (linkPages): Zum Erzeugen von Verlinkungen zu externen Seiten</a>
        * <a href="#Inhaltselemente (infoElements): Zum Gestalten von Elementen, die in verschiedenen Bereichen im Shop angezeigt werden können">Inhaltselemente (infoElements): Zum Gestalten von Elementen, die in verschiedenen Bereichen im Shop angezeigt werden können</a>
        * <a href="#Beispiel zur Erzeugung verschiedener Contents">Beispiel zur Erzeugung verschiedener Contents</a>
* <a href="#Vererbung von Themes">Vererbung von Themes</a>
* <a href="#HTML-Templates">HTML-Templates</a>
    * <a href="#Hinzufügen neuer HTML-Templates">Hinzufügen neuer HTML-Templates</a>
    * <a href="#Ersetzen vorhandener HTML-Templates">Ersetzen vorhandener HTML-Templates</a>
    * <a href="#Erweiterung vorhandener HTML-Templates">Erweiterung vorhandener HTML-Templates</a>
* <a href="#Styles">Styles</a>
    * <a href="#Hinzufügen neuer Stylesheets">Hinzufügen neuer Stylesheets</a>
    * <a href="#Ersetzen vorhandener Stylesheets">Ersetzen vorhandener Stylesheets</a>
    * <a href="#Erweiterung vorhandener Stylesheets">Erweiterung vorhandener Stylesheets</a>
    * <a href="#Erweiterung spezifischer Stylesheets">Erweiterung spezifischer Stylesheets</a>
    * <a href="#Entfernen spezifischer Stylesheets">Entfernen spezifischer Stylesheets</a>
* <a href="#Javascript">Javascript</a>
    * <a href="#Hinzufügen neuer Javascript-Dateien">Hinzufügen neuer Javascript-Dateien</a>
    * <a href="#Ersetzen vorhandener Javascript-Dateien">Ersetzen vorhandener Javascript-Dateien</a>
    * <a href="#Erweiterung vorhandener Javascripts">Erweiterung vorhandener Javascripts</a>
    * <a href="#Erweiterung spezifischer Javascripts">Erweiterung spezifischer Javascripts</a>
    * <a href="#Bereichsspezifische Javascripts">Bereichsspezifische Javascripts</a>
* <a href="#Hinzufügen eines StyleEdit-Styles">Hinzufügen eines StyleEdit-Styles</a>
* <a href="#Entwickler-Modus">Entwickler-Modus</a>
* <a href="#Version dieser Dokumentation">Version dieser Dokumentation</a>


## <a name="Begriffserläuterung zu Themes und Templates"></a>Begriffserläuterung zu Themes und Templates

Um Verwirrung in den folgenden Abschnitten zu vermeiden, werden die Begriffe Theme und Template genauer erklärt.
Das neue Theme-System ist die Ablösung des bisherigen Template-Systems. Dennoch wird in den folgenden Abschnitten von
Templates oder HTML-Templates gesprochen. Dies rührt daher, dass ein Template der Begriff für eine einzelne .html-
oder .tpl-Datei sein kann. Es handelt sich dabei um Dateien, die die Template-Engine "Smarty" verwenden. Im bisherigen
Template-System wurde der Zusammenschluss mehrer HTML-Templates, Styles und Scripts ebenfalls "Template" genannt
(wie z. B. Honeygrid). Nicht zuletzt soll das neue Theme-System diese Verwirrung der Bezeichnungen künftig dadurch
vermeiden, dass ein solcher Zusammenschluss aus HTML-Templates, Styles und Scripts "Theme" genannt wird. 


## <a name="Verzeichnisstruktur"></a>Verzeichnisstruktur

Um dem Shopbetreibern und Theme-Designern eine einfache Möglichkeit zu bieten, Themes hinzuzufügen und zu gestalten,
wurden einige Ebenen der Verzeichnisstruktur gekürzt um Gleiches mit Gleichem möglichst an einem Ort zu bündeln.

Die neue Struktur eines Themes sieht wie folgt aus:

<details>
    <summary>Struktur anzeigen</summary>

    +-- config
    |   |
    |   +-- ...
    |
    +-- fonts
    |   |
    |   +-- ...
    |
    +-- html
    |   |
    |   +-- custom
    |   |   |
    |   |   +-- sample_overload.html
    |   |
    |   +-- system
    |       |
    |       +-- sample_replacement.html
    |
    +-- images
    |   |
    |   +-- ...
    |
    +-- javascripts
    |   |
    |   +-- custom
    |   |   |
    |   |   +-- Cart
    |   |   |   |
    |   |   |   +-- sample_cart_specific_overload.js 
    |   |   |
    |   |   +-- sample_global_overload.js
    |   |
    |   +-- system
    |       |
    |       +-- sample_replacement.js
    |
    +-- styles
    |   |
    |   +-- custom
    |   |   |
    |   |   +-- sample_overload.css
    |   |   |
    |   |   +-- sample_overload.scss
    |   |
    |   +-- styleedit
    |   |   |
    |   |   +-- ...
    |   |   |
    |   |   +-- sample_style.json
    |   |
    |   +-- system
    |       |
    |       +-- sample_replacement.scss
    |
    +-- theme.json
</details>

In den folgenden Abschnitten werden die Möglichkeiten für Theme-Entwickler genauer beschrieben.


## <a name="Theme-Konfigurationsdatei"></a>Theme-Konfigurationsdatei

Im Hauptverzeichnis eines Themes liegt eine Datei ```theme.json``` (z. B. ```themes/Honeygrid/theme.json```). Damit ein
Theme überhaupt vom Shop erkannt wird, muss diese vorhanden und mit einigen Pflichtangaben befüllt sein. Inhalt dieser
Datei sind Metadaten, um das Theme genauer zu beschreiben. Außerdem bietet die Datei die Möglichkeit neue
Content-Manager-Einträge zu erzeugen, sobald das Theme aktiviert wird.


### <a name="Definition der Metadaten"></a>Definition der Metadaten

In der ```theme.json``` können Metadaten definiert werden, um das Theme zu beschreiben. Diese Daten werden vom App
Store, aber auch in sonstigen Oberflächen im Gambio Admin verwendet. 

<details>
    <summary>Tabelle anzeigen</summary>

| JSON-Attribut | Inhalt      | Pflichtfeld | Beispiel      | Beschreibung                                                                    |
|---------------|-------------|-------------|---------------|---------------------------------------------------------------------------------|
| id            | Text        |      Ja     | Honeygrid     | Eine eindeutige Benennung, die zur technischen Identifikation des Themes dient. |
| title         | Text        |      Ja     | Honeygrid     | Der Name des Themes, der zur Anzeige verwendet wird.                            |
| extends       | Text        |     Nein    | MyParentTheme | Die ID des Themes, von dem dieses Theme erbt.                                   |
| author        | Text        |     Nein    | Gambio        | Der Name des Theme-Entwicklers.                                                 |
| version       | Text        |     Nein    | 1.0.0         | Eine frei wählbare Versionierung.                                               |
| contents      | JSON-Objekt |     Nein    | {}            | Siehe [Erzeugung neuer Content-Manager-Einträge](#createNewContent)             |

</details>

<details>
    <summary>Beispiel anzeigen</summary>
    
    {
    	"id": "Childgrid",
    	"title": "Childgrid",
    	"extends": "Honeygrid",
    	"author": "Gambio",
    	"version": "1.0.0",
    	"contents": {}
    }
</details>


### <a name="Erzeugung neuer Content-Manager-Einträge"></a>Erzeugung neuer Content-Manager-Einträge

Bei den Content-Manager-Einträgen unterscheiden wir zwischen 3 verschiedenen Typen:

- [Inhaltsseiten (infoPages)](#infoPages)
- [Verlinkungen (linkPages)](#linkPages)
- [Inhaltselemente (infoElements)](#infoElements)

[Hier](#contentExample) findet sich eine Beispieldatei zum Erzeugen verschiedener Inhalte.


#### <a name="Inhaltsseiten (infoPages): Zum Gestalten eigener Inhaltsseiten"></a>Inhaltsseiten (infoPages): Zum Gestalten eigener Inhaltsseiten

<details>
    <summary>Tabelle anzeigen</summary>

| JSON-Attribut             	| Inhalt                                                	| Pflichtfeld 	| Beispiel                                             	| Beschreibung                                                                                	|
|---------------------------	|-------------------------------------------------------	|-------------	|------------------------------------------------------	|---------------------------------------------------------------------------------------------	|
| id                        	| Eindeutige ID als Ganzzahl     	                        |      Nein   	| 12345678                                            	| Die Group ID des Contents. Es sollte eine nicht vergebene ID genommen werden (<2147483648).  	|
| position                  	| mainNavigation\|secondaryNavigation\|info\|infoBox    	|      Ja     	| mainNavigation                                       	| Die Position an der der Content verlinkt wird.                                              	|
| status                    	| 1\|0                                                  	|      Ja     	| 1                                                    	| Gibt an, ob der Content sichtbar ist. 0: unsichtbar, 1: sichtbar                            	|
| name                      	| Mehrsprachiger Text                                   	|      Ja     	| {"de": "Neuer Inhalt", "en": "New content"}          	| Der interne Name, der im Content Manager im Gambio Admin angezeigt wird.                    	|
| title                     	| Mehrsprachiger Text                                   	|      Ja     	| {"de": "Link zum Inhalt", "en": "Link to content"}   	| Der Linktext, der an der angegebenen Position angezeigt wird.                               	|
| heading                   	| Mehrsprachiger Text                                   	|      Ja     	| {"de": "Die Überschrift", "en": "The heading"}       	| Die Überschrift auf der Inhaltsseite.                                                       	|
| text                      	| Mehrsprachiger Text                                   	|      Ja     	| {"de": "Der Inhalt", "en": "The content"}            	| Der Inhalt der Inhaltsseite                                                                 	|
| downloadFile              	| Mehrsprachiger Dateipfad                              	|      Ja     	| {"de": "download-de.pdf", "en": "download-en.pdf"}   	| Dateipfad zum Download des Contents.                                                        	|
| metaTitle                 	| Mehrsprachiger Text                                   	|      Ja     	| {"de": "meta titel", "en": "meta title"}             	| Der Meta-Titel des Contents.                                                                	|
| metaKeywords              	| Mehrsprachiger Text                                   	|      Ja     	| {"de": "meta keywords", "en": "meta keywords"}       	| Die Meta-Keywords des Contents.                                                             	|
| metaDescription           	| Mehrsprachiger Text                                   	|      Ja     	| {"de": "meta description", "en": "meta description"} 	| Die Meta-Description des Contents.                                                          	|
| urlKeywords               	| Mehrsprachiger Text                                   	|      Ja     	| {"de": "url-keywords", "en": "url-keywords"}         	| Die URL-Keywords des Contents.                                                              	|
| urlRewrite                	| Mehrsprachiger Text                                   	|      Ja     	| {"de": "url-rewrite", "en": "url-rewrite"}           	| Der URL-Rewrite des Contents                                                                	|
| sitemap                   	| JSON-Objekt                                           	|      Ja     	|                                                      	| Beinhaltet Einstellungen in Bezug auf die Sitemap-Erzeugung.                                	|
| sitemap > visible         	| 1\|0                                                  	|      Ja     	| 1                                                    	| Gibt an, ob der Content in die Sitemap aufgenommen werden soll.                             	|
| sitemap > priority        	| Mehrsprachige Fließkommazahl                          	|      Ja     	| {"de": "0.1", "en": "0.2"}                           	| Gibt die Priorität des Contents in der Sitemap an.                                          	|
| sitemap > changeFrequency 	| always\|hourly\|daily\|weekly\|monthly\|yearly\|never 	|      Ja     	| daily                                                	| Gibt an, wie häufig der Eintrag in der Sitemap aktualisiert werden soll.                    	|
| allowRobots               	| 1\|0                                                  	|      Ja     	| 1                                                    	| Gibt an, ob ein disallow-Eintrag in der robots.txt erzeugt werden soll.                     	|
| opengraphImage            	| Mehrsprachige Bild-URL                                	|      Ja     	| {"de": "mein-bild.jpg", "en": "my-image.jpg"}        	| Das Opengraph Image, das zur Verwendung als Vorschaubild in sozialen Medien verwendet wird. 	|

</details>


#### <a name="Verlinkungen (linkPages): Zum Erzeugen von Verlinkungen zu externen Seiten"></a>Verlinkungen (linkPages): Zum Erzeugen von Verlinkungen zu externen Seiten

<details>
    <summary>Tabelle anzeigen</summary>

| JSON-Attribut 	| Inhalt                                             	| Pflichtfeld 	| Beispiel                                                      	| Beschreibung                                                                                                                                	|
|---------------	|----------------------------------------------------	|-------------	|---------------------------------------------------------------	|---------------------------------------------------------------------------------------------------------------------------------------------	|
| id              	| Eindeutige ID als Ganzzahl     	                    |      Nein   	| 12345678                                            	            | Die Group ID des Contents. Es sollte eine nicht vergebene ID genommen werden (<2147483648).  	                                                |
| position      	| mainNavigation\|secondaryNavigation\|info\|infoBox 	|      Ja     	| mainNavigation                                                	| Die Position an der der Content angezeigt wird.                                                                                             	|
| status        	| 1\|0                                               	|      Ja     	| 1                                                             	| Gibt an, ob der Content sichtbar ist. 0: unsichtbar, 1: sichtbar                                                                            	|
| name          	| Mehrsprachiger Text                                	|      Ja     	| {"de": "Neuer Inhalt", "en": "New content"}                   	| Der interne Name, der im Content Manager im Gambio Admin angezeigt wird.                                                                    	|
| title         	| Mehrsprachiger Text                                	|      Ja     	| {"de": "Link zum Inhalt", "en": "Link to content"}            	| Der Linktext, der an der angegebenen Position angezeigt wird.                                                                               	|
| link          	| Mehrsprachiger Text                                	|      Ja     	| {"de": "http://www.gambio.de", "en": "http://www.gambio.com"} 	| Der Inhalt des Inhaltselements.                                                                                                             	|
| openInNewTab  	| 1\|0                                               	|      Ja     	| 1                                                             	| Gibt an, ob der Link in einem neuen Tab geöffnet werden soll. 0: Link wird im selben Tab geöffnet, 1: Link wird in einem neuen Tab geöffnet 	|

</details>


#### <a name="Inhaltselemente (infoElements): Zum Gestalten von Elementen, die in verschiedenen Bereichen im Shop angezeigt werden können"></a>Inhaltselemente (infoElements): Zum Gestalten von Elementen, die in verschiedenen Bereichen im Shop angezeigt werden können

<details>
    <summary>Tabelle anzeigen</summary>

| JSON-Attribut 	| Inhalt                                          	| Pflichtfeld 	| Beispiel                                       	| Beschreibung                                                             	|
|---------------	|-------------------------------------------------	|-------------	|------------------------------------------------	|-------------------------------------------------------------------------------------------  |
| id              	| Eindeutige ID als Ganzzahl     	                |      Nein   	| 12345678                                          | Die Group ID des Contents. Es sollte eine nicht vergebene ID genommen werden (<2147483648). |
| position      	| start\|header\|boxes\|footer\|withdrawal\|other 	|      Ja     	| mainNavigation                                 	| Die Position an der der Content angezeigt wird.                                             |
| status        	| 1\|0                                            	|      Ja     	| 1                                              	| Gibt an, ob der Content sichtbar ist. 0: unsichtbar, 1: sichtbar         	                  |
| title         	| Mehrsprachiger Text                             	|      Ja     	| {"de": "Neuer Inhalt", "en": "New content"}    	| Der interne Name, der im Content Manager im Gambio Admin angezeigt wird. 	                  |
| heading       	| Mehrsprachiger Text                             	|      Ja     	| {"de": "Die Überschrift", "en": "The heading"} 	| Die Überschrift auf des Inhaltselements.                                 	                  |
| text          	| Mehrsprachiger Text                             	|      Ja     	| {"de": "Der Inhalt", "en": "The content"}      	| Der Inhalt des Inhaltselements.                                          	                  |

</details>


#### <a name="Beispiel zur Erzeugung verschiedener Contents"></a>Beispiel zur Erzeugung verschiedener Contents

<details>
    <summary>Beispiel anzeigen</summary>
    
    {
    	"id": "Childgrid",
    	"title": "Childgrid",
    	"extends": "Honeygrid",
    	"author": "Gambio",
    	"version": "1.0.0",
    	"contents": {
    		"infoPages": [
    			{
    				"id": 12345678,
    				"position": "mainNavigation",
    				"status": 1,
    				"name": {
    					"de": "SSV",
    					"en": "SSV"
    				},
    				"title": {
    					"de": "Sommerschlussverkauf",
    					"en": "Summer sale"
    				},
    				"heading": {
    					"de": "Sommerschlussverkauf - Alles muss raus!",
    					"en": "Summer sale - We throw everything out!"
    				},
    				"text": {
    					"de": "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.",
    					"en": "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet."
    				},
    				"downloadFile": {
    					"de": "",
    					"en": ""
    				},
    				"metaTitle": {
    					"de": "Sommerschlussverkauf",
    					"en": "Summer sale"
    				},
    				"metaKeywords": {
    					"de": "sale",
    					"en": "sale"
    				},
    				"metaDescription": {
    					"de": "Lorem ipsum",
    					"en": "Lorem ipsum"
    				},
    				"urlKeywords": {
    					"de": "Lorem ipsum",
    					"en": "Lorem ipsum"
    				},
    				"urlRewrite": {
    					"de": "ssv",
    					"en": "summer-sale"
    				},
    				"sitemap": {
    					"visible": 1,
    					"priority": {
    						"de": "1.0",
    						"en": "0.0"
    					},
    					"changeFrequency": "daily"
    				},
    				"allowRobots": 1,
    				"opengraphImage": {
    					"de": "",
    					"en": ""
    				}
    			}
    		],
    		"linkPages": [
    			{
    				"id": 12345679,
                    "position": "mainNavigation",
    				"status": 1,
    				"name": {
    					"de": "Gambio",
    					"en": "Gambio"
    				},
    				"title": {
    					"de": "Zu Gambio",
    					"en": "To Gambio"
    				},
    				"link": {
    					"de": "http://www.gambio.de",
    					"en": "http://www.gambio.com"
    				},
    				"openInNewTab": 1
    			}
    		],
    		"infoElements": [
    			{
    			    "id": 12345680,
    				"position": "header",
    				"status": 1,
    				"title": {
    					"de": "Kopfzeilenelement",
    					"en": "Header element"
    				},
    				"heading": {
    					"de": "Interessante Kopfzeile",
    					"en": "Interessting header"
    				},
    				"text": {
    					"de": "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.",
    					"en": "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet."
    				}
    			}
    		]
    	}
    }
</details>


## <a name="Vererbung von Themes"></a>Vererbung von Themes

Ein wesentlicher Mechanismus des neuen Theme-Systems ist die Vererbung. Dadurch ist es Theme-Designer möglich, ein
Theme auf Grundlage eines bereits vorhandenen Themes zu erstellen. Das hat den Vorteil, dass der Theme-Designer ein
schlankes Theme-Verzeichnis hat, in dem nur seine Änderungen enthalten sind. Die Vererbung funktioniert auch über
mehrere Ebenen. Das heißt, dass ein Theme von einem Theme erben kann, welches wiederum von einem anderen Theme erbt.
Die Vererbung wird in der ```theme.json``` in dem Attribut ```extends``` definiert (vgl. [Definition der Metadaten](#metaData)).

Wenn ein Theme-Designer neue Template-, Style- oder Javascript-Dateien über ein Template einbindet, sollten diese
im Verzeichnis `themes/MeinNeuesTheme/html/system/`, `themes/MeinNeuesTheme/styles/system/`, bzw.
`themes/MeinNeuesTheme/javascripts/system/` liegen. Dies ermöglicht die weitere Überladung durch Themes, die von
diesem Theme erben.


## <a name="HTML-Templates"></a>HTML-Templates

Das Erweitern und Modifizieren von HTML-Templates ist ein wesentlicher Bestandteil der Theme-Erstellung. Das neue
Theme-System ermöglicht es, komplette HTML-Templates des Eltern-Templates zu ersetzen, bestehende Templates zu erweitern oder einzelne Smarty-Blocks zu ersetzen. [Mehr Informationen zur Verwendung von Smarty-Blocks](https://developers.gambio.de/tutorials.html?v=3.13.1.0&p=smarty-blocks)


### <a name="Hinzufügen neuer HTML-Templates"></a>Hinzufügen neuer HTML-Templates

Bei der Gestaltung eines neuen Themes auf Grundlage eines vorhandenen Themes kann es nützlich sein, neue HTML-Templates
einzuführen, die z. B. mithilfe der Smarty-Funktion ```{include}``` in anderen HTML-Templates inkludiert werden. Bei
der Entwicklung eines komplett neuen Themes, das kein vorhandenes Theme erweitert, ist das Hinzufügen neuer
HTML-Templates essentiell.

Neue HTML-Templates müssen im Verzeichnis ```themes/MeinNeuesTheme/html/system/``` erstellt werden. Damit das neue
HTML-Template kein HTML-Template eines eventuellen Eltern-Themes überschreibt, muss darauf geachtet werden, dass
kein gleichnamiges HTML-Template im Eltern-Theme existiert.

<details>
    <summary>Beispiel-Dateistruktur</summary>
    
    themes
        |
        +-- MeinNeuesTheme
                |
                +-- html
                    |
                    +-- system
                        |
                        +-- my_new_template.html
</details>


### <a name="Ersetzen vorhandener HTML-Templates"></a>Ersetzen vorhandener HTML-Templates

Um vorhandene HTML-Templates eines Eltern-Themes zu ersetzen, kann man im Verzeichnis
`themes/MeinNeuesTheme/html/system/` eine HTML-Datei mit dem selben Namen, wie die zu ersetzende Datei des
Eltern-Themes im Verzeichnis `themes/ElternTheme/html/system/` anlegen.

Wenn man z. B. ein neues Theme auf Basis von Honeygrid entwickelt und das `account.html`-Template ersetzen möchte,
so muss man die Datei `themes/MeinNeuesTheme/html/system/account.html` erstellen.

<details>
    <summary>Dateistruktur des Beispiels</summary>

    themes
    |
    +-- Honeygrid
    |   |
    |   +-- ...
    |   |
    |   +-- html
    |   |   |
    |   |   +-- system
    |   |       |
    |   |       +-- account.html
    |   |       |
    |   |       +-- ...
    |   |
    |   +-- ...
    |
    +-- MeinNeuesTheme
        |
        +-- html
            |
            +-- system
                |
                +-- account.html
</details>


### <a name="Erweiterung vorhandener HTML-Templates"></a>Erweiterung vorhandener HTML-Templates

Um ein HTML-Template zu erstellen, das [Smarty-Blocks](hthttps://developers.gambio.de/tutorials.html?v=3.13.1.0&p=smarty-blocks.gambio.de/tutorials.html?v=3.13.1.0&p=smarty-blocks)
verschiedener HTML-Templates eines Eltern-Themes ersetzt oder erweitert, kann man eine neue Datei im Verzeichnis
`themes/MeinNeuesTheme/html/custom/` erstellen. Damit nicht nur eine spezifisches HTML-Template des Eltern-Themes
überladen wird, muss sichergestellt sein, dass keine gleichnamige Datei im Verzeichnis `themes/ElternTheme/html/system/`
existiert.

Dies kann besonders nützlich sein, wenn man Smarty-Blocks auf verschiedenen Seiten verändern möchte, die jedoch
thematisch zusammen gehören, wie z. B. einen Weihnachts-Template, das viele kleine weihnachtliche HTML-Anpassungen in
allen Bereichen des Shops vornehmen soll.

<details>
    <summary>Beispiel-Dateistruktur</summary>
    
    themes
        |
        +-- MeinNeuesTheme
                |
                +-- html
                    |
                    +-- custom
                        |
                        +-- my_christmas_template.html
</details>


## <a name="Styles"></a>Styles

Um das Design eines eigenen Themes wunschgemäß anpassen zu können, müssen bestehende Styles im Shop verändert oder
erweitert werden.


### <a name="Hinzufügen neuer Stylesheets"></a>Hinzufügen neuer Stylesheets

Neue Stylesheets, die über eigene Templates oder von anderen Stylesheets eingebunden werden, müssen im Verzeichnis
`themes/MeinNeuesTheme/styles/system/` erstellt werden. Um keinen bestehenden Stylesheet zu überschreiben muss darauf
geachtet werden, dass in einem eventuellen Eltern-Theme keine gleichnamige Datei im Verzeichnis
`themes/ElternTheme/styles/system/` existiert.

<details>
    <summary>Beispiel-Dateistruktur</summary>
    
    themes
        |
        +-- MeinNeuesTheme
                |
                +-- styles
                    |
                    +-- system
                        |
                        +-- my_style.scss
</details>


### <a name="Ersetzen vorhandener Stylesheets"></a>Ersetzen vorhandener Stylesheets

Um vorhandene Stylesheets eines Eltern-Themes zu ersetzen, kann man im Verzeichnis `themes/MeinNeuesTheme/styles/system/`
eine .css- oder .scss-Datei mit dem selben Namen, wie die zu ersetzende Datei des Eltern-Themes im Verzeichnis
`themes/ElternTheme/styles/system/` anlegen.

Wenn man z. B. ein neues Theme auf Basis von Honeygrid entwickelt und den `modules/_account.scss`-Stylesheet
ersetzen möchte, so muss man die Datei `themes/MeinNeuesTheme/styles/system/modules/_account.scss` erstellen.

<details>
    <summary>Dateistruktur des Beispiels</summary>

    themes
    |
    +-- Honeygrid
    |   |
    |   +-- ...
    |   |
    |   +-- styles
    |   |   |
    |   |   +-- system
    |   |       |
    |   |       +-- ...
    |   |       |
    |   |       +-- modules
    |   |       |   |
    |   |       |   +-- _account.scss
    |   |       |   |
    |   |       |   +-- ...
    |   |       |
    |   |       +-- ...
    |   |
    |   +-- ...
    |
    +-- MeinNeuesTheme
        |
        +-- styles
            |
            +-- system
                |
                +-- modules
                    |
                    +-- _account.scss
</details>


### <a name="Erweiterung vorhandener Stylesheets"></a>Erweiterung vorhandener Stylesheets

Um einen Stylesheet auf jeder Seite des Shops zu laden, kann man eine neue Datei im Verzeichnis `themes/MeinNeuesTheme/styles/custom/`
erstellen. Dies kann besonders nützlich sein, wenn man einen Stylesheet anwenden möchte, der auf verschiedene Bereiche
des Shops Einfluss nimmt, wie z. B. einen Weihnachts-Style, der viele kleine weihnachtliche Style-Anpassungen in allen
Bereichen des Shops vornehmen soll.

Damit kein spezifischer Stylesheet überladen wird, sollte sichergestellt sein, dass in einem eventuellen Eltern-Theme
keine gleichnamige Datei existiert.

<details>
    <summary>Beispiel-Dateistruktur</summary>
    
    themes
        |
        +-- MeinNeuesTheme
                |
                +-- styles
                    |
                    +-- custom
                        |
                        +-- my_style.scss
</details>


### <a name="Erweiterung spezifischer Stylesheets"></a>Erweiterung spezifischer Stylesheets

Um eine bestimmte Stylesheet-Datei zu erweitern, muss eine Datei im Verzeichnis `themes/MeinNeuesTheme/styles/custom/`
mit dem gleichen Namen wie in einem Eltern-Theme im Verzeichnis `themes/ElternTheme/styles/system/` angelegt werden.

Dies kann nützlich sein, wenn man das Design in einem bestimmten Bereich des Shops anpassen/ergänzen möchte.

<details>
    <summary>Beispiel-Dateistruktur</summary>

    themes
    |
    +-- Honeygrid
    |   |
    |   +-- ...
    |   |
    |   +-- styles
    |   |   |
    |   |   +-- system
    |   |       |
    |   |       +-- ...
    |   |       |
    |   |       +-- modules
    |   |       |   |
    |   |       |   +-- _account.scss
    |   |       |   |
    |   |       |   +-- ...
    |   |       |
    |   |       +-- ...
    |   |
    |   +-- ...
    |
    +-- MeinNeuesTheme
        |
        +-- styles
            |
            +-- custom
                |
                +-- modules
                    |
                    +-- _account.scss
</details>


### <a name="Entfernen spezifischer Stylesheets"></a>Entfernen spezifischer Stylesheets

Um einen bestimmten Stylesheet eines Eltern-Themes zu entfernen, muss eine gleichnamige leere Datei im Verzeichnis
`themes/MeinNeuesTheme/styles/system/` angelegt werden (vgl. [Ersetzen vorhandener Stylesheets](#replaceStylesheet)).

Stylesheets wie die `themes/Honeygrid/styles/system/main.scss`, die fast ausschließlich aus Imports anderer Stylesheets
bestehen und für den grundlegenden Style eines Themes verantwortlich sind, nennt man "Boilerplates". Solche Boilerplates
eines Themes sollten nach Möglichkeit nicht ersetzt oder gar gelöscht werden. Wenn bestimmte Stylesheets in solchen
Dateien nicht angewendet werden sollen, empfiehlt es sich eher, diese entsprechenden Stylesheets mit einer leeren Datei
zu ersetzen.


## <a name="Javascript"></a>Javascript

Die Verwendung eigener Javascripts befähigt Theme-Designer Einfluss auf das Verhalten des Themes zu nehmen und neues
dynamisches Verhalten der Elemente des Themes zu erzeugen.

Wenn die eigenen Scripts in Unterverzeichnissen organisiert werden sollen, ist dies möglich, jedoch gibt es einige
reservierte Verzeichnisnamen, die einen Effekt auf die Einbindung der enthaltenen Javascript-Dateien haben (vgl.
[Bereichsspezifische Javascripts](#areaSpecificJavascript)).


### <a name="Hinzufügen neuer Javascript-Dateien"></a>Hinzufügen neuer Javascript-Dateien

Neue Javascript-Dateien, die über eigene HTML-Templates eingebunden werden, müssen im Verzeichnis
`themes/MeinNeuesTheme/javascripts/system/` erstellt werden. Um keine bestehende Javascript-Datei zu überschreiben,
muss darauf geachtet werden, dass in einem eventuellen Eltern-Theme keine gleichnamige Datei im Verzeichnis
`themes/ElternTheme/javascripts/system/` existiert.

<details>
    <summary>Beispiel-Dateistruktur</summary>
    
    themes
        |
        +-- MeinNeuesTheme
                |
                +-- javascripts
                    |
                    +-- system
                        |
                        +-- my_script.js
</details>


### <a name="Ersetzen vorhandener Javascript-Dateien"></a>Ersetzen vorhandener Javascript-Dateien

Um vorhandene Javascripts eines Eltern-Themes zu ersetzen, kann man im Verzeichnis
`themes/MeinNeuesTheme/javascripts/system/` eine .js-Datei mit dem selben Namen, wie die zu ersetzende Datei des
Eltern-Themes im Verzeichnis `themes/ElternTheme/javascripts/system/` anlegen.

Wenn man z. B. ein neues Theme auf Basis von Honeygrid entwickelt und das Script `widgets/anchor.min.js`
(im [Entwickler-Modus](#devMode) ```widgets/anchor.js```) ersetzen möchte, so muss man die Datei
`themes/MeinNeuesTheme/javascripts/system/widgets/anchor.min.js` (im [Entwickler-Modus](#devMode)
`themes/MeinNeuesTheme/javascripts/system/widgets/anchor.js`) erstellen.

<details>
    <summary>Dateistruktur des Beispiels</summary>

    themes
    |
    +-- Honeygrid
    |   |
    |   +-- ...
    |   |
    |   +-- javascripts
    |   |   |
    |   |   +-- system
    |   |       |
    |   |       +-- ...
    |   |       |
    |   |       +-- widgets
    |   |       |   |
    |   |       |   +-- ...
    |   |       |   |
    |   |       |   +-- anchor.js
    |   |       |   |
    |   |       |   +-- anchor.min.js
    |   |       |   |
    |   |       |   +-- ...
    |   |       |
    |   |       +-- ...
    |   |
    |   +-- ...
    |
    +-- MeinNeuesTheme
        |
        +-- javascripts
            |
            +-- system
                |
                +-- widgets
                    |
                    +-- anchor.js
                    |
                    +-- anchor.min.js
</details>


### <a name="Erweiterung vorhandener Javascripts"></a>Erweiterung vorhandener Javascripts

Um eine Javascript-Datei auf jeder Seite des Shops zu laden, kann man eine neue Datei im Verzeichnis
`themes/MeinNeuesTheme/javascripts/custom/` erstellen. Dies kann besonders nützlich sein, wenn man eine
Javascript-Datei laden möchte, die auf verschiedene Bereiche des Shops Einfluss nimmt, wie z. B. ein bestimmtes
Verhalten eines Weihnachts-Themes, das auf jeder Seite des Shops greifen soll.

Damit keine spezifische Javascript-Datei überladen wird, sollte sichergestellt sein, dass in einem eventuellen
Eltern-Theme keine gleichnamige Datei existiert.

<details>
    <summary>Beispiel-Dateistruktur</summary>
    
    themes
        |
        +-- MeinNeuesTheme
                |
                +-- javascripts
                    |
                    +-- custom
                        |
                        +-- myscript.js
</details>


### <a name="Erweiterung spezifischer Javascripts"></a>Erweiterung spezifischer Javascripts

Um eine bestimmte Javascript-Datei zu erweitern, muss eine Datei im Verzeichnis
`themes/MeinNeuesTheme/javascripts/custom/` mit dem gleichen Namen wie in einem Eltern-Theme im Verzeichnis
`themes/ElternTheme/javascripts/system/` angelegt werden.

Dies kann nützlich sein, wenn man das Verhalten in einem bestimmten Bereich des Shops anpassen/ergänzen möchte.

<details>
    <summary>Beispiel-Dateistruktur</summary>

    themes
    |
    +-- Honeygrid
    |   |
    |   +-- ...
    |   |
    |   +-- javascripts
    |   |   |
    |   |   +-- system
    |   |       |
    |   |       +-- ...
    |   |       |
    |   |       +-- widgets
    |   |       |   |
    |   |       |   +-- anchor.js
    |   |       |   |
    |   |       |   +-- ...
    |   |       |
    |   |       +-- ...
    |   |
    |   +-- ...
    |
    +-- MeinNeuesTheme
        |
        +-- javascripts
            |
            +-- custom
                |
                +-- widgets
                    |
                    +-- anchor.js
</details>


### <a name="Bereichsspezifische Javascripts"></a>Bereichsspezifische Javascripts

Alle oben beschriebenen Möglichkeiten Javascript-Dateien zu erweitern und zu ersetzen, sind auch möglich
bereichsspezifisch hinzuzufügen. Das bedeutet, dass diese Dateien nur auf Seiten der entsprechenden Bereiche geladen
werden. Um dies zu erreichen muss ein Unterverzeichnis von `themes/MeinNeuesTheme/javascripts/custom/`, bzw.
`themes/MeinNeuesTheme/javascripts/system/` erstellt und die Datei in diesem Verzeichnis platziert werden, also z. B.
`themes/MeinNeuesTheme/javascripts/custom/Cart/my_script.js`.

Es gibt die folgenden Bereiche:

<details>
    <summary>Tabelle anzeigen</summary>

| Bereich            	| Beschreibung                	|
|--------------------	|-----------------------------	|
| CallbackService    	| Der Callback-Services       	|
| Manufacturers      	| Die Herstellerübersicht     	|
| ProductInfo        	| Die Produktdetailseite      	|
| Cat                	| Die Kategorieseite          	|
| Search             	| Die Suchergebnisseite       	|
| PriceOffer         	| Die Sonderangebotsseite     	|
| Cart               	| Der Warenkorb               	|
| Content            	| Content-Manager-Seiten      	|
| Wishlist           	| Der Merkzettel              	|
| AddressBookProcess 	| Die Adressbearbeitungsseite 	|
| GVSend             	| Die Gutscheinversendeseite  	|
| Checkout           	| Der Checkout                	|
| AccountHistory     	| Die Bestellhistorie         	|
| Account            	| Die Profilseite             	|
| Index              	| Die Startseite              	|
| Withdrawal         	| Das Widerrufsformular       	|

</details>


## <a name="Hinzufügen eines StyleEdit-Styles"></a>Hinzufügen eines StyleEdit-Styles

Um einen vordefinierten StyleEdit-Style einem Theme hinzuzufügen, kann eine entsprechende .json-Datei, dem Theme
hinzugefügt werden. Eine solche Datei muss im Verzeichnis ```themes/MeinNeuesTheme/styles/styleedit/``` liegen, also
z. B. ```themes/MeinNeuesTheme/styles/styleedit/mein_toller_style.json```. StyleEdit-Styles sind Theme-spezifisch und
stehen einem erbenden Theme (Kind-Theme) nicht zur Verfügung, wenn es dem vererbenden Theme (Eltern-Theme) zur
Verfügung steht. Eine StyleEdit-Style-Datei kann erzeugt werden, indem man einen neuen Style über den StyleEdit3
anlegt, diesen nach Belieben konfiguriert und anschließend über die "Download"-Aktion herunterlädt.


## <a name="Entwickler-Modus"></a>Entwickler-Modus

Für Entwickler ist es komfortabler, eine nicht minifizierte Version der verwendeten Stylesheets und Javascripts im Shop
zu laden, um einfacheres Debugging zu ermöglichen. Dehalb wurde der sogenannte "Entwickler-Modus" eingeführt, der
aktiviert werden kann indem eine (leere) Datei ```.dev-environment``` im Hauptverzeichnis des Shops erstellt wird.
In einem Shop werden außerdem einige wichtige Warnhinweise ausgeblendet, weshalb der Entwickler-Modus nicht für den
produktiven Betrieb eines Shops geeignet ist.


## <a name="Version dieser Dokumentation"></a>Version dieser Dokumentation

Diese Dokumentation beschreibt den Stand der GX 3.13.1.0 Beta3. Einige Details werden sich evtl. mit der
Veröffentlichung der folgenden Version noch ändern.