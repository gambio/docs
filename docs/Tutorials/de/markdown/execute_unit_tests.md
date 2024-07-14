# Ausführen von Unit Tests

**Hinweis:** Diese Seite enthält veraltete Informationen und wird bald überarbeitet.


In diesem Tutorial wird beschrieben, wie Sie Ihre Entwicklungsumgebung so konfigurieren können, dass die Unit-Tests
ausgeführt werden können.


## Vorwort
Als Vorraussetzung für dieses Tutorial sollten Sie etwas mit dem Terminal vertraut sein und bereits einen Test-Shop auf
Ihrem lokalen Webserver installiert und konfiguriert haben.


## PHPUnit

Wir benutzen [PHPUnit](https://phpunit.de/) als Testing-Framework für unsere Unit-Tests. Wie liefern PHPUnit
standardmäßig mit aus. Das heißt für Sie, dass Sie PHPUnit nicht explizit installieren müssen.

Sie finden die Datei im Verzeichnis `composer_components`.


## Konfiguration

Damit die Tests funktionieren können, muss PHPUnit-Testausführung zunächst konfiguriert werden.

Sie finden im Verzeichnis `test` die Datei `tests.config-sample.inc.php`. Diese Datei duplizieren Sie und benennen Sie
in `tests.config.inc.php` um.

Nach der Umbennenung öffnen Sie die Datei und fügen die benötigten Daten ein:

* `SHOP_URL` ist die Shop-URL (ohne Slash am Ende)
* `ADMIN_USER` ist die E-Mail-Addresse des Administratorkontos im Shop
* `ADMIN_PASSWORD` ist das Password des Administratorkontos im Shop
* `DB_HOST` ist die Serveraddresse der MySQL-Datenbank
* `DB_USER` ist der Benutzername der MySQL-Datenbank
* `DB_PASSWORD` ist das Password der MySQL-Datenbank
* `DB_NAME` ist der Name der zu nutzenden MySQL-Datenbank

**Hinweis**: Bitte denken Sie daran, dass die erstellte `tests.config.inc.php` unter __keinen Umständen__ gepusht
werden darf, da sie sensible Daten enthält.


## Ausführung der Tests

Im Verzeichnis `tests` finden Sie Kommandozeilenskripts, die Sie ausführen können. Unter **Windows** führen Sie das
Kommandozeilenskript `run_tests.bat` aus. In **Linux** und **Mac OS** führen Sie das Bash-Skript `run_tests.sh` aus.

Diese Skripte übernehmen für Sie das Einbinden der Konfigurationen und die Ausführung der Tests.
