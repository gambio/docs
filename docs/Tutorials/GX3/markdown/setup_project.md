# Aufsetzen des Shop Projektes

Das Aufsetzen des Shop-Projekts ist nur notwendig, wenn du Zugriff auf das Gitlab Repository besitzt. Dieser Zugang
muss extra angefragt werden.

Sollte kein Zugriff vorhanden sein, kann natürlich auch auf Basis einer Vollversion entwickelt werden. Hierbei fallen
jedoch einige Schritte um das Projekt aufzusetzen weg. Im ganzen kann hier direkt mit der Entwicklung eigener Module
gestartet werden.


## Aufsetzen eines Projekts mit Zugang zum Gambio Gitlab

Solltest du Zugang zum Gitlab Repository des Shops haben, dann kannst du dich unter
[https://sources.gambio-server.net](https://sources.gambio-server.net) anmelden.


### Einen Fork vom Shop Projekt erzeugen

Um einen eigenen [Fork](https://de.wikipedia.org/wiki/Abspaltung_%28Softwareentwicklung%29) zu erstellen und später dann
einen lokalen Klon vom Shop zu erstellen, musst du folgende Schritte ausführen:

* Navigiere zu **[dieser Seite](https://sources/gambio/gxdev)** (ggf. musst du dich einloggen)
* Erstelle einen Fork des Projektes, indem du auf den Button **Fork** klickst (befindet sich oben rechts)
* Weise dir selbst den Fork zu, indem du auf deinen Usernamen klickst


### Eigenen Fork lokal clonen

Nun kannst du den Fork klonen, um lokal entwickeln zu können. Dafür musst du im Gitlab deinen Fork aufrufen und hast
dann die Wahl den Fork entweder über SSH oder über HTTPS zu klonen. Der Vorteil bei SSH gegenüber HTTPS ist, dass du
nicht jedes Mal deinen Benutzernamen und Passwort eingeben musst, wenn du eine Änderung pushst. 

Um über SSH ein Klon zu erstellen, muss aber zunächst einmal ein SSH-Schlüssel erstellt werden. Wie das funktioniert
kannst du [hier nachlesen](https://sources.gambio-server.net/help/ssh/README).

Jetzt kannst du schließlich einen lokalen Klon des Forks erstellen. Dafür musst du folgendes tun:

* Rufe deinen Fork im Gitlab auf
* Klicke oben rechts auf den Button **Klonen**
* Kopiere den Inhalt aus dem Feld **SSH**, dies ist die Git-Repository-Adresse
* Öffnen Sie ein Terminal und navigiere zu deinem gewünschten Ziel-Verzeichnis (z.B. zum lokalen Webserver).

Nun gib folgenden Befehl ein:
```sh
> git clone GIT-ADRESSE
```

Wobei `GIT-ADRESSE` der eben kopierte Git-Repository-Adresse entspricht.

Nach dem clonen deines Forks befindest du dich im Standard-Branch. In der Regel ist der Standard-Branch immer die
aktuellste Version, an der wir arbeiten.  Falls du aber den Branch wechseln möchtest, kannst du das über folgenden
Befehl tun:

```sh
> git checkout BRANCHNAME
```

Wobei `BRANCHNAME` dem gewünschten Branch entspricht.

Wir empfehlen im Idealfall einen unserer Release-Branches oder einen Release-Tag (Versions-Tag) für die eigentlich
Entwicklung zu verwenden. So stellst du sicher, dass deine Entwicklungsgrundlage einer realen Shop-Version entspricht.

### Shop Projekt aufsetzen

Bevor du am Shop entwickeln kannst, musst du zunächst die benötigten Abhängigkeiten installieren. Dies kannst du mit
den folgenden Befehlen tun:

```sh
> yarn install
> yarn configure
```

Dieser Vorgang kann einige Minuten dauern. Sobald der Vorgang jedoch abgeschlossen ist, kannst du die Projektdateien
auf deinen Webserver hochladen (oder in ein entsprechendes Verzeichnis verschieben) und den Shop aufrufen.