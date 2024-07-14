# Ändern bestehender PHP Klassen

Es gibt zwei Möglichkeiten bestehende PHP Klassen im Shop System zu verändern. Bei der ersten Möglichkeit - dem
Class-Overloading - kannst du das Verhalten einer bestehenden Klasse mit eigener Logik überladen, wohingegen bei der
zweiten Möglichkeit - dem Extending - du dich in bestehende Programmlogiken einhaken und eigene Logiken ausführen kannst.


**Inhalt:**

* <a href="#Class-Overloading">Class-Overloading</a>
    * <a href="#Wie wird eine Klasse überladen?">Wie wird eine Klasse überladen?</a>
    * <a href="#Welche Klassen können überladen werden?">Welche Klassen können überladen werden?</a>
    * <a href="#Überladen von Klassen innerhalb eines Namespaces">Überladen von Klassen innerhalb eines Namespaces</a>
    * <a href="#Worauf sollte bei der Einrichtung geachtet werden?">Worauf sollte bei der Einrichtung geachtet werden?</a>
* <a href="#Extender-System">Extender-System</a>
    * <a href="#Die Wahl des richtigen Extenders">Die Wahl des richtigen Extenders</a>
    * <a href="#Seitenmanipulation durch Überladen des Extenders">Seitenmanipulation durch Überladen des Extenders</a>
        * <a href="#Unterverzeichnis und Overload-Klasse erstelle">Unterverzeichnis und Overload-Klasse erstelle</a>
        * <a href="#Overload-Klasse erstellen und eigene proceed-Methode implementieren ">Overload-Klasse erstellen und eigene `proceed`-Methode implementieren </a>
        * <a href="#Modul-Cache leeren">Modul-Cache leeren</a>
        * <a href="#Weitere Beispiele">Weitere Beispiele</a>


## <a name="Class-Overloading"></a>Class-Overloading

Class-Overloading erhöht die Update-Sicherheit von Änderungen am Code. Class-Overloading ermöglicht, das Verhalten von 
PHP-Klassen zu verändern, ohne die Datei dieser Klasse zu verändern. Da die Änderungen also nicht im Original 
durchgeführt werden, gehen diese, wenn Original-Dateien gegen aktualisierte ausgetauscht werden, nicht verloren.

Veränderungen durch Class-Overloading können z.B. Erweiterungen von bestehenden Methoden, Hinzufügen neuer Methoden, 
Ersetzen von Methoden (oder sogar der gesamten Klasse) sein. Somit stehen alle Möglichkeiten zur Verfügung, das 
Verhalten der Klasse den eigenen Wünschen anzupassen.
  
  
### <a name="Wie wird eine Klasse überladen?"></a>Wie wird eine Klasse überladen?

Für das Überladen einer Klasse wird eine neue Klasse benötigt. Dazu wird im Verzeichnis
`GXModules/{Modulherstellername}/{Modulname}/Admin/Overloads` oder
`GXModules/{Modulherstellername}/{Modulname}/Shop/Overloads` ein Unterverzeichnis mit dem Namen der zur überladenen
Klasse erstellt (z. B. `breadcrumb`). In dieses neu erstellte Verzeichnis wird eine PHP-Datei angelegt, die einen
neuen eindeutigen Klassennamen trägt, also zum Beispiel `CustomizedBreadcrumb.inc.php`. Die Namenskonvention lautet
demnach: `{BeliebigerKlassenname}.inc.php`

Das folgende Beispiel zeigt einen Overload `CustomizedBreadcrumb`, welcher die `trail`-Methode der `breadcrumb` Klasse
erweitert, sodass die Einträge im Breadcrumb von eckigen Klammern umschlossen werden und der Separator eine Pipe ist,
sofern der gegebene Separator nicht vom Standard abweicht. Hierfür wird eine Datei
`GXModules/{Modulherstellername}/{Modulname}/Shop/Overloads/breadcrumb/CustomizedBreadcrumb.inc.php` mit folgendem
Inhalt angelegt:
  
