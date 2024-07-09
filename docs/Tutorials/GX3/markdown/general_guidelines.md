# Allgemeine Programmierrichtlinien

**Hinweis:** Diese Seite enthält veraltete Informationen und wird bald überarbeitet.


- Die Sprache für Bezeichner ist Englisch

- Code muss in jeder unterstützen Umgebung lauffähig sein. Das beinhaltet beispielweise
  die minimal und maximal unterstütze PHP Version
  
- Alle Bezeichner werden aussagekräftig und eindeutig definiert

- Auf keinen Fall Abkürzungen verwenden die zweideutig sein könnten

- Bezeichner einer Klassen werden mit Großbuchstaben voneinander getrennt (UpperCamelCase)

- Keine magischen Zahlen

- Variablen in for-Schleifen werden mit einem Buchstaben definiert

- Code, der nicht benutzt wird, muss entfernt werden

- AJAX-Response vom Server an den Client sollte möglichst im JSON-Format sein

Beispiel:

```javascript
var DRAFT = {
  success: true,
  payload: data,
  message: message
};
```

- Dateien die keine Klassen enthalten, werden klein geschrieben. Im Gegensatz dazu
  werden Dateien, die Klassen enhalten, genauso wie die Klasse benannt.

- Bei neu erstellten Ordnern muss eine leere index.html Datei angelegt werden, damit der Ordner
  nicht aufrufbar ist. Sofern möglich, sollte auch ein .htaccess-Schutz für Ordner genutzt werden

- **_Don't trust user input_**. Daten von außen sind zu validieren und Fehlerfälle abzufangen

- Kommentare müssen aussagekräftig sein. Nicht etwa beispielweise `//Start` und `//End`

- Alle Schlüsselwörter werden klein geschrieben, z. B. `if, for, foreach, as, while`

- Strings werden in einfache Anführungszeichen gesetzt. `'Mein String'`

- Ternäre Ausdrücke sind, sofern leserlich, erlaubt

- Statement-Rümpfe sind in geschweifte Klammern zu setzen

- Immer typsichere Vergleiche verwenden.
	```php
	// Falsch, Ergebnis ist true
	'5' == 5

	// Korrekt, Ergebis ist false
	'5' === 5
	```
  **_Ausnahme:_** Werte die unterschiedliche false-Werte enthalten können. Bsp: 'null' und '0'

- Als default False-Wert bei single-select Feldern, sollte `-1` verwendet werden, sofern dies kein
  valider Wert für einen Datensatz ist

- Auf `deprecated` Funktionen verzichten


## Nutzung von Settern und Gettern
- Setter `set<Variablenname>` sollten eine Validierung des übergebenen Wertes durchführen

- Getter `get<Variablenname>` sollten stets den unveränderten Inhalt der Klassenvariablen zurückgeben.
  Getter, die den Inhalt manipulieren, sollten namentlich nicht direkt vom Variablennamen abgeleitet sein
  Beispiel: `getFormated<Variablenname>`

- Innerhalb von Klassen, sollten die klasseneigenen Getter- und Setter-Methoden nicht genutzt werden, sondern
  direkt auf die Klassenvariableen zugegriffen werden

  **_Ausnahme:_** Bei der Nutzung von Daten aus nicht refaktorierten Quellen, darf innerhalb einer Klasse
  ein eigener Setter genutzt werden, um solche Variablen vor dem Setzen zu validieren


## Dokumentation
- Die Sprache für Kommentare und Dokumentation ist Englisch
