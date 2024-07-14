# Nutzung von Vagrant

In diesem Tutorial wird Vagrant beschrieben und wie du mit diesem eine Gambio Entwicklungsumgebung einrichten kannst.


## Was ist Vagrant?

Mit Vagrant lassen sich einfach und schnell reproduzierbare und portable Entwicklungsumgebungen einrichten. Hierzu
bietet Vagrant einen Layer für Anbieter von virtuellen Maschinen wie beispielsweise VirtualBox, VMware oder AWS.


## Was benötige zur Installation?

Zunächst musst du Vagrant und eine virtuelle Maschine installieren. In diesem Tutorial werden wir VirtualBox
installieren, welche Open Source ist.

Für beide Programme gibt es für jedes System Installationspakete. Die Installationpakete für Vagrant findest du auf
[vagrantup.com](https://www.vagrantup.com/downloads.html) und für VirtualBox auf [virtualbox.org](https://www.virtualbox.org/wiki/Downloads).

Nach der erfolgreichen Installation von Vagrant und VirtualBox, kannst du im nächsten Schritt die Gambio
Entwicklungsumgebung einrichten.


## Entwicklungsumgebung einrichten

Zunächst musst du das Gambio Projekt von unserem Repository klonen. Anschließend befindet sich im Root-Verzeichnis eine
Datei namens **Vagrantfile**, welches die Konfiguration für die virtuelle Maschine beinhaltet. In dieser Datei kannst
du ggf. weitere Modifikationen vornehmen. Weitere Informationen dazu findest du in der [Vagrant Dokumentation](https://www.vagrantup.com/docs/vagrantfile/).

Du kannst die virtuelle Maschinen starten in dem du den Befehl `vagrant up` ausführst. Wenn du den Befehl zum ersten
mal ausführst, wird automatisch die notwendige Vagrant Box von unserem Gambio Server heruntergeladen und installiert.
Sobald der Befehl beendet ist, wird die virtuelle Maschine gestartet. Dies kannst du prüfen indem du die URL
`http://localhost:8080` aufrufst. Nun kannst du dein Projekt auf der Hostmaschine bearbeiten und die Dateien werden
automatisch mit der Virtuellen synchronisiert. 

Die installierte Vagrant Box ist eine Ubuntu 14.04 64-bit Version. Du kannst dich über SSH mit dem Befehl `vagrant ssh`
auf diese Maschine verbinden. Nachdem du dich mit der Maschine verbunden hast, kannst du zum folgenden Verzeichnis
navigieren: `/var/www/html/gxdev`. Hier befindet sich der von dir erstellte Klon unseres Repositories. Wenn du die
Verbindung von der virtuellen Maschine trennen möchtest, dann kannst du dies mit Hilfe des Befehls `exit` tun.

**Es gibt folgende Befehle um Vagrant zu beenden:**

* `vagrant suspend` speichert den aktuellen Stand der virtuellen Maschine bis zum nächsten Neustart deines Computers
  und beendet sie. 
* `vagrant halt` speichert den aktuellen Stand und beendet die Maschine.
* `vagrant destroy` löscht alle Inhalte der virtuellen Maschine.

Weiteres zu Vagrant CLI-Befehlen findest du unter [vagrantup.com](https://www.vagrantup.com/docs/cli/).


## Shop einrichten

Wenn du dir einen frischen Klon erstellt hast, müssen zunächst die `assets` für den Shop eingerichtet werden. Dies
erledigst du, indem du den Befehl `npm run configure` im Verzeichnis `/var/www/html/gxdev` ausführst.

Wenn du die Maschine startest, besitzt diese bereits eine Datenbank namens **gxdev**.

Du kannst dich mit Hilfe der folgenden Daten mit der Datenbank verbinden:

* dbhost: localhost
* dbuser: root
* dbpass: root

Falls du phpMyAdmin nutzen möchtest, ist dieses bereits vorhanden und über die URL `http://localhost:8080/phpmyadmin`
erreichbar.

Anschließend musst du jeweils eine `configure.php` und eine `configure.org.php` in den Verzeichnissen
`/var/www/html/gxdev/src/includes` und `/var/www/html/gxdev/src/admin/includes` erstellen.

Nun kannst du zu der URL http://localhost:8080/gxdev/src/gambio_installer navigieren und den Shop installieren.


## Wichtige Informationen

1.  Dadurch, dass die Verzeichnisse der virtuellen Maschine und der Hostmaschine synchronisiert werden, benötigen
    die Gulp Dev-Tasks mehr Ressourcen und brauchen somit auch mehr Zeit. Deshalb raten wir dir an, die Gulp Dev-Tasks
    nur auf der Hostmaschine und nicht in der virtuellen Maschine auszuführen. Die Gulp Build-Tasks laufen hingegen
    ohne Probleme auf der Host- sowie in der virtuellen Maschine.
2.  Wir raten dazu ein `vagrant halt` auszuführen um Vagrant zu beenden. So ist es möglich beim nächsten Start wieder
    am letzten Stand anzuknüpfen. 
3.  Bei einem `vagrant up` kann es sein, dass du eine Nachricht in der Kommandozeile erhälst um Vagrant auf den
    neuesten Stand zu aktualisieren. Wir raten dir, diesen Befehl jedes Mal auszuführen sobald der Hinweis erscheint,
    damit du immer auf den aktuellen Stand bist.