```php
class CustomizedBreadcrumb extends CustomizedBreadcrumb_parent
{
	/**
	 * Returns a modified breadcrumb as a string. The items are in brackets. 
	 *
	 * They are separated by a pipe if the standard separator is a dash. Otherwise 
	 * the given separator is used.
	 * 
	 * @param string $separator Optional, the breadcrump separator string.
	 * 
	 * @return string Returns the modified breadcrump string. 
	 */
	public function trail($separator = ' - ')
	{
		foreach($this->_trail as &$item)
		{
			$item['title'] = '[' . $item['title'] . ']';
		}
		
		if($separator === ' - ')
		{
			$separator = ' | '; // Replace the original separator.
		}
		
		return parent::trail($separator);
	}
}
```

In dem obigen Beispiel kannst du sehen, dass die `CustomizedBreadcrumb` Klassen von `CustomizedBreadcrumb_parent` erbt,
was für das Overloading System sehr wichtig ist. Die Elternklasse hat also die Namenskonvention
`{BeliebigerKlassenname}_parent`. Die MainFactory des Shops übernimmt die Vererbung von der zu überladenen Klasse
automatisch anhand des Ordnernamens `breadcrumb`, in dem sich die Overload-Klasse befindet. Mehrfaches Überladen 
derselben Klasse durch verschiedene Overload-Dateien ist ebenfalls möglich. Dazu liegen einfach alle Overload-Dateien
im selben Verzeichnis. Technisch entspricht dies einer Vererbungskette. Die Klassen erben also alle voneinander und
zwar in der Reihenfolge, wie sie im Dateisystem vorliegen.


### <a name="Welche Klassen können überladen werden?"></a>Welche Klassen können überladen werden?

Es können alle Klassen überladen werden, die durch die MainFactory erzeugt werden. Dies deckt nahezu alle Klassen ab.
Die überladbaren Klassen liegen in folgenden Verzeichnissen inklusive ihrer Unterverzeichnisse:

* admin/includes/classes
* admin/includes/gm/classes
* gm/classes
* GXEngine
* GXMainComponents
* includes/classes (außer includes/classes/scssphp)
* includes/modules/order_total
* includes/modules/payment
* includes/modules/shipping
* system/classes
* system/core
* system/extender
* system/overloads
  
Ausgenommen sind Klassen, die nur zur Typ-Validierung (TypeHints) genutzt werden und daher nicht über die MainFactory 
erzeugt werden. Diese Klassen liegen im Verzeichnis `GXEngine/Shared/Types`.

Besonders erwähnenswert sind die [Extender](list_of_all_extender.md), die durch Class-Overloading genutzt werden können.

Standardmäßig werden Beispiel-Overloads ausgeliefert, die die Funktionalität veranschaulichen. Diese sind im
Verzeichnis `GXMainComponents/overloads/_samples` zu finden. Sie können aktiviert werden, indem der jeweilige Ordner 
eine Ebene nach oben verschoben wird.


### <a name="Überladen von Klassen innerhalb eines Namespaces"></a>Überladen von Klassen innerhalb eines Namespaces

Soll eine Klasse innerhalb eines Namespaces überladen werden, so muss der Namespace in der Ordnerstruktur für den
Overload mit abgebildet werden. Soll zum Beispiel die Klasse `Customer` im Namespace
`Gambio\GX\Domains\Order\ValueObjects` überladen werden und der neue Overload-Klassenname `OverloadedCustomer` heißen,
dann muss der Overload wie folgt abgelegt werden:

`GXModules/{Modulherstellername}/{Modulname}/Shop/Overloads/Gambio/GX/Domains/Order/ValueObjects/OverloadCustomer.inc.php`


### <a name="Worauf sollte bei der Einrichtung geachtet werden?"></a>Worauf sollte bei der Einrichtung geachtet werden?

