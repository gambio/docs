# Unit Tests #

## Grundsätzliche Regeln ##

* Test-Cases erben mindestens von *GxTestCase* (Ausnahme: StyleEdit3)
* Die Unit Tests müssen auch nach mehrmaligem Ausführen immer das gleiche Ergebnis liefern.
* Der Zustand von Dateisystem und Datenbank muss nach Ausführen der Tests automatisiert wiederhergestellt werden.
* Das allgemeine Format für Test-Methoden lautet: test\[*MethodName*\]Method\[*Action*\]\[*ObjectAffected*\]\[From/In/ToSomewhere\]  
Database wird mit Db abgekürzt, also z. B. testDeleteByIdMethodRemovesRecordFromDb()
* Pro Test-Case wird immer nur eine Klasse getestet.
* Nur die zu testende Klasse darf mit *new* instanziiert werden (Ausnahme: Type-Objekte, die nicht übergeben werden).
* Alle anderen Objekte werden gemockt.
* Es wird eine Mock-Factory verwendet (siehe unten).
* Pro Test-Methode wird immer nur eine Behauptung (Assertion) geprüft.
* Es wird nur der Code getestet, der auch in der zu testenden Klasse implementiert bzw. überladen wurde.
* Abstrakte Klassen werden PHPUnit_Framework_TestCase::getMockForAbstractClass() getestet.

## Testen von Value-Objects ##

TODO

## Testen von Entities ##

TODO

## Testen von Repositories (Delegation an Reader, Writer und Deleter) ##

TODO

## Testen von Datenbankoperationen (Reader, Writer und Deleter) ##

TODO

## Testen von Dateisystemoperationen (Storage-Klassen) ##

TODO

## Test-Cases ##

* GxTestCase  
Standard-Elternklasse für Test-Cases
* GxDatabaseTestCase
Standard-Elternklasse für datenbankbasierte Test-Cases
* GxFilesystemTestCase  
Standard-Elternklasse für dateisystembasierte Test-Cases

## Mock-Factories ##

* MockFactory
* SharedMockFactory
* TypesMockFactory
* VendorMockFactory
* Domänen-spezifische Mock Factories:
  * CustomerMockFactory
  * EmailMockFactory
  * HttpMockFactory
  * OrderMockFactory
  * SliderMockFactory

## Traits ##

* AbstractCollectionTestTrait
* AccessorTestTrait  
Get- und Setmethoden von Entities testen (stellt Konventionen sicher)
* AddonValueTestTrait
* CollectionTestInitTrait
* CompatibilityTrait  
Kompatibilität für PHP5 und PHP7
* InvalidArgumentTypeErrorTrait  
Workaround für Fehler in PHP-Unit Konfiguration