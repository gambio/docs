## Anwendungskern

In der Version GX v4.1.1.0 ist der Anwendungskern des Shopsystem neu geschrieben worden. Das hat weitreichende Folgen,
die in diesen Tutorial erläutert werden sollen. 

#### Was ist ein Anwendungskern?

In der Software Entwicklung gibt es verschiedene Erläuterungen für den Begriff eines Anwendungskern. Unsere Erklärung
bezieht sich auf Web-Software die HTTP-Anfragen beantwortet, wie zum Beispiel das Gambio-Shopsystem.

Der Anwendungskern ist ein Mechanismus, der bei jeden HTTP-Request ausgeführt wird. Er ist dafür Verantwortlich, alle
Komponenten zu laden die benötigt werden um die weitere Logik der jeweiligen Seite auszuführen.

#### Version < 4.1.1.0

Vor der Version 4.1.1.0 hatte jede Seite, die vom Shopsystem bearbeitet worden ist, eine der folgenden Dateien
eingebunden:

- admin/includes/application_top.php
- includes/application_top.php
- includes/application_top_callback.php
- includes/application_top_export.php
- includes/application_top_main.php

Die Dateien sind der alte Anwendungskern. Dort wurde zum Beispiel die MainFactory, das alte Autoloading-System,
eingebunden und die Session gestartet.

Eine weitere Thematik zum *Anwendungskern* ist der *Einstiegspunkt*. Es gab zwei Möglichkeiten im GambioAdmin vor der
Version v4.1.1.0:

- Direkter Aufruf einer Datei: www.example.org/admin/customers.php
- Sogenannter *Front Controller*: admin.php?do=\[ControllerName ohne Controller am Ende]

Letzendlich haben alle Wege zu Beginn die application_top\[xyz].php Datei eingebunden, aber die Verarbeitung der Seite
anders gehandhabt.  
Punkt 1: Logik direkt in der Datei ausgeführt  
Punkt 2: Zu einer Controller-Klasse weitergeleitet (schon etwas eleganter)

##### Problem
Die oben genannten Dateien sind über die Jahre gewachsen und kaum noch wartbar. Es werden Jahrzehnte alte
Programmier-Paradigmen verwendet, die insgesamt einen großen
[Bottleneck](https://en.wikipedia.org/wiki/Bottleneck_(software) mit sich bringen.

Deshalb haben wir uns dazu entschlossen, einen neuen Anwendungskern zu entwickeln. Er stellt die Basis für alle
zukünftigen Entwicklungen.  
Um neue Funktionen auch auf Seiten verwenden zu können, die den alten Kern verwenden, gibt es eine Schnittstelle,
mit der die neu entwickelten Service Klassen im alten System geladen werden können. 

#### Version >= 4.1.1.0

Der neue Anwendungskern ist komplett neu entwickelt worden. Dabei haben wir uns an den aktuellen PHP Standards (PSR's) 
gehalten und binden moderne Open-Source Libraries (frei verfügbare Software-Bibliotheken) ein, um diese zu erfüllen.

Der modernisierte Kern wird aktuell nur an einigen Stellen im Shop verwendet. Er bildet die Basis für alle zukünftigen
Entwicklungen. Alle Seiten, die den alten Anwendungskern verwenden, sollen in den nächsten Jahren erneuert werden, so
dass langfristig alle Seiten ersetzt sind und der alte Kern problemlos entfernt werden kann.  
Externen Entwicklern wird ausdrücklich empfohlen, ihre Funktionen mit Hilfe der neuen Werkzeuge im Shopsystem
zu integrieren.

// Todo: wo wird er denn nun aktuell verwendet??!!11!0?

##### (neues) Problem
Ein Problem, dass die Neuentwicklung mit sich bringt ist, dass alle bisherigen Komponenten, wie *CacheControl*, aber auch alle Services die in den letzten
Jahren von uns Entwickelt worden sind im neuen System nicht mehr verwendet werden können.  

// Todo: Ihr Schweine!!1! und jetzt??!!1! was habt ihr euch nur dabei gedacht??0?ß1