* Es gibt wenige Klassen, die doppelt vorkommen, wie z. B. die `order`, die sowohl im Verzeichnis `includes/classes` als 
  auch in `admin/includes/classes` zu finden ist. Damit die MainFactory weiß, welche Klasse überladen werden soll, gibt 
  man im Fall, dass die Klasse aus dem `admin/includes/classes`-Verzeichnis gemeint ist, als Ordnernamen `Admin-order` 
  statt `order` an. Dieses `Admin-`-Präfix funktioniert **ausschließlich** für folgende doppelt vorkommende Klassen:
    * `language`
    * `messageStack`
    * `order`
    * `shoppingCart`
    * `splitPageResults`

* Da ein und dieselbe Klasse mehrfach überladen werden kann, ist darauf zu achten, dass Vererbungsketten nicht 
  unterbrochen werden. Es sollte also sichergestellt werden, dass beim Erweitern einer Methode auch die parent-Methode 
  aufgerufen wird.

* Nach Anlegen eines Overloads muss der Cache für **Modulinformationen** im Admin unter dem 
  **Menüpunkt Toolbox > Cache** geleert werden. Erst dann wird ein neuer Overload wirksam.

* Änderungen von Original-Klassen, die z.B. durch Shop-Updates hervorgerufen werden, können u.U. die Funktionalität 
  eines Overloads beeinflussen. Das Verhalten kann nicht mehr erwartungsgemäß sein oder es können Fehler auftreten,
  falls z.B. Methoden oder ganze Klassen nicht mehr existieren. Bei Änderungen von Original-Klassen ist also stets zu 
  überprüfen, ob die Overloads weiterhin funktionieren.

* Der Klassenname des Overloads muss systemweit eindeutig gewählt werden. Andernfalls kann die MainFactory den 
  Overload nicht instanziieren, da Klassennamen eindeutig sein müssen. Namespaces werden berücksichtigt. Gleiche 
  Klassennamen in unterschiedlichen Namespaces werden unterschieden und sind somit erlaubt.

* Der Klassenname muss mit dem Dateinamen übereinstimmen.

* Im Overload muss derselbe Namespace angegeben werden, wie in der zu überladenen Klasse.


## <a name="Extender-System"></a>Extender-System


Das Extender-System ist ein Hook-Point-System und dient der komfortablen und update-sicheren Anpassung und Erweiterung
des Shopsystems. Es ermöglicht Modulentwicklern, Inhalte oder Verhaltensweisen an vordefinierten Stellen zu injizieren.
Wenn beispielsweise zusätzliche Informationen zu einer Bestellung in der Bestelldetailansicht angezeigt werden sollen,
kann dies mithilfe eines Overloads des OrderExtenders erreicht werden. Durch einen Extender können nicht nur Inhalte an
bestimmten Stellen ausgegeben werden, sondern auch Funktionen an bestimmten Stellen im Code ausgeführt werden. Wenn man
z.B. die Produktbearbeitung durch einen anderen Extender um ein weiteres Eingabefeld erweitert hat, möchte man, dass
der Inhalt des Feldes auch jedes Mal gespeichert wird. Dies erreicht man durch einen Overload des
AdminCategoriesExtenders.

Im folgenden wird dies erklärt und anhand ein Beispiel veranschaulicht, wie du das Extender-System verwendest. Das
Beispiel zeigt Schritt für Schritt, wie du die Bestätigungsseite, die nach einer erfolgreichen Bestellung angezeigt
wird, um ein paar Bestelldetails erweiterst.


### <a name="Die Wahl des richtigen Extenders"></a>Die Wahl des richtigen Extenders

Mit Hilfe von Extendern kannst du die häufigsten Fälle abdecken, bei denen du eine individuelle Erweiterung benötigst.
Welche Extender aktuell existieren, entnimmst du dieser [Liste](list_of_all_extender.md).

Für unser Beispiel existiert bereits ein passender Extender: `CheckoutSuccessExtenderComponent`. Mit diesem Extender
kann nach einer erfolgreichen Bestellung Quellcode ausgeführt und eigener HTML-Code auf der Bestätigungsseite angezeigt
werden.


### <a name="Seitenmanipulation durch Überladen des Extenders"></a>Seitenmanipulation durch Überladen des Extenders

