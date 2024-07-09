# Verwendung der Zugriffsverwaltung

Mit der Shop Version GX3.9 haben wir als Feature den *AdminAccess* implementiert, welcher die alte Zugriffs- und
Berechtigungsverwaltung des Shops komplett abgelöst hat. Im Zusammenhang mit der Nutzung der neuen Zugriffsverwaltung
und auch der Einbindung deiner eigenen Module in dieses Systems, ist es durchaus sinnvoll zunächst einmal ein paar
Begriffe zu klären.


**Inhalt:**

* <a href="#Begriffsklärung">Begriffsklärung</a>
* <a href="#Nutzung der Zugriffsverwaltung">Nutzung der Zugriffsverwaltung</a>
    * <a href="#Initialisierung des AdminAccessService">Initialisierung des AdminAccessService</a>
    * <a href="#Berechtigungen eines Benutzers überprüfen">Berechtigungen eines Benutzers überprüfen</a>
    * <a href="#Eine neue Zugriffsrolle anlegen und zuweisen">Eine neue Zugriffsrolle anlegen und zuweisen</a>
    * <a href="#Neue Zugriffsgruppe erstellen und Controller, Seiten und AjaxHandler hinzufügen">Neue Zugriffsgruppe erstellen und Controller, Seiten und AjaxHandler hinzufügen</a>
    * <a href="#Einer Rolle die Berechtigung für eine Gruppe gewähren">Einer Rolle die Berechtigung für eine Gruppe gewähren</a>



## <a name="Begriffsklärung"></a>Begriffsklärung

* **AdminAccessUser:**
  Hierbei handelt es sich um einen Admin/Adminaccount, welcher über die CustomerId referenziert wird.
  
* **AdminAccessRole:**
  Hierbei handelt es sich um eine Zugriffsrolle, für welche einzelne Berechtigungen gesetzt werden können. Einem Admin
  können mehrere Zugriffsrollen zugewiesen werden. Gewährt ihm auch nur eine Zugriffsrolle die Berechtigung für etwas,
  so ist er vom System aus berechtigt, auch wenn er laut anderen Zugriffsrollen diese Berechtigung nicht besäße.
  
* **AdminAccessGroup:**
  Hierbei handelt es sich um eine Zugriffsgruppe, welche eine Sammlung von verschiedenen Seiten, Controllern oder
  AjaxHandlern darstellt. Dies haben wir gemacht, um die Verwaltung der Rechte möglichst komfortabel zu gestalten, so
  dass ein Admin nicht für jeden Controller etc. sagen muss, ob die Nutzung erlaubt ist. Die Gruppen sind dabei so
  aufgebaut, dass diese nur zusammengehörige Seiten, Controller und AjaxHandler enthalten.
  
* **AdminAccessPermission:**
  Hierbei handelt es sich um eine Zugriffsberechtigung, welche eine Kombination aus AdminAccessGroup und
  AdminAccessRole darstellt. Diese Kombination besitzt dabei bestimmte Merkmale: Ist Lesen, Schreiben, Löschen erlaubt.

**Hinweis:** Im AdminAccess wird zwar bereits zwischen Lese-, Sschreib- und Lösch-Berechtigungen unterschieden, dies
macht der Shop jedoch noch nicht. Innerhalb des Shops wird bisher nur die Lese-Berechtigung ausgewertet. Für die eigene
Verwendung und Berechtigungsabfrage kann dies aber schon genutzt werden.


## <a name="Nutzung der Zugriffsverwaltung"></a>Nutzung der Zugriffsverwaltung
Im Gambio Admin kann die Zugriffsverwaltung über den Menüpunkt *Rollen und Berechtigungen* unter *Kunden* aufgerufen
und genutzt werden. Damit du nun aber die Zugriffsverwaltung nutzen kannst oder dein eigenes Modul in diese einbindest,
musst du den AdminAccessService nutzen. In den folgenden Abschnitten zeigen wir dir zum einen wie du den Service
initialisiert und geben die ein paar Beispiele, welche Funktionalitäten er dir bietet.

**Hinweis:** Um ein genaueres Bild über die Funktionalität des Services zu erhalten, empfiehlt es sich, das Interface unter
`GXMainComponents/Services/System/AdminAccess/Interfaces/AdminAccessServiceInterface.inc.php` genauer anzuschauen.


