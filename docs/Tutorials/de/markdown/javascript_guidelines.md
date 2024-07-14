# JavaScript Richtlinien

**Hinweis:** Diese Seite enthält veraltete Informationen und wird bald überarbeitet.


- Benennung von Variablen und Funktionen erfolgen in der lowerCamelCase-Notation

- Konstanten sollten nicht verwendet werden

- Kein SQL in JavaScript

- Wenn möglich, `name` und `value` von form-Feldern keine Tabellen- oder Spaltennamen der Datenbank zuweisen

- Es dürfen bis auf Funktions- oder Variablen-Sammlungen, welche die komplette Seite betreffen,
  keine globalen Variablen verwendet werden. Im Ausnahmefall ist eine Sammlung in Form eines JSON-Objekts
  zu verwenden, sodass das Windows-Objekt möglichst klein bleibt

- Jede JavaScript Datei besitzt einen **Gambio-GPL-Header**

- JavaScripte sind sowohl komprimiert als auch unkomprimiert auszuliefern

- AJAX-Schnittstellen müssen wie [REST](https://de.wikipedia.org/wiki/Representational_State_Transfer)
  konforme Webdienste implementiert werden. Daten lesen über `GET`, Daten schreiben über `POST`.
  Das bedeutet auch, dass in einer `POST`-Antwort keine Daten gelangen, die zur Anzeige gebracht werden.
  Hierfür ist ein weiterer `GET`-Request notwendig. Rückgabewerte von `POST`-Requests (evtl. auch PUT, DELETE)
  werden über den Header übertragen, in Debug-Funktionen auch als JSON.

  **_Achtung_**: Manche IE-Versionen verwenden bei `GET`-Requests den Browser Cache. Hier JQuery `cache: false` nutzen

- **Keine hardgecodeten Texte**. Texte gehören in die Sprachdateien

- Leerzeichen in Datei- und Ordnernamen sind nicht erlaubt. Erlaubte Zeichen sind `a-Z, 0-9, _`

- Öffnende Klammern gehören in dieselbe Zeile wie das Statement

- Wertzuweisungen mittels `||` sind erlaubt

- Wenn möglich, mit losen Kopplungen arbeiten. Keine Funktionen direkt aufrufen, die nicht auch zur Funktionalität
 der eigentlichen Komponente gehören und deren Existenz nicht sichergestellt ist.

- `"use strict"` ist zu verwenden

- Wenn möglich, in Closures arbeiten

- Zwischen Statement und Signatur sowie zwischen Signatur und öffnender geschweifter Klammer gehört ein Leerzeichen

```javascript
// Falsch
if(true){

}

// Korrekt
if (true) {

}
```


## Variablen: Präfix und Suffix

- `$`-Präfix für bereits ausgeführte Selektoren

```javascript
var $body = $('body');
```

- Interne Funktionen, die nicht direkt von außen erreichbar sind, werden mit einem `_` als Präfix versehen.
