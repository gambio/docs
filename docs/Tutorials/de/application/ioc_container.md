## Gambio Core - Dependency Container


### Einführung

Die `Application` Klasse (vollständiger Namespace `Gambio\Core\Application`) dient im Shopsystem als Dependency
Container und stellt das Rückrat des Anwendungskerns dar. Ihre Aufgabe ist es alle Service Klassen bereitzustellen. 
Aus technischer Sicht entspricht dies der Implementierung eines *Inversion of control containers* (kurz IoC) und folgt
dem PHP Standard *PSR-11*.

In den folgenden Abschnitten werden die Begriffe *Dependency Injection* bzw *Inversion* und *Inversion of control
containers* erklärt, sowie deren Nutzen bei der Entwicklung.


#### Was ist ein "Inversion of control container"?

Bei den [SOLID Prinzipien](https://de.wikipedia.org/wiki/Solid_(Software)) handelt es sich um Regeln, die zu einem
guten objektorientierten Design führen sollen. Das fünfte Prinzip (Dependency Inversion Prinzip) befasst sich mit
der Thematik *Dependency Injection* und der Reduzierung von Kopplungen zwischen Klassen und Objekten.


##### Dependency Injection

*Dependency Injection* bedeutet, dass Konstruktoren und Methoden von Klassen **niemals** neue Klassen erstellen,
sondern die Abhängigkeiten der jeweiligen Klassen über den Funktionsparametern definiert und übergeben werden.

__Falsch:__

```php
class MyClass
{
    private $dependency;
    public function __construct() 
    {
        // hier ist der Fehler! "Dependency" sollte als Parameter übergeben werden anstatt 
        // mit "new" neu erstellt zu werden
        $this->dependency = new Dependency();
    }

    public function method(): void
    {
        // hier wieder der gleiche Fehler. "OtherDependency" muss auch hier als Abhängigkeit
        // über den Methodenparameter definiert werden.
        $otherDependency = new OtherDependency();
        
        $this->dependency->doSomething($otherDependency);
    }
}
```

__Richtig:__

```php
class MyClass
{
    private $dependency;

    // hier wird der Wert einer Abhängigkeit von außen übergeben
    public function __construct(Dependency $dependency) 
    {
        $this->dependency = $dependency;
    }

    // und auch hier wird der Wert der Abhängihkeit von außen übergeben
    public function method(OtherDependency $otherDependency): void
    {
        $this->dependency->doSomething($otherDependency);
    }
}
```

Dadurch ist es viel einfacher *Unit Tests* für die Klasse zuschreiben, was die Fehleranfälligkeit des Systems
deutlich reduziert. Doch warum wird es leichter Unit Tests zu schreiben, wenn man das Dependency Injection Muster folgt?

In Unit Tests können Abhängigkeiten ganz einfach "gefälscht" werden. Das Bedeutet, dass man anstelle eines Objekts der
konreten Klasse ein sogenanntes *Dummy* Objekt übergibt, dass die Anforderungen der Methoden/Kontruktoren Signatur
erfüllt (damit PHP keinen Fehler auslöst). Im Test wird dann lediglich die Interaktion zwischen der zu testenden Klasse
und der Abhängigkeit überprüft.

Ein weiterer Vorteil des Entwurfmusters ist, dass die Komplexität des Codes deutlich reduziert wird. Im allgemeinen sind
Klassen abhängig von anderen Klassen. Im oben genannten Beispiel hatte weder `Dependency`, noch `OtherDependency` einen
Kontruktor Parameter. Das ist aber nur selten der Fall, den in der Regel haben viele Klassen weitere Abhängigkeiten,
die dann wiederum `MyClass` kennen müsste.

Beim *Dependency Injection Prinzips* wird die Abhängigkeit im Konstruktor oder in einer Methode definieren und kann
dann im Code mit dieser interagieren. Hierbei ist direkt an der Methodensignatur des Konstruktors oder der Methoden
erkennbar, über welche Abhängigkeiten diese Klasse verfügt (anders als in dem Beispiel mit `MyClass`). Die Objekte
werden in der Regel in Factory-Klassen (Fabrik-Klassen) von außen erstellt und übergeben.

Durch den Dependency Injection Entwurfsmuster ist es viel leichter, das erste SOLID Prinzip (Single Responsibility,
eine Zuständigkeit) einzuhalten. Die oben genannten Vorteile sind dabei ein (schöner) Nebeneffekt.


##### Dependency Inversion

Dependency Injection und Inversion können vom Wortlaut leicht verwechselt werden. *Dependency Inversion* bedeutet, dass 
nicht konkrete, sondern abstrakte Klassen oder noch besser Interfaces zur Definition von Abhängigkeiten verwendet
werden. So wird die Kopplung zwischen Klassen noch weiter reduziert und die Implementierungen können leichter
ausgetauscht werden.


##### Inversion of control container

Nun wissen wir was, was die "fancy" Begriffe *Dependency Injection* bzw. *Inversion* bedeuten. Was ist aber nun der 
*Inversion of control container*?

Die Aufgabe des IoC-Containers ist es, alle Service Klassen bereitzustellen wohingegen Aufgabe des Shop-Systems ist,
eingehende HTTP-Anfragen zu beantworten.

Letzteres funktioniert grob formuliert, indem einer URL eine Funktion zugewiesen wird. Eine Controller Klasse kann
zum Beispiel mehrere zugewiesene Funktionen in Form von Methoden bereitstellen. Ein anderer Mechanismus erkennt die URL
der eingegangenen HTTP-Anfrage und führt im Anschluss die gewünschte Methode aus.

Im besten Fall hat nun der Controller über den Konstruktor ein oder mehrere Service Klassen injeziert. Dadurch werden
die ganzen Clean-Code Prinzipien eingehalten und wir können nun mit Hilfe der Services komplexe Funktionalitäten
ausführen.

Und genau hier kommt der *Inversion of control container* bzw. unsere `Application` Klasse ins Spiel. Es ist Aufgabe
dieser Klasse, alle Services für das Shopsystem bereitzustellen.

Beim der Initialisierung der Shopanwendung werden alle *Service Provider* geladen. Innerhalb der *Service Provider*
werden die verschiedenen Abhängigkeiten der Services definiert. Erst wenn ein bestimmter Service vom Container angefragt
wird, startet der Container den Initialisierungs-Prozess für diesen Service und gibt diesen zurück.