# Basisstruktur für neue Module

Dieser Abschnitt beschäftigt sich mit der Ordnerstruktur, die für deine Module angedacht ist. Grundlage hierfür
ist das seit Version 3.5.1.0 bekannte **GXModules-System**, welches die Strukturierung und Bündelung von Modul-Dateien
an einem Ort vereinfacht hat. Dies hat für dich den großen Vorteil, dass die Dateien eines Moduls von den
restlichen Dateien des Shops und anderer Modulen örtlich getrennt sind.

Wir empfehlen daher bei der Entwicklung von Modulen dieses System zu verwenden und gehen bei allen folgenden
Tutorials auch davon aus. Im folgenden wird daher von einem generellen GXModules-Modul gesprochen, gemeint ist dabei
aber immer das Modul, welches du entwickelst bzw. entwickeln möchtest.


## Das GXModules-System

Mit dem GXModules-System ist es erstmals möglich so gut wie alle Dateien eines Moduls an einem eigenen Ort zu bündeln.

Module konntest du zwar bereits vorher durch bereits existierende Systeme und ohne Veränderung von Original-Dateien
erstellen, allerdings mussten dafür die Dateien an verschiedenen Orten platziert werden. Dies führt dazu, dass nur
schwer zu erkennen ist, welche Dateien zu welchem Modul gehören.

Um hier mehr Übersichtlichkeit zu schaffen und die Entwicklung von Modulen zu erleichtern, wurde das
**GXModules-System** eingeführt. Grundlage dieses Systems sind verschiedene Änderungen, die eine automatische Erkennung
und Einbindung bestimmter Arten von Dateien (wie z.B. Templates, Sprachdateien etc.) in das Shopsystem.


## Wo werden GXModules-Module im Dateisystem abgelegt?

Bei der Entwicklung und Verwendung dieses Systems müssen einige Besonderheiten in der Benennung und Ablage von Dateien
beachtet werden.

Wesendlich für dieses System ist der Ordner `GXModules` im Hauptverzeichnis des Shops, in dem die Module inklusive
ihrer Dateien abgelegt werden. Generell wird davon ausgegangen, dass jedes Modul über einen Hersteller und einen
Modulnamen verfügt. Aufgrund dieser Informationen sind die Dateien eines Modul unter folgender Ordnerstruktur abzulegen:

```
- GXModules/
    - {Modulherstellername}/
        - {Modulname}/
            - …
        - …
```

Dies hat den Sinn, dass Module eines Entwicklers zwar an einer Stelle gebündelten aufzufinden sind, jedoch die Dateien
der einzelnen Module immer noch von den anderen Modulen getrennt sind.

**Beispiel 1:** Angenommen du suchst die Dateien für unsere (Gambio) Module, dann findest du diese im Verzeichnis
                `GXModules/Gambio/`.
                
**Beispiel 2:** Angenommen du suchst die Dateien für das *Gambio Hub* Modul, dann findest du diese im Verzeichnis
                `GXModules/Gambio/Hub/`.
                
                
## Trennung von Dateien für Frontend- und Backend bzw. Shop- und Adminbereich

Generell sollten Dateien für das Frontend- und Backend bzw. Shop- und Adminbereich getrennt werden. Eine solche
Trennung würde also in der Ordnerstruktur wie folgt aussehen:

```
- GXModules/
    - {Modulherstellername}/
        - {Modulname}/
            - Admin/ 
            - Shop/ 
```

Diese Art der Aufteilung hat den Vorteil, dass für dich und andere eine inhaltliche und logische Trennung von Dateien
für den Shop- bzw. Adminbereich klar erkennbar ist.

**Hinweis 1:** Neben den zwei Unterordnern `Admin` und `Shop` befindet sich eigentlich auch noch die `index.html` in
               diesem Ordner. Diese hat jedoch nur den Verwendungszweck, dass bei einem direkten Aufruf des Ordners
               eine leere Seite angezeigt werden soll. Diese Datei dient also lediglich der Absicherung und nicht für
               die Funktionalität des Moduls.

**Hinweis 2:** Neben den zwei Unterordnern `Admin` und `Shop` kann sich unter Umständen auch ein Ordner `Build`
               befinden. Dieser Unterordner wird unsererseits durch einen automatisieren Entwicklungsprozess mittels
               Gulp erstellt und enthält umgewandelte SCSS und JS Dateien. Für deine eigenen Module kannst du auf die
               hier generierten Dateien zwar zugreifen, bist aber nicht daran gezwungen.