# Anlegen und Bearbeiten von Menüeinträgen

Dieses Tutorial beschreibt, wie sich eigene Menüeinträge für den Administrationsbereich hinzufügen lassen.

Um generell einen neuen Menüeintrag hinzuzufügen, muss zunächst eine neue XML-Datei im Ordner
`GXModules/{Modulherstellername}/{Modulname}/Admin/Menu/` erstellt werden. Diese Datei muss mit dem Präfix **menu_**
beginnen. Ein Beispielname für die Datei wäre `menu_new_entry.xml`


## Hinzufügen eines Menüeintrages zu einer bestimmten Kategorie

Soll ein Menüeintrag zu einer bestimmten Kategorie hinzugefügt werden, gilt es zunächst die ID der gewünschten
Kategorie ausfindig zu machen. In diesem Beispiel fügen wir einen neuen Eintrag zu der Kategorie `Bestellungen`
hinzu. Unser neuer Eintrag soll **Top Bestellungen** lauten.

Dazu schauen wir uns die Datei `system/conf/admin_menu/gambio_menu.xml` an. Dort finden wir unter anderem folgende
Einträge:

```xml
<?xml version="1.0"?>
<!-- {load_language_text section="admin_menu" use_fallback=$smarty.const.SHOW_UNTRANSLATED_MENUITEMS} -->
<!-- {load_language_text section="module_center_module" name="module_center_module" use_fallback=$smarty.const.SHOW_UNTRANSLATED_MENUITEMS} -->
<admin_menu>
	<menugroup id="BOX_HEADING_FAVORITES" sort="10" background="favs.png" class="fa fa-heart" title="{$txt.BOX_HEADING_FAVS|escape}">
	</menugroup>

	<menugroup id="BOX_HEADING_ORDERS" sort="20" background="favs.png" class="fa fa-shopping-cart" title="{$txt.BOX_ORDERS|escape}">
		<menuitem sort="10" link="FILENAME_ORDERS" title="{$txt.BOX_ORDERS|escape}" />
		<menuitem sort="20" link="FILENAME_ORDERS_STATUS" title="{$txt.BOX_ORDERS_STATUS|escape}" />
		<menuitem sort="30" link="withdrawals.php" title="{$txt.BOX_WITHDRAWALS|escape}" />
	</menugroup>

	<menugroup id="BOX_HEADING_CUSTOMERS" sort="30"  class="fa fa-group" title="{$txt.BOX_HEADING_CUSTOMERS|escape}">
		<menuitem sort="10" link="FILENAME_CUSTOMERS" title="{$txt.BOX_CUSTOMERS|escape}" />
		<menuitem sort="20" link="FILENAME_CUSTOMERS_STATUS" title="{$txt.BOX_CUSTOMERS_STATUS|escape}" />
		<menuitem sort="30" link="admin.php" link_param="do=Emails" title="{$txt.BOX_EMAILS|escape}" />
		<menuitem sort="40" link="FILENAME_GM_INVOICING" title="{$txt.BOX_GM_INVOICING|escape}" />
	</menugroup>
	...
</admin_menu>
```

Jedes `<menugroup>`-Element ist eine Kategorie im Gambio Admin. Wir benötigen ein `<menugroup>`-Element mit einer
bestimmten ID, um diesem unseren neuen Eintrag hinzuzufügen. In unserem Fall ist es das Element mit der ID
`BOX_HEADING_ORDERS`.

```xml
<menugroup id="BOX_HEADING_ORDERS" sort="20" background="favs.png" class="fa fa-shopping-cart" title="{$txt.BOX_ORDERS|escape}">
```

In dem Verzeichnis `GXModules/{Modulherstellername}/{Modulname}/Admin/Menu/` erstellen wir nun eine XML-Datei namens
`menu_top_orders.xml` mit folgendem Code:

```xml
<?xml version="1.0"?>
<!-- {load_language_text section="admin_menu"} -->
<admin_menu>
	<menugroup id="BOX_HEADING_ORDERS">
		<menuitem sort="40" link="new_page.php" title="Top Bestellungen" />
	</menugroup>
</admin_menu>
```

Zu beachten ist, wie oben bereits beschrieben, dass der Dateiname mit `menu_` beginnen muss.


### Was bewirkt dieser Code genau?

