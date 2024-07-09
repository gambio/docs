## Autoloading

Der PSR-4 PHP Standard beschreibt eine Methodik, wodurch ein System Klassen finden kann, ohne sie manuell einzubinden.
*Composer*, das PHP-Package Management Tool erstellt automatisch so einen Autoloader. Dazu muss lediglich angegeben
werden, welche Ordner des Shops auf welchen, sogenannten "Root"-Namespace, gemapped werden müssen.

Der Autoloader des Shops mapped automatisch das "./GXModules" Verzeichniss auf den *GXModules* Root-Namespace.
Wenn wir nun den Namespace-Pfad, der nach den Root kommt, identisch zur Verzeichnisstruktur benennen, werden die
Klassen automatisch vom Shopsystem gefunden.