### <a name="Initialisierung des AdminAccessService"></a>Initialisierung des AdminAccessService
Die Initialisierung des Services ist einfach und geschieht wie die Initialisierung anderer Services im Shop:

```php
$adminAccessService = StaticGXCoreLoader::getService('AdminAccess');
```


### <a name="Berechtigungen eines Benutzers überprüfen"></a>Berechtigungen eines Benutzers überprüfen
Generell kann sowohl für den aktuell eingeloggten Benutzer, als auch für einen anderen Benutzer die Berechtigung geprüft
werden. Hierbei es ist lediglich entscheident, welche *CustomerId* für die Überprüfung verwendet wird. Außerdem ist zu
beachten, dass nur gezielt für einen Controller, eine Seite oder einen AjaxHandler die Berechtigung abgefragt werden kann.

Die nachfolgenden Beispiele veranschaulichen dies:

```php
$adminAccessService = StaticGXCoreLoader::getService('AdminAccess');

# Check reading permission for controller "ExampleController"
$identifier = new NonEmptyStringType('Example');
$currentAdmin = new IdType($_SESSION['customer_id']);
if($adminAccessService->checkReadingPermissionForController($identifier, $currentAdmin))
{
    # do something
}
```

```php
$adminAccessService = StaticGXCoreLoader::getService('AdminAccess');

# Check deleting permission for page "example.php"
$identifier = new NonEmptyStringType();
$currentAdmin = new IdType($_SESSION['customer_id']);
if($adminAccessService->checkDeletingPermissionForPage($identifier, $currentAdmin))
{
    # do something
}
```

```php
$adminAccessService = StaticGXCoreLoader::getService('AdminAccess');

# Check writing permission for ajax handler "ExampleAjaxHandler"
$identifier = new NonEmptyStringType('Example');
$currentAdmin = new IdType($_SESSION['customer_id']);
if($adminAccessService->checkWritingPermissionForAjaxHandler($identifier, $currentAdmin))
{
    # do something
}
```

```php
$adminAccessService = StaticGXCoreLoader::getService('AdminAccess');

# Check reading permission for controller "ExampleController" and action "doSomethingAwesome"
$identifier = new NonEmptyStringType('Example/doSomethingAwesome');
$currentAdmin = new IdType($_SESSION['customer_id']);
if($adminAccessService->checkReadingPermissionForController($identifier, $currentAdmin))
{
    # do something
}
```

**Hinweis:** Die ersten drei Beispiele zeigen, dass bei der Überprüfung der Berechtigung zwischen Lese-, Schreib- und
Löschberechtigung unterschieden wird. Außerdem muss bei jeder Abfrage ein *Identifier* übergeben werden. Hierbei handelt
es sich um den Namen der Seite, des Controllers oder AjaxHandlers. Das erste und dritte Beispiel zeigen dabei aber auch,
dass der Suffix `Controller` oder `AjaxHandler` nicht im *Identifier* auftauchen dürfen, wobei bei den Seiten die
Dateiendung mit anzugeben ist. Das vierte Beispiel zeigt, dass bei einem Controller auch für eine bestimmte Methode die
Berechtigung abgefragt werden kann. Hier ist dann nach dem Namen des Controller, der Name der Methode (mit
vorgeschobenem Slash und ohne vorstehendes `action`) anzugeben.


### <a name="Eine neue Zugriffsrolle anlegen und zuweisen"></a>Eine neue Zugriffsrolle anlegen und zuweisen
Über den Service können auch neue Zugriffsrollen angelegt und einem Nutzer zugewiesen werden.

```php
$adminAccessService = StaticGXCoreLoader::getService('AdminAccess');

# Create a new admin access role
$name = new KeyValueCollection([
    'EN' => 'Example role',
    'DE' => 'Beispiel-Rolle',
]);
$description = new KeyValueCollection([
    'EN' => 'A new example role',
    'DE' => 'Eine neue Beispiel-Rolle',
]);
$sortOrder = new IntType(100);
$unknownReadingGranted = new BoolType(true);
$unknownWritingGranted = new BoolType(true);
$unknownDeletingGranted = new BoolType(true);
$createdRole = $adminAccessService->createNewRole(
    $name,
    $description,
    $sortOrder,
    $unknownReadingGranted,
    $unknownWritingGranted,
    $unknownDeletingGranted
);

# Assign new role to admin with customer id 2
$roleId = new IdType($createdRole->getId());
$adminId = new IdType(5);
$adminAccessService->addRoleToUserByCustomerId($roleId, $adminId);
```

