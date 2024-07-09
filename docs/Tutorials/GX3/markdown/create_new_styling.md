# Anlegen neuer Styling Inhalte

Derzeit gibt es im Shop zwei verschiedene Systeme im Frontend, einmal das neue Theme-System, dass es seit GX v3.13 gibt
und das davor verwendete Template-System. Generell empfehlen wir, das neue Theme-System zu verwenden, jedoch kann es
natürlich auch sinnvoll sein, dass alte Template-System zu unterstützen. Daher wird hier auf beides eingegangen. Neben
dem Frontend gibt es aber auch noch das Backend bzw. den Gambio Admin, dessen Styling ebenfalls angepasst werden kann.


## Theme System
Bei der Einbindung von SCSS-Dateien sind die gleichen Dinge wie für HTML, oder JavaScript Dateien zu beachten.
Wichtig ist hier, dass eine bestimmte Ordnerstruktur eingehalten werden muss.

Als Beispiel siehst du nachfolgend einen Ausschnitt aus der Ordnerstruktur eines exemplarischen Moduls.

```
- GXModules/
    - {Modulhersteller}/
        - {Modulname}/
            - Shop/ 
                - Themes/
                    - All/
                        - Css/
                    - Honeygrid/
                        - Css/
```

Du siehst, dass sich im `Shop`-Ordner des Moduls der Ordner `Themes` befindet. Es ist erkennbar, dass jedes Theme
(bzw. All für alle Themes) über den Unterordner `Css` verfügen kann. Dieser `Css` Ordner verhält sich analog
zu dem `styles` Ordner eines Themes im `themes` Ordners im Hauptverzeichnis des Shops.


### Eigenes Styling einbinden

Angenommen du möchtest eine (S)CSS Code hinzufügen, welcher für alle Themes gilt, dann muss zunächst einmal folgender
Ordner `GXModules/{Modulherstellername}/{Modulname}/Shop/Templates/All/Css/custom/` angelegt werden. Im Anschluss
kannst du in diesem Ordner alle deine SCSS Dateien ablegen. Damit diese dann nun aber auch eingebunden werden, muss du
zum Schluss noch eine `GXModules/{Modulherstellername}/{Modulname}/Shop/Templates/All/Css/custom/main.scss` Datei
anlegen, mit der du die bereits bestehende `main.scss` Datei in den jeweiligen Template-Sets erweiterst.

Den Inhalt deiner `main.scss` Datei kannst du mit Import Anweisungen ausstatten, wie folgendes Beispiel für eine
vorhandene `GXModules/{Modulherstellername}/{Modulname}/Shop/Templates/All/Css/custom/_my_styles.scss`:

```scss
@import "my_styles";
```

Alternative kannst du an stelle der Import Anweisungen auch direkt (S)CSS Code in deine eigene`main.scss` Datei
einbinden.

Möchtest du den Inhalt der bereits bestehenden `main.scss` Datei komplett überschreiben, so muss du den Pfad 
`GXModules/{Modulherstellername}/{Modulname}/Shop/Templates/All/Css/system/main.scss` verwenden. Warum dies so ist, wird in
dem Abschnitt zum [Theme-System](../theme-system.md) erklärt.


## Template System
Bei der Einbindung von SCSS-Dateien sind die gleichen Dinge wie für HTML, oder JavaScript Dateien zu beachten.
Wichtig ist hier, dass eine bestimmte Ordnerstruktur eingehalten werden muss.

Als Beispiel siehst du nachfolgend einen Ausschnitt aus der Ordnerstruktur eines exemplarischen Moduls.

```
- GXModules/
    - {Modulhersteller}/
        - {Modulname}/
            - Shop/ 
                - Templates/
                    - All/
                        - Css/
                    - Honeygrid/
                        - Css/
```

Du siehst, dass sich im `Shop`-Ordner des Moduls der Ordner `Templates` befindet. Es ist erkennbar, dass jedes 
Template-Set (bzw. All für alle Template-Sets) über den Unterordner `Css` verfügen kann. Dieser `Css` Ordner
verhält sich analog zu dem `styles` Ordner eines Template-Sets im `templates` Ordners im Hauptverzeichnis des Shops.


### Eigenes Styling einbinden

Angenommen du möchtest eine (S)CSS Code hinzufügen, welcher für alle Templatesets gilt, dann muss zunächst einmal
folgender Ordner `GXModules/{Modulherstellername}/{Modulname}/Shop/Templates/All/Css/` angelegt werden. Im Anschluss
kannst du in diesem Ordner alle deine SCSS Dateien ablegen. Damit diese dann nun aber auch eingebunden werden, muss du
zum Schluss noch eine `GXModules/{Modulherstellername}/{Modulname}/Shop/Templates/All/Css/main.scss` Datei anlegen,
mit der du die bereits bestehende `main.scss` Datei in den jeweiligen Template-Sets erweiterst.

Den Inhalt deiner `main.scss` Datei kannst du mit Import Anweisungen ausstatten, wie folgendes Beispiel für eine
vorhandene `GXModules/{Modulherstellername}/{Modulname}/Shop/Templates/All/Css/_my_styles.scss`:

```scss
@import "my_styles";
```

Alternative kannst du an stelle der Import Anweisungen auch direkt (S)CSS Code in deine eigene`main.scss` Datei
einbinden.


## Gambio Admin

Auch für die Einbindung von eigenem Styling im Gambio Admin ist die Ordnerstruktur zu beachten. Bei der Ordnerstruktur
und Benennung orentieren wir uns (ähnlich wie im Frontend) hier am Gambio Admin.

Als Beispiel siehst du nachfolgend einen Ausschnitt aus der Ordnerstruktur eines exemplarischen Moduls.

```
- GXModules/
    - {Modulhersteller}/
        - {Modulname}/
            - Admin/ 
                - Css/
```

Dieser `Css` Ordner verhält sich analog zu dem `admin/styles` Ordners im des Hauptverzeichnis des Shops.

Wenn du nun zum Beispiel die `admin/styles/admin.scss` Datei erweitern wollen würdest, dann musst du eine eigene
`GXModules/{Modulherstellername}/{Modulname}/Admin/Css/admin.scss` Datei anlegen.