Extender bieten eine formale Schnittstelle, um Inhalte und Verhaltensweisen mittels Overload gezielt einzubetten, dazu
haben viele Extender bestimmte Vorgaben, in welcher Form sie Inhalte erwarten.

Um nun eigene Inhalte auf der Bestellbestätigungsseite anzeigen zu lassen, führe die folgenden Schritte aus:


#### <a name="Unterverzeichnis und Overload-Klasse erstelle"></a>Unterverzeichnis und Overload-Klasse erstelle

Zunächst einmal muss ein Verzeichnis mit dem gleichen Namen wie die Extender-Klasse in deinem Overloads Verzeichnis
erstellt werden. In diesem Beispiel wäre das:

`GXModules/{Modulherstellername}/{Modulname}/Shop/Overloads/CheckoutSuccessExtenderComponent`

Anschließend kann die Datei `MyOrderDetails.inc.php` in diesem Ordner angelegt werden.


#### <a name="Overload-Klasse erstellen und eigene proceed-Methode implementieren "></a>Overload-Klasse erstellen und eigene `proceed`-Methode implementieren 

Wichtig ist hier wieder, dass der Klassenname dem Namen der Datei entspricht. Der Name für jede Overload-Elternklasse
wird aus dem Klassennamen des Overloads und dem Suffix `_parent` gebildet.

```php
class MyOrderDetails extends MyOrderDetails_parent {
}
```

Die `proceed()`-Methode wird von jedem Extender genutzt. Diese Methode ist der Kern und sollte die gesamte Logik des
Overloads ausführen. Ganz wichtig bei der Verwendung von Extendern ist, dass du in der `proceed()`-Methode die
`proceed()`-Methode der Elternklasse mittels `parent::proceed()` aufrufen musst. Dies ist deshalb wichtig, da das
Overload-System sonst nicht korrekt funktioniert und stellt auch eine häufige Fehlerquelle dar.

In diesem Extender lässt sich die ID der abgeschlossenen Bestellung aus der Variablen
`$this->v_data_array['orders_id']` entnehmen. Um jedoch später auf die Daten der Bestellung zuzugreifen, muss zunächst
mit `new IdType($this->v_data_array['orders_id'])` ein Objekt vom Typ `IdType` instanziiert werden. Dies hat den Grund,
dass der zum Abruf der Bestelldaten verwendete `OrderReadService` ein Objekt dieser Klasse erwartet.

Die `proceed()`-Methode sollte bei dir zunächst einmal so aussehen:
```php
public function proceed()
{
    parent::proceed();
    
    $orderId = new IdType($this->v_data_array['orders_id']);
}
```

Um nun HTML-Code anzeigen zu lassen, kann auf zwei verschiedene Möglichkeiten zurückgegriffen werden.

1. Die erste Möglichkeit erlaubt das Hinzufügen von Inhalten an einer beliebigen Position.
   Hierzu muss dem `checkout_success`-Template eine Smarty-Variable (z. B. `{$myOrderDetails}`) hinzugefügt werden.
   Anschließend kann mit `$this->v_output_buffer['<variable_name>'] = '<html_code>';` die hinzugefügte Smarty-Variable
   mit Inhalt gefüllt werden.
   
2. Die zweite Möglichkeit ist das Hinzufügen von HTML-Code an einer festen Position. Mit
   `$this->v_output_buffer[] = '<html_code>';` wird der HTML-Code direkt unterhalb der eigentlichen
   Bestätigungsnachricht hinzugefügt.

Für dieses Beispiel verwenden wir einfachheitshalber die zweite Möglichkeit und nutzen eine Hilfsmethode
`createOrderDetails(IdType $orderId)` zur Erzeugung des hinzuzufügenden HTML-Codes. Das Hinzufügen der Bestelldetails
sollte dann bei dir so aussehen:

`$this->html_output_array[] = $this->createOrderDetails($orderId);`