**Hinweis:** Bei den Variablen `unkownReadingGranted`, `unkownWritingGranted` und `unknownDeletingGranted` handelt es sich
um die Konfiguration, ob die Rolle die Berechtigung für unbekannte Controller, Pages oder AjaxHandler besitzen soll.
Wir empfehlen hier, wie auch im Gambio Admin bei der Verwaltung der Berechtigungen, diese Berechtigungen zu erteilen. 


### <a name="Neue Zugriffsgruppe erstellen und Controller, Seiten und AjaxHandler hinzufügen"></a>Neue Zugriffsgruppe erstellen und Controller, Seiten und AjaxHandler hinzufügen

Diese Abschnitt ist besonders interessant, wenn du eine eigene Zugriffsgruppe für dein Modul anlegen möchtest.
Nachdem du das getan hast, kannst du die Zugriffsberechtigungen für dein Modul über den Service abfragen.

```php
$adminAccessService = StaticGXCoreLoader::getService('AdminAccess');

# Create new admin access group
$name = new KeyValueCollection([
    'EN' => 'Example group',
    'DE' => 'Beispiel-Gruppe',
]);
$description = new KeyValueCollection([
    'EN' => 'A new example group',
    'DE' => 'Eine neue Beispiel-Gruppe',
]);
$parentGroup = new IdType(0);
$sortOrder = new IntType(100);
$createdGroup = $adminAccessService->createNewGroup(
    $name,
    $description,
    $parentGroup,
    $sortOrder
);

# Add controller "ExampleController" to created group
$groupId = new IdType($createdGroup->getId());
$identifier = new NonEmptyStringType('Example');
$type = new NonEmptyStringType('CONTROLLER');
$adminAccessService->addItemToGroup($groupId, $identifier, $type);

# Add page "example.php" to created group
$groupId = new IdType($createdGroup->getId());
$identifier = new NonEmptyStringType('example.php');
$type = new NonEmptyStringType('PAGE');
$adminAccessService->addItemToGroup($groupId, $identifier, $type);

# Add ajax handler "ExampleAjaxHandler" to created group
$groupId = new IdType($createdGroup->getId());
$identifier = new NonEmptyStringType('Example');
$type = new NonEmptyStringType('AJAX_HANDLER');
$adminAccessService->addItemToGroup($groupId, $identifier, $type);
```

**Hinweis 1:** Die Variable `parentGroup` enthält die ID der übergeordneten Zugriffsgruppe. Standardmäßig sollte diese
`0` sein. Sollte eine übergeordnete Zugriffsgruppe größer 0 angegeben werden, dann gilt, dass ein Admin nur dann für
die erstellte Gruppe berechtigt ist, wenn er auch die Berechtigung für die übergeordnete Gruppe besitzt. Eine
Verschachtelung ist momentan nur bis zur zweiten Ebene möglich. Im Gambio Admin werden Untergruppen bei der Verwaltung
der Berechtigungen entsprechend eingerückt dargestellt.

**Hinweis 2:** Die verwendeten Ländercodes für die Namen und Beschreibung müssen **immer** großgeschrieben werden.


### <a name="Einer Rolle die Berechtigung für eine Gruppe gewähren"></a>Einer Rolle die Berechtigung für eine Gruppe gewähren
Es kann durchaus möglich sein, dass du, nachdem du eine Zugriffsgruppe für dein Modul angelegt hast, einer Rolle die
Berechtigung für diese Gruppe gewähren möchtest. Das folgende Beispiel zeigt dir, wie dies geht:

```php
$adminAccessService = StaticGXCoreLoader::getService('AdminAccess');

# Grant admin access role with id 1 reading permission for admin access group with id 2
$roleId = new IdType(1);
$groupId = new IdType(2);
$adminAccessService->grantReadingPermissionToRole($groupId, $roleId);
```