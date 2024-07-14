## 1. Einführung

In den Tutorial entwickeln wir zusammen ein kleines Plugin für den GambioAdmin. Am Ende soll es in der Lage sein, eine
Übersicht mit Informationen zu allen installierten Plugins darzustellen.

#### Anwendungskern
In der Version 4.1.1.0 ist der Anwendungskern erneuert worden. Doch was bedeutet der Begriff *Anwendungskern* und was
bedeutet es 

### Voraussetzungen

- Gambio Shop Version: >= 4.1.1.0
- Web-Server (lokal oder remote)
- IDE (Integrated Developer Environment / Entwicklungsumgebung) | Empfehlungen:
    1. PHPStorm
    2. Visual Studio Code

Während des Tutorials werden wir ausschließlich innerhalb des Verzeichnisses *GXModules* arbeiten. Trotzdem ist
es empfehlenswert, das gesamte Shopverzeichniss in der IDE zu öffnen. Die meisten Entwicklungsumgebungen sind dadurch
in der Lage, mit Hilfe der Code-Completion Funktion die Arbeit deutlich zu erleichtern. Außerdem sind so viele Fehler,
wie die Verwendung falscher Namespaces, viel leichter zu finden und zu beheben.  
Die PHPStorm-IDE zum Beispiel zeigt während des tippens eines Klassennamens eine Liste mit Vorschlägen zu vorhandenen
Klassen an. Wenn die gewünschte Klasse mit der *Enter* Taste eingebunden wird, kümmert sich die IDE automatisch darum,
den Namespace richtig im *use* statement am Anfang der Datei zu setzen.


