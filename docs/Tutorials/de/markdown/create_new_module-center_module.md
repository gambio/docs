# Anlegen eines Module-Center Eintrags

In diesem Tutorial wird beschrieben, was das Modul-Center ist, wofür man es benötigt und wie man darin einen neuen 
Eintrag erstellt.

**Wichtig:** Module-Center Module können über zwei Wege angelegt werden. Diesem Tutorial beschäftig sich mit der
allgemeinen Variante (eher für Experten). Es gibt aber auch die Möglichkeit über die 
[GXModules-Konfigurationsdatei](gx-modules-configuration.md) sehr einfachen Wege einen Eintrag im Modul-Center zu
erstellen. Für Anfänger und nicht so erfahrene Entwickler empfehlen wir daher lieber auf die
GXModules-Konfigurationsdatei zurückzugreifen.


## Was ist das Modul-Center?

Das Modul-Center dient als zentrale Anlaufstelle, um Shopfunktionalitäten zu de-/installieren und zu konfigurieren. 
Alle Programme, die das Shopsystem um eine Funktionalität erweitern, werden Module genannt. Dies kann z. B. eine 
komplexe Schnittstelle zu einem externen Dienst sein, aber auch ein kleines Programm, das nur irgendwo eine kleine 
Information ausgibt.
Das Modul-Center bietet eine Übersicht über den Status aller Module im Shopsystem. Es löst das alte System ab, dass 
jedes Modul seine eigene, nicht einheitliche Seite und Oberfläche zur Installation und Konfiguration hat. Dem Nutzer ist 
so jederzeit klar, wo er sehen kann, welche Module in seinem Shop gerade genutzt werden. Ein wichtiger Aspekt ist, dass 
der Nutzer vor allem entscheiden kann, welche Module er nicht nutzen möchte. Ein Modul sollte also stets damit beginnen 
zu überprüfen, ob es installiert ist, bevor es mit der Ausführung der eigentlichen Funktionalität beginnt.


## Wie erstellt man einen neuen Eintrag im Modul-Center?

