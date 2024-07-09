# Verwendung des Auth-Services

In diesem Tutorial wird beschrieben, wie du mit Hilfe des Auth-Services (ab GX3.3) Login-Daten oder ein Passwort 
authentfizieren, sowie Passwort-Hashes erzeugen und aktualisieren kannst.
Der Auth-Service berücksichtigt die Konfiguration zur Passwort-Verschlüsselung im Gambio Admin. Du kannst unter dem 
Menüpunkt `Shop Einstellungen` > `System Einstellungen` > `Sicherheitscenter` die Art der Verschlüsselung auf `MD5` 
oder `password_hash` setzen. Außerdem hast du dort die Möglichkeit des Rehashings, was bedeutet, dass bei einem
Login ein gültiger Passwort-Hash, der nicht mehr zur aktuellen Verschlüsselungsmethode passt, als valide erkannt wird 
und automatisch gegen einen neuen Hash ersetzt wird. Das Schreiben des aktualisierten Hashes ist nicht Teil des 
Auth-Services.


## Login mit E-Mail-Adresse und Passwort

Die Methode `AuthService::authUser()` übernimmt im Shop die Validerung von Login-Daten bestehend aus E-Mail-Adresse und 
Passwort. So funktioniert es:

```php
$email    = 'user@example.org';
$password = '12345';

/** @var AuthService $authService */
$authService = StaticGXCoreLoader::getService('Auth');
$credentials = MainFactory::create('UsernamePasswordCredentials',
								   new NonEmptyStringType($email),
								   new StringType($password));

if($authService->authUser($credentials))
{
	// login data valid
}
else
{
	// login data invalid
}
```


## Passwort-Hash-Validierung

Du kannst die Methode `AuthService::validate()` dazu nutzen ein Passwort zusammen mit einem Hash zu validieren.

```php
$password = '12345';
$hash     = '$2y$10$af5bomFsjmD4PqsQxJ0MN.7Pgm1GVcdjXjvXglp0i4akp3p5feRtS';

/** @var AuthService $authService */
$authService = StaticGXCoreLoader::getService('Auth');

if($authService->verify(new StringType($password), new NonEmptyStringType($hash)))
{
	// password matches hash
}
else
{
	// password does not match the hash
}
```

Kürzer ist es, wenn du die Funktion `xtc_validate_password()` nutzt, die intern dasselbe tut.

```php
$password = '12345';
$hash     = '$2y$10$af5bomFsjmD4PqsQxJ0MN.7Pgm1GVcdjXjvXglp0i4akp3p5feRtS';

if(xtc_validate_password($password, $hash))
{
	// password mathes hash
}
else
{
	// password does not match the hash
}
```


## Passwort-Hash erzeugen

Du erzeugst mit `AuthService::getHash()` einen Hash eines Passworts mit dem im Gambio Admin festgelegten 
Verschlüsselungsverfahren.

```php
/** @var AuthService $authService */
$authService = StaticGXCoreLoader::getService('Auth');
$password    = '12345';

// returns something like this: $2y$10$af5bomFsjmD4PqsQxJ0MN.7Pgm1GVcdjXjvXglp0i4akp3p5feRtS
$hash = $authService::getHash(new StringType($password));
```

Auch hier gibt wieder die kurze Variante mit der Funktion `xtc_encrypt_password`.

```php
$password = '12345';

// returns something like this: $2y$10$af5bomFsjmD4PqsQxJ0MN.7Pgm1GVcdjXjvXglp0i4akp3p5feRtS
$hash = xtc_encrypt_password($password);
```


## Passwort-Rehashing

Mithilfe von `AuthService::getRehashedPassword()` kannst du einen aktualisierten Hash eines Passworts erzeugen. Hast du 
z. B. einen MD5-Hash zu einem Passwort und im Shop ist als Standard-Verschlüsselung `password_hash` eingestellt und das 
erneute Verschlüsseln ist aktiviert, so wird dir die Methode einen mit password_hash verschlüsselten Hash zurückliefern.
Ist der übergebene Hash bereits aktuell, wird dieser unverändert zurückgeliefert. Ist der übergebene Hash nicht valide, 
passt also nicht Passwort, so wird dieser ebenfalls unverändert zurückgegeben.

```php
/** @var AuthService $authService */
$authService = StaticGXCoreLoader::getService('Auth');
$password    = '12345';
$oldMd5Hash  = '827ccb0eea8a706c4c34a16891f84e7b';

// returns something like this: $2y$10$af5bomFsjmD4PqsQxJ0MN.7Pgm1GVcdjXjvXglp0i4akp3p5feRtS
$hash = $authService::getRehashedPassword(new StringType($password), new NonEmptyStringType($oldMd5Hash));
```

So ein aktualisierter Hash kann dann z. B. über den Customer-Service für ein Kundenkonto geschrieben werden.