# Installation notwendiger Programme und Tools

Damit wir entwickeln können, müssen zuerst einige der benötigten Programme und Tools installiert werden.
Hierzu gehören:

* **Webserver:**:
    Damit die Onlineshop Software ausgeführt werden kann, ist ein Webserver mit einer mindest PHP-Version von 7.1
    notwendig.
* **Git:**
    Um für die Weiterentwicklung des Shops notwendigen Änderungen am Quellcode zu verwalten, benutzen wir die verteilte
    Versionsverwaltung **[Git](https://git-scm.com/)**.
* **Composer:**
    Der Shop hat einige Abhängigkeiten zu externen PHP-Bibiotheken. Um diese Abhängigkeiten zu installieren, wird der
    PHP-Paketmanager **[Composer](https://getcomposer.org/)** benutzt.
* **Node.js:**
    [Node.js](https://nodejs.org/en/) ist eine Plattform, die zur serverseitigen Ausführung von JavaScript-Code genutzt
    wird und dient als Basis für viele unserer Entwicklungswerkzeuge, wie u.a. Bower und Gulp, die in den nächsten
    Schritten behandelt werden.
* **Yarn:**
    [Yarn](https://yarnpkg.com) ist ein alternativer Paketmanager für Node.js, über den du Module und
    Entwicklungswerkzeuge installieren kannst. Hier ist eine kleine Auflistung von Modulen, die wir im Shop verwenden:
    * **Gulp:**
        **[Gulp](http://gulpjs.com/)** ist ein Werkzeug, mit dem wir Entwicklungsprozesse, wie z. B. das Kompilieren
        der Sass-Dateien automatisieren können.
    * **JSHint:**
        **[JSHint](http://jshint.com/)** ist ein Werkzeug zum Validieren von JavaScript-Code.
    * **Mocha:**
        **[Mocha](https://mochajs.org/)** ein Werkzeug zum Testen von JavaScript-Modulen.

Nachfolgend wird beschrieben, wie diese Programme und Tools für Windows, Mac OS und Linux installiert werden können.


**Inhalt:**

* <a href="#Windows">Windows</a>
    * <a href="#Webserver">Webserver</a>
    * <a href="#Git">Git</a>
    * <a href="#Composer">Composer</a>
    * <a href="#Node.js">Node.js</a>
    * <a href="#Yarn">Yarn</a>
* <a href="#Mac OS">Mac OS</a>
    * <a href="#Git">Git</a>
    * <a href="#Composer">Composer</a>
    * <a href="#Node.js">Node.js</a>
    * <a href="#Yarn">Yarn</a>
* <a href="#Linux">Linux</a>
    * <a href="#Git">Git</a>
    * <a href="#Composer">Composer</a>
    * <a href="#Node.js">Node.js</a>
    * <a href="#Yarn">Yarn</a>



## <a name="Windows"></a>Windows

### <a name="Webserver"></a>Webserver

Du kannst das Paket **[XAMPP](https://www.apachefriends.org/de/index.html)** benutzen, um einen lokalen Webserver auf
einfache Weise zu installieren. 


### <a name="Git"></a>Git

Um Git auf deinen Rechner zu installieren, tue bitte folgendes:

* Navigiere zu der offiziellen **[Webste von Git](https://git-scm.com/)**
* Klicke rechts auf **Downloads for Windows**
* Öffne das Installationspaket und folge den Schritten
* Im Schritt **Adjusting your PATH environment** solltest du **Use Git from the Windows Command Prompt** auswählen,
  damit du die Git-Befehle von der Windows-Eingabeaufforderung ausführen können.

Nach der Installation kannst du zur Überprüfung die Git-Version ausgeben lassen. Dafür öffnest du die
Eingabeaufforderung und gibst folgenden Befehl ein:

```sh
> git --version
```


### <a name="Composer"></a>Composer

Composer wird nicht von PHP mitgeliefert und muss daher manuell installiert werden.

* Navigiere zu [dieser Seite](https://getcomposer.org/download/)
* Klicke unter Windows Installer auf den Link **Composer-Setup.exe**
* Öffne das Installationspaket und folge der Installationsanleitung


### <a name="Node.js"></a>Node.js

Um Node.js zu installieren, führe folgende Schritte aus:

* Navigiere zu [dieser Seite](https://nodejs.org/en/)
* Klicke auf den Button mit der **Stable-Versionsnummer**
* Öffne das Installationspaket und folge der Installationsanleitung.

Nachdem die Installation erfolgt ist, kannst du überprüfen, ob die Installation erfolgreich war, indem du die
Node.js-Version ausgeben lässt:

```sh
> node -v
```


### <a name="Yarn"></a>Yarn

Yarn wird nicht von Node.js mitgeliefert und muss daher manuell installiert werden:

* Navigiere zu [Yarn](https://yarnpkg.com/en/docs/install)
* Führe die dortigen Anweisungen aus.

Nach einer erfolgreichen Installation, sollte der folgende Befehl die installierte Yarn-Version ausgeben:

```sh
$ yarn --version
```


## <a name="Mac OS"></a>Mac OS

Homebrew ist ein Paketmanager für Mac OS. Mit Hilfe dieses Paketmanagers können verschiedenste Programme ganz leicht
über die Kommandozeile installiert werden, die sonst umständlich manuell über die jeweilige Internetseite
heruntergeladen und installiert werden müssten. Um Homebrew zu installieren, gib folgenden Befehl in dein Terminal ein:

```sh
> /usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"
```

Homebrew sollte anschließend installiert sein. Nun kannst du schauen, ob Homebrew erfolgreich installiert wurde:

```sh
> brew -v

Homebrew 0.9.5 (git version b04f; last commit 2016-02-15)
```

Erscheint bei dir eine ähnliche Meldung, verlief alles tadellos.


### <a name="Git"></a>Git

Zunächst stellen wir mit Hilfe des folgenden Befehls sicher, dass Homebrew die aktuellsten Informationen über alle
Pakete enthält:

```sh
> brew update

Updated Homebrew from d47bd54 to b40f107
...
```

Anschließend installieren wir Git:

```sh
> brew install git
```

Um zu überprüfen, ob Git korrekt installiert wurde, kannst du folgenden Befehl im Terminal ausführen:

```sh
> git --version

git version 2.5.0
```


### <a name="Composer"></a>Composer

Composer wird nicht von PHP mitgeliefert und muss von daher manuell installiert werden:

* Navigiere zu [Composer](https://getcomposer.org/download/)
* Führe die dortigen Befehle im Terminal aus.

Nach einer erfolgreichen Installation, sollte der folgende Befehl die installierte Composer-Version ausgeben:

```sh
> composer --version

Composer version 1.0-dev (a2fc502c208fcb3ac4700b934057a33ca130644b) 2016-01-18 12:41:09
```


### <a name="Node.js"></a>Node.js

Führe den folgenden Befehlen im Terminal aus, um Node.js installieren:

```sh
> brew install node
```

Nachdem die Installation erfolgt ist, kannst du überprüfen, ob die Installation erfolgreich war indem du die
Node.js-Version ausgeben lässt:

```sh
> node -v

v4.0.0
```


### <a name="Yarn"></a>Yarn

Yarn wird nicht von Node.js mitgeliefert und muss daher manuell installiert werden:

* Navigiere zu [Yarn](https://yarnpkg.com/en/docs/install)
* Führe die dortigen Befehle im Terminal aus.

Nach einer erfolgreichen Installation, sollte der folgende Befehl die installierte Yarn-Version ausgeben:

```sh
$ yarn --version
```


## <a name="Linux"></a>Linux

Bitte beachten Sie, dass je nach Distribution einige Komponenten schon vorinstalliert sein können.
Ist dies der Fall, empfehlen wir dir, die entsprechenden Komponenten auf die neueste Version zu aktualisieren.

In einigen Linux-Distributionen werden zudem unterschiedliche Systempaketmanager benutzt: Zum Beispiel ist es in Ubuntu
[Aptitude](https://wiki.ubuntuusers.de/aptitude/) *(apt)*, in Fedora und openSUSE [rpm](http://rpm.org/) *(yum)*.
In diesem Tutorial wird davon ausgegangen, dass **Aptitude** benutzt wird.


### <a name="Git"></a>Git

In den meisten Linux-Distributionen, wie z. B. Ubuntu, wird Git bereits installiert mitgeliefiert.
Um zu überprüfen, ob Git installiert ist, kannst du folgenden Befehl im Terminal ausführen:

```sh
$ git --version
```

Falls Git installiert ist, sollte eine Ausgabe der Version erfolgen. Falls der Befehl nicht gefunden wurde, muss Git
installiert werden. Dies kannst du über den Aptitude Paketmanager folgendermaßen tun:

```sh
$ sudo apt-get install git
```

### <a name="Composer"></a>Composer

Composer wird nicht von PHP mitgeliefert und muss daher manuell installiert werden:

* Navigiere zu [Composer](https://getcomposer.org/download/)
* Führe die dortigen Befehle im Terminal aus.

Nach einer erfolgreichen Installation, sollte der folgende Befehl die installierte Composer-Version ausgeben:

```sh
$ composer --version
```

### <a name="Node.js"></a>Node.js

Führe folgende Befehle im Terminal aus, um Node.js installieren:

```sh
$ curl -sL https://deb.nodesource.com/setup_4.x | sudo -E bash --
$ sudo apt-get install -y nodejs
```

Nachdem die Installation erfolgt ist, kannst du überprüfen, ob die Installation erfolgreich war, indem du die
Node.js-Version ausgeben lässt:

```sh
$ node -v
```


### <a name="Yarn"></a>Yarn

Yarn wird nicht von Node.js mitgeliefert und muss daher manuell installiert werden:

* Navigiere zu [Yarn](https://yarnpkg.com/en/docs/install)
* Führe die dortigen Befehle im Terminal aus.

Nach einer erfolgreichen Installation, sollte der folgende Befehl die installierte Yarn-Version ausgeben:

```sh
$ yarn --version
```