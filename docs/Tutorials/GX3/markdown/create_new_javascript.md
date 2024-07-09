# Anlegen neuer JavaScript Inhalte

Derzeit gibt es im Shop zwei verschiedene Systeme im Frontend, einmal das neue Theme-System, dass es seit GX v3.13 gibt
und das davor verwendete Template-System. Generell empfehlen wir, das neue Theme-System zu verwenden, jedoch kann es
natürlich auch sinnvoll sein, dass alte Template-System zu unterstützen. Daher wird hier auf beides eingegangen. Neben
dem Frontend gibt es aber auch noch das Backend bzw. den Gambio Admin, dessen JavaScript ebenfalls erweitert werden
kann.


## Theme System
Bei der Einbindung von neuen JavaScript- und (S)CSS-Dateien sind die gleichen Dinge wie für HTML Dateien zu beachten.
Wichtig ist auch hier, dass eine bestimmte Ordnerstruktur eingehalten werden muss.

Als Beispiel siehst du nachfolgend einen Ausschnitt aus der Ordnerstruktur eines exemplarischen Moduls.

```
- GXModules/
    - {Modulhersteller}/
        - {Modulname}/
            - Shop/ 
                - Themes/
                    - All/
                        - Javascript/
                    - Honeygrid/
                        - Javascript/
```

Du siehst, dass sich im `Shop`-Ordner des Moduls der Ordner `Themes` befindet. Es ist erkennbar, dass jedes
Theme (bzw. `All` für alle Themes) über die einen `Javascript` Ordner verfügen kann. Dieser `Javascript` 
Ordner verhält sich analog zu dem `javascript` Ordner eines Themes im `themes` Ordners im Hauptverzeichnis des Shops.


### Eigenes JavaScript einbinden

Die Einbindung von JavaScript wird im Shop über vorgegebene Sektionen gesteuert. Über Unterordner des in dem
Theme befindlichem `Javascript/custom` Ordner kannst du die Sektion angegeben, in der dein JavaScript ausgeführt
werden soll. Hier eine Auflistung aller möglichen Sektionen zur Einbindung von JavaScript-Dateien: *Account*,
*AccountHistory*, *CallbackService*, *Cart*, *Cat*, *Checkout*, *GVSend*, *Index*, *Manufactures*, *PriceOffer*,
*ProductInfo* und *Wishlist*.

Für ein exemplarisches Modul und dem Honeygrid Theme würde dies also folgende Ordnerstruktur ergeben:

```
- GXModules/
    - {Modulhersteller}/
        - {Modulname}/
            - Shop/ 
                - Themes/
                    - Honeygrid/
                        - Javascript/
                            - Account/
                            - AccountHistory/
                            - CallbackService/
                            - Cart/
                            - Cat/
                            - Checkout/
                            - Global/
                            - GVSend/
                            - Index/
                            - Manufactures/
                            - PriceOffer/
                            - ProductInfo/
                            - Wishlist/
```

Angenommen du möchtest eine Alert-Meldung für Honeygrid global auf jeder Seite des Shops einbinden lassen, dann muss
du lediglich im `GXModules/{Modulherstellername}/{Modulname}/Shop/Themes/Honeygrid/Javascript/Global/` Ordner
eine neue JavaScript Datei (z.B. `my_alert.js`) anlegen und kannst diese mit dem entsprechenden JavaScript Code
befüllen.

Möchtest du eine bestehende JavaScript Datei eines Themes komplett ersetzen, dann musst du zum Beispiel eine
`GXModules/{Modulherstellername}/{Modulname}/Shop/Themes/Honeygrid/Javascript/system/widgets/anchor.js` Datei erstellen
um die `themes/Honeygrid/javascripts/system/widgets/anchor.js` zu ersetzen.


## Template-System
Bei der Einbindung von neuen JavaScript- und (S)CSS-Dateien sind die gleichen Dinge wie für HTML Dateien zu beachten.
Wichtig ist auch hier, dass eine bestimmte Ordnerstruktur eingehalten werden muss.

Als Beispiel siehst du nachfolgend einen Ausschnitt aus der Ordnerstruktur eines exemplarischen Moduls.

```
- GXModules/
    - {Modulhersteller}/
        - {Modulname}/
            - Shop/ 
                - Templates/
                    - All/
                        - Javascript/
                        - Styles/
                    - EyeCandy/
                        - Javascript/
                        - Styles/
                    - Honeygrid/
                        - Javascript/
                        - Styles/
```

Du siehst, dass sich im `Shop`-Ordner des Moduls der Ordner `Templates` befindet. Es ist erkennbar, dass jedes 
Template-Set (bzw. All für alle Template-Sets) über die Unterordner `Javascript` und `Styles` verfügen kann.


### Eigenes JavaScript einbinden

Angenommen du möchtest eine (S)CSS Code hinzufügen, welcher für alle Templatesets gilt, dann muss zunächst einmal
folgender Ordner `GXModules/{Modulherstellername}/{Modulname}/Shop/Templates/All/Styles/` angelegt werden. Im Anschluss
kannst du in diesem Ordner alle deine SCSS Dateien ablegen. Damit diese dann nun aber auch eingebunden werden, muss du
zum Schluss noch eine `GXModules/{Modulherstellername}/{Modulname}/Shop/Templates/All/Styles/main.scss` Datei anlegen,
mit der die bereits bestehende `main.scss` Datei in den jeweiligen Template-Sets erweiters.

Den Inhalt deiner `main.scss` Datei kannst du mit Import Anweisungen ausstatten, wie folgendes Beispiel für eine
vorhandene `GXModules/{Modulherstellername}/{Modulname}/Shop/Templates/All/Styles/_my_styles.scss`:

```scss
@import "my_styles";
```

Alternative kannst du an stelle der Import Anweisungen auch direkt (S)CSS Code in deine eigene`main.scss` Datei
einbinden.


### Eigenes JavaScript einbinden

Die Einbindung von JavaScript wird im Shop über vorgegebene Sektionen gesteuert. Über Unterordner des in dem
Templateset befindlichem `Javascript`-Ordner kannst du die Sektion angegeben, in der dein JavaScript ausgeführt werden
soll. Hier eine Auflistung aller möglichen Sektionen zur Einbindung von JavaScript-Dateien: *Account*,
*AccountHistory*, *CallbackService*, *Cart*, *Cat*, *Checkout*, *GVSend*, *Index*, *Manufactures*, *PriceOffer*,
*ProductInfo* und *Wishlist*.

Für ein exemplarisches Modul und dem Honeygrid Templateset würde dies also folgende Ordnerstruktur ergeben:

```
- GXModules/
    - {Modulhersteller}/
        - {Modulname}/
            - Shop/ 
                - Templates/
                    - Honeygrid/
                        - Javascript/
                            - Account/
                            - AccountHistory/
                            - CallbackService/
                            - Cart/
                            - Cat/
                            - Checkout/
                            - GVSend/
                            - Index/
                            - Manufactures/
                            - PriceOffer/
                            - ProductInfo/
                            - Wishlist/
```

Angenommen du möchtest eine Alert-Meldung für Honeygrid global auf jeder Seite des Shops einbinden lassen, dann muss
du lediglich im `GXModules/{Modulherstellername}/{Modulname}/Shop/Templates/Honeygrid/Javascript/Global/` Ordner eine neue
JavaScript Datei (z.B. `my_alert.js`) anlegen und kannst diese mit dem entsprechenden JavaScript Code befüllen.


## Gambio Admin

Auch für die Einbindung von eigenem JavaScript im Gambio Admin ist die Ordnerstruktur zu beachten. Bei der
Ordnerstruktur und Benennung orentieren wir uns (ähnlich wie im Frontend) hier am Gambio Admin.

Als Beispiel siehst du nachfolgend einen Ausschnitt aus der Ordnerstruktur eines exemplarischen Moduls.

```
- GXModules/
    - {Modulhersteller}/
        - {Modulname}/
            - Admin/ 
                - Javascript/
```

Wir empfehlen dir folgende Strukturierung innerhalb des `Javascript`-Ordners:

* `GXModules/{Modulherstellername}/{Modulname}/Admin/Javascript/controllers/` für deine JavaScript Controller
* `GXModules/{Modulherstellername}/{Modulname}/Admin/Javascript/extenders/` für deine JavaScript Extender
* `GXModules/{Modulherstellername}/{Modulname}/Admin/Javascript/vendor/` für JavaScript Dateien aus dritter Hand 
* `GXModules/{Modulherstellername}/{Modulname}/Admin/Javascript/widgets/` für deine JavaScript Widgets

Das Überschreiben oder Erweitern bestehender JavaScript Dateien im Gambio Admin ist nicht möglich!