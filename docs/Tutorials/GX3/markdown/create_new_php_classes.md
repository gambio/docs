# Anlegen neuer PHP Klassen

Theoretisch können zwar durch unser AutoLoading Klasses innerhalb deines Moduls zwar überall gefunden werden, jedoch
empfehlen wir hier folgende Struktur:

```
- GXModules/
    - {Modulhersteller}/
        - {Modulname}/
            - Admin/ 
                - Classes/
            - Shop/ 
                - Classes/
```

Eine weitere Unterteilung deiner Klassen in Controller etc. und damit verbundene Nutzung von weiteren Unterordnern
wird empfohlen, ist jedoch nicht notwendig:

```
- GXModules/
    - {Modulhersteller}/
        - {Modulname}/
            - Admin/ 
                - Classes/
                    - Controllers/
                    - Entities/
                    - Exceptions/
                    - Modules/
                    - Services/
                    - Storages/
                    - ValueObjects/
                    ...
```

**Hinweis:** Im Allgemeinen gilt, dass der Autoloader standardmäßig rekursiv alle Unterordner deines
             Modulverzeichnisses nach der aufgerufenen Klasse durchsucht und dann einbindet. Hierbei ist es wichtig zu
             wissen, dass der Autoloader die erste gefundene Klasse, welche er im `GXModules`-Ordner findet, einbindet.
             Dies bedeutet, dass wenn mehrere Entwickler ihre Klassen gleich benennen, du als Entwickler nicht davon
             ausgehen kannst, dass du deine eigene Klasse vom Autoloader erhälst. Um dieses Problem zu umgehen,
             solltest du daher darauf achten, dass die Bezeichnungen der neuen Klassen möglichst eindeutig sind oder
             du Namespaces verwendest.