Im unten stehenden Code-Beispiel siehst du die gesamte `MyOrderDetails` Klasse. Innerhalb von `createOrderDetails(...)`
wird der `OrderReadService` verwendet, um die Bestellinformationen aus der Datenbank auszulesen und anschließend, den
HTML-Code der gewünschten Bestelldetails zu generieren und zurückzugegeben.

```php
class MyOrderDetails extends MyOrderDetails_parent {
    public function proceed()
    {
        parent::proceed();
        
        $orderId = new IdType($this->v_data_array['orders_id']);
        $this->html_output_array[] = $this->createOrderDetails($orderId);
    }
    
    private function createOrderDetails(IdType $orderId)
    {
        $orderReadService = StaticGXCoreLoader::getService('OrderRead');
        $order = $orderReadService->getOrderById($orderId);
        
        $customerAddressBlock = $order->getCustomerAddress();
        $billingAddressBlock = $order->getBillingAddress();
        $deliveryAddressBlock = $order->getDeliveryAddress();
        
        $html = '<h2>Bestelldetails (#' . $order->getOrderId() . ')</h2>'
                . '<div class="row">'
                    . '<div class="col-sm-4"><b>Kundenadresse:</b><br /> '
                        . $customerAddressBlock->getFirstname() . ' '
                        . $customerAddressBlock->getLastname() . '<br />'
                        . $customerAddressBlock->getStreet() . ' '
                        . $customerAddressBlock->getHouseNumber() . '<br />'
                        . $customerAddressBlock->getPostcode() . ' '
                        . $customerAddressBlock->getCity() . '<br />'
                    . '</div>'
                    . '<div class="col-sm-4"><b>Rechnungsadresse:</b><br /> '
                        . $billingAddressBlock->getFirstname() . ' '
                        . $billingAddressBlock->getLastname() . '<br />'
                        . $billingAddressBlock->getStreet() . ' '
                        . $billingAddressBlock->getHouseNumber() . '<br />'
                        . $billingAddressBlock->getPostcode() . ' '
                        . $billingAddressBlock->getCity() . '<br />'
                    . '</div>'
                    . '<div class="col-sm-4"><b>Lieferadresse:</b><br /> '
                        . $deliveryAddressBlock->getFirstname() . ' '
                        . $deliveryAddressBlock->getLastname() . '<br />'
                        . $deliveryAddressBlock->getStreet() . ' '
                        . $deliveryAddressBlock->getHouseNumber() . '<br />'
                        . $deliveryAddressBlock->getPostcode() . ' '
                        . $deliveryAddressBlock->getCity() . '<br />'
                    . '</div>'
                . '</div>';
        
        return $html;
    }
}
```

Der komplette Overload kann [hier](../samples/extender/MyOrderDetails.php) nochmal aufgerufen werden.


#### <a name="Modul-Cache leeren"></a>Modul-Cache leeren

Um den neuen Overload der Class Registry bekannt zu machen, leere zuletzt den *Cache für Modulinformationen* im
Gambio Admin unter *Toolbox* > *Cache*. In seltenen Fällen musst du anschließend noch den Cache für die Seitenausgabe
leeren, da template-basierte Seiteninhalte im Cache zwischengespeichert werden.

Als Ergebnis dieses Beispiels sollte die Bestätigungsseite nach einer erfolgreichen Bestellung ungefähr so aussehen:
![Weitere Details unter der Bestellbestätigung](../images/extenders/extender-example.png "Weitere Details unter der Bestellbestätigung")

Bislang gibt es keine einheitliche Form in der die Extender Inhalte entgegennehmen. Das Format musst du für jeden
Extender einzeln der [Liste aller Extender](list_of_all_extender.md) entnehmen.


#### <a name="Weitere Beispiele"></a>Weitere Beispiele

* [ApplicationBottomExtender](../samples/extender/SampleApplicationBottomExtender.php)
* [CheckoutSuccessExtender](../samples/extender/SampleCheckoutSuccessExtender.php)
* [OrderExtender](../samples/extender/SampleOrderExtender.php)
* Weitere Beispiele findest du [hier](../samples/overloads/_samples)