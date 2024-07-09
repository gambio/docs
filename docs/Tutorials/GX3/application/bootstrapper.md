## Bootstrapper

Die [Bootstrapper][bootstrapper interface] dienen dazu, den [Anwendungskern][ioc container] soweit aufzusetzen, damit
dieser eingehende HTTP-Anfragen verarbeiten kann. So gibt es zum Beispiel zum Aufsetzen der User Session, zum
registieren diverser [Service Provider](serivce provider), Routen oder Plugnis.

Die `Bootstrapper` Klassen besitzen [keinen Konstruktor][abstract bootstrapper] und müssen die Methode `boot`
implementieren, welche die `Application` Klasse als Parameter besitzt.

Bootstrapper lassen sich in zwei verschiedene Varianten kategorisieren:

1. **Kernel Bootstrapper**  
   Dieser *Bootstrapper* wird an zentraler Stelle dem [Kernel](kernel) übergeben und ist eine
   [Komposition][admin bootstrapper] aus mehreren Sub Bootstrappern.
2. **Sub Bootstrapper**  
   Diese *Bootstrapper* setzen nur einen Teil des Gesamtsystems auf, zum Beispiel die [Session][session bootstrapper]
   oder die Registrierung der [Service Provider][admin service bootstrapper].

[ioc container]: ./ioc_container.md
[bootstrapper interface]: ../../../src/GambioCore/Application/Kernel/Bootstrapper.php
[abstract bootstrapper]: ../../../src/GambioCore/Application/Kernel/AbstractBootstrapper.php
[admin bootstrapper]: ../../../src/GambioAdmin/Application/Kernel/AdminBootstrapper.php
[admin service bootstrapper]: ../../../src/GambioAdmin/Application/Kernel/Bootstrapper/AdminServiceProviderRegistration.php
[session bootstrapper]: ../../../src/GambioCore/Application/Kernel/Bootstrapper/SetSessionParameters.php