Zunächst ist es wichtig, dass das höchste Elternelement `<admin_menu>` ist. Dies ist notwending, um das
Gambio-Administrationsmenü zu identifizieren und Elemente zu diesem hinzuzufügen.

Mit folgenden Abschnitt geben wir an, dass wir einen neuen Eintrag zur Kategorie mit der ID `BOX_HEADING_ORDERS`
hinzufügen wollen:

```xml
<menugroup id="BOX_HEADING_ORDERS">
	...
</menugroup>
```

Der folgende Abschnitt spiegelt den eigentlichen Menüeintrag wider:

```xml
<menuitem sort="40" link="new_page.php" title="Top Bestellungen" />
```

Das Attribut `sort` gibt an, an welcher Stelle der Kategorie unser neuer Eintrag erscheinen soll. In diesem Fall wird
unser Eintrag an letzter Stelle hinzugefügt, da die drei vorherigen Einträge eine niedrigere `sort`-Nummer besitzen.
Wählt man eine bereits vorhandene `sort`-Nummer, wird der Menüeintrag vor oder nach dem Eintrag, der diese Nummer
ebenfalls besitzt, angeordnet (Es kommt zuerst der Eintrag, der als Erstes verarbeitet wird). Lassen wir das
`sort`-Attribut aus, wird der Eintrag automatisch an letzter Stelle eingefügt.

Zu dem Wert des `link`-Attributes muss ein **Admin Access** Berechtigung für den Nutzer existieren. Ist dies nicht der
Fall, kann es sein, dass der Menüeintrag nicht hinzugefügt wird. Grundsätzlich ist das von der Konfigurations der
Nutzerrollen des Nutzers abhängig. Mehr zu diesem Thema findest du im Abschnitt
[Verwendung der Zugriffsverwaltung]().

Die folgende Zeile lädt die Section `admin_menu`, also das Gambio-Administrationsmenü in der jeweiligen Sprache:

```xml
<!-- {load_language_text section="admin_menu"} -->
```

Damit das `title`-Attribut selbst angelegte Texte in den verschiedenen Sprachen anzeigt, muss eine eigene Variable
erstellt werden, die den entsprechenden Text enthält.

Statt

```xml
<menuitem sort="40" link="new_page.php" title="Top Bestellungen" />
```

würde die Zeile beispielsweise wie folgt aussehen:

```xml
<menuitem sort="40" link="new_page.php" title="{$txt.BOX_TOP_ORDERS|escape}" />
```

Mehr zur Textphrasen und Sprachdateien findest du in [diesem Abschnitt](create_new_language_phrases.md).


## Hinzufügen einer neuen Kategorie mit Menüeintrag

Das Hinzufügen einer neuen Kategorie mit Menüeintrag funktioniert im Prinizip genauso wie das Hinzufügen von
Menüeinträgen zu bereits bestehenden Kategorien. Die einzigen Unterschiede hierbei sind:

* Wir vergeben als `<menugroup>`-ID statt einer bereits vorhandenen eine neue, eigene ID
* Wir wählen eine `sort`-Nummer, um die Position im Menü zu bestimmen
* Wir wählen ein Hintergrundbild im Attribut `background`
* Wir vergeben optional eine eigene CSS-Klasse

```xml
<?xml version="1.0"?>
<!-- {load_language_text section="admin_menu"} -->
<admin_menu>
	<menugroup id="BOX_HEADING_MY_NEW_MENU_CATEGORY" sort="250" background="favs.png" class="my-class" title="Top Orders">
		<menuitem sort="10" link="new_page.php" title="Top Bestellungen" />
	</menugroup>
</admin_menu>
```


## Letzter Schritt

Nachdem die Datei erfolgreich erstellt wurde, müssen folgende Caches in der angegeben Reihenfolge geleert werden,
damit der neue Eintrag im Menü sichtbar wird.

1. Cache für Modulinformationen
2. Cache für die Texte
3. Cache für die Seitenausgabe

Die Optionen, den Cache zu leeren, finden Sie im Administrationsmenü unter **Toolbox > Cache**


## Weitere Beispiele
- [Beispiel für das Hinzufügen eines Menüeintrages zu einer bestehenden Kategorie](../samples/menu/menu_zones_in_orders.xml)
- [Beispiel für das Hinzufügen einer Kategorie inklusive Menüeintrag](../samples/menu/menu_zones_with_zones_category.xml)