Jeder Eintrag im Modul-Center hat eine eigene Klasse, die die abstrakte Klasse `AbstractModuleCenterModule` extenden 
muss. Möchtest du also eine solche Klasse erstellen, kannst du diese zum Beispiel unter 
`GXModules/{Modulherstellername}/{Modulname}/Admin/Classes/MySampleModuleCenterModule.inc.php` anlegen.
Folgende Namenskonvention ist zu beachten: [Name]ModuleCenterModule.inc.php`
  
So eine Klasse hat nichts weiter als drei Eigenschaften:

* Titel
* Beschreibung
* Sortiernummer
  
Diese müssen über die protected-Methode `_init()` gesetzt werden. Die Klassenvariablen heißen `title`, `description` und 
`sortOrder`. Damit Titel und Beschreibung sprachabhängig gesetzt werden können, steht der 
[LanguageTextManager](create_new_language_phrases.md) als Klassenvariable `languageTextManager` zur Verfügung. Es ist
zu beachten, dass die Beschreibung auf 500 Zeichen begrenzt ist und keine HTML-Tags erlaubt sind. Sie dient
ausschließlich zur kurzen Beschreibung des Moduls.

```php
class MySampleModuleCenterModule extends AbstractModuleCenterModule
{
	protected function _init()
	{
		$this->title       = $this->languageTextManager->get_text('sample_title');
		$this->description = $this->languageTextManager->get_text('sample_description');
		$this->sortOrder   = 99999;
	}
}
```   
  
Die Installation und Deinstallation muss nicht implementiert werden. Bei der Installation wird standardmäßig in der 
Tabelle `gm_configuration` ein Datensatz mit dem Key `MODULE_CENTER_[NAME]_INSTALLED` erzeugt. Als Value wird 1 für 
"installiert" und 0 für "deinstalliert" gespeichert. Der Wert kann shopweit z. B. mit der Funktion `gm_get_conf($key)` 
abgerufen werden. Der Status kann auch über die öffentliche Methode `isInstalled()` der Klasse selbst abgefragt werden.

Optional kann Code beim Installieren und Deinstallieren ausgeführt werden. Dazu stehen die öffentlichen Methoden 
`install()` und `uninstall()` zur Verfügung. Die Datenbank kann über die Klassenvariable `db` angesprochen werden. 
Es ist zu beachten, dass `parent::install()` bzw. `parent::uninstall()` aufgerufen werden müssen, wenn ein Eintrag in 
der in der Tabelle `gm_configuration` erzeugt werden soll. Dies wird dringend empfohlen! Andernfalls muss die Methode 
`_setIsInstalled()` implementiert werden, die für die Klassenvariable `isInstalled` den Status entsprechend als Boolean 
setzt.

```php
class MySampleModuleCenterModule extends AbstractModuleCenterModule
{
	protected function _init()
	{
		...
	}
	
	
	/**
	 * Install module and set own install flag in module table
	 */ 
	public function install()
	{
		parent::install();

		$this->db->set('installed', '1')->where('key', 'MY_SAMPLE_INSTALLED')->update('my_sample_module_table');
	}
	
	
	/**
	 * Uninstall module and set own install flag in module table
	 */ 
	public function uninstall()
	{
		parent::uninstall();
	
		$this->db->set('installed', '0')->where('key', 'MY_SAMPLE_INSTALLED')->update('my_sample_module_table');
	}
}
```  
 
Im Modul-Center steht für jeden Eintrag nach der Installation ein `Bearbeiten`-Button zur Verfügung. Das Verhalten 
dieses Buttons wird über eine Controller-Klasse gesteuert, die die abstrakte Klasse 
`AbstractModuleCenterModuleController` extenden muss. Diese kannst du zum Beispiel unter 
`GXModules/{Modulherstellername}/{Modulname}/Admin/Classes/MySampleModuleCenterModuleController.inc.php` erstellen. 
Es gilt folgende Namenskonvention: `[Name]ModuleCenterModuleController.inc.php`
 
Soll der `Bearbeiten`-Button auf eine andere Seite weiterleiten, genügt es, in der protected-Methode `_init()` in die 
Klassenvariable `redirectUrl` die URL zu schreiben.

```php
class MySampleModuleCenterModuleController extends AbstractModuleCenterModuleController
{
	protected function _init()
	{
		$this->redirectUrl = xtc_href_link('sample.php');
	}
}
```  
  
Gibt es mehrere Seiten, die über den Modul-Center-Eintrag aufgerufen werden können sollen, kann der `Bearbeiten`-Button 
auf eine Unterseite führen, auf der weitere verlinkte Buttons zu den gewünschten Seiten angezeigt werden. Dazu wird in 
der protected-Methode `_init()` nicht mehr die Klassenvariable `redirectUrl` gesetzt, sondern ein Titel für die 
Unterseite festgelegt und ein Array von Buttons befüllt. Dazu steht in der Controller-Klasse wieder der 
[LanguageTextManager](create_new_language_phrases.md) für sprachabhängige Texte als Klassenvariable `languageTextManager` zur 
Verfügung. Der Seiten-Titel und die Buttons werden in den Klassenvariablen `pageTitle` und `buttons` gesetzt. `buttons` 
hat folgenden Aufbau:

```php
array(
	array(
		'text' => 'Button-Label 1',
		'url'  => 'Button-URL 1'
	),
	array(
		'text' => 'Button-Label 2',
		'url'  => 'Button-URL 2'
	)
)
```  
  
Im Ganzen sieht das Beispiel so aus:
  
```php
class MySampleModuleCenterModuleController extends AbstractModuleCenterModuleController
{
	protected function _init()
	{
		$this->pageTitle = $this->languageTextManager->get_text('sample_title');
		$this->buttons   = array(
			array(
				'text' => $this->languageTextManager->get_text('sample_config_page'),
				'url'  => xtc_href_link('sample.php')
			),
			array(
				'text' => $this->languageTextManager->get_text('sample_api_page'),
				'url'  => xtc_href_link('sample.php', 'page=api')
			),
			array(
				'text' => $this->languageTextManager->get_text('sample_external_login_page'),
				'url'  => 'http://www.example.org/merchants/login/'
			)
		);
	}
}
```   

Es ist auch möglich, die gesamte Modul-Konfiguration im Controller selbst zu steuern und gar keine weiteren Klassen und 
Seiten zu nutzen. Ein ModuleCenterModuleController ist ein normaler AdminHttpViewController, über den eine gesamte 
Admin-Seite erzeugt werden kann.


## Worauf sollte bei der Arbeit mit dem Modul-Center besonders geachtet werden bzw. welche häufigen Fehler sollte ich vermeiden?

- Nach Anlegen der Klassen für den Modul-Center-Eintrag muss der Cache für **Modulinformationen** im Admin unter dem 
  **Menüpunkt Toolbox > Cache** geleert werden.
- Es darf nicht vergessen werden, den Controller in der EnvironmentHttpViewControllerRegistryFactory  zu registrieren.


## Beispiele, die im Shop getestet werden können

1. [Beispiel Modul-Center Module](../samples/module-center/SampleModuleCenterModule.inc.php)  
   Zielverzeichnis: GXMainComponents/Modules
   
2. [Beispiel Modul-Center Controller](../samples/module-center/SampleModuleCenterModuleController.inc.php)  
   Zielverzeichnis: GXMainComponents/Controllers/HttpView/ModuleCenter
   
3. [Beispiel-Modul-Seite](../samples/module-center/sample_configuration.html)  
   Zielverzeichnis: admin/html/content/module_center

4. [englische Sprach-Datei Menü-Eintrag](../samples/module-center/english/admin_menu.sample_module.lang.inc.php) (optional)  
   Zielverzeichnis: lang/english/user_sections

5. [englische Sprach-Datei Modul-Center-Eintrag](../samples/module-center/english/module_center_module.sample.lang.inc.php)  
   Zielverzeichnis: lang/english/user_sections
   
6. [deutsche Sprach-Datei Menü-Eintrag](../samples/module-center/german/admin_menu.sample_module.lang.inc.php) (optional)  
   Zielverzeichnis: lang/german/user_sections

7. [deutsche Sprach-Datei Modul-Center-Eintrag](../samples/module-center/german/module_center_module.sample.lang.inc.php)  
   Zielverzeichnis: lang/german/user_sections   
   
8. [Beispiel-Menü-Eintrag](../samples/module-center/menu_sample.xml) (optional) - siehe
   [Erstellen von Menüeinträgen im Administrationsbereich](create_a_new_menu_entry.md)  
   Zielverzeichnis: GXUserComponents/conf/admin_menu
   
Um das Beispiel testen zu können, muss nach Kopieren der Dateien im Admin der Cache für **Texte**,
**Modulinformationen** und **Seitenausgabe** unter dem **Menüpunkt Toolbox > Cache** geleert werden.
   