# Creating a custom module for the Module Center

This tutorial describes what the Module Center is, what it is used for and how to create a new entry in it.

**Important:** Module Center modules can be created in two ways. This tutorial deals with the general variant (for
experts). Additionally, there is possibility to create a Module Center entry very easily via a
[GXModules JSON file](./gx-modules-json.md). For beginners and not so experienced developers, we recommend using
the JSON file.


## What is the Module Center?

The Module Center is the central place to install, configure and uninstall shop functionality. All programs that
add functionality to the shop system are called modules. This, for example, could be a complex interface for an
external service or a small program that only outputs a small amount of information. The Module
Center provides an overview of the status of all modules in the shop system. It replaces the old system where each
module had its non-uniform page and interface for installation and configuration. This means that the user
always knows where he can see which modules are currently being used in his shop. An important aspect is that the
user can decide which modules he wants or does not want to use. A module should therefore always start by checking
whether it is installed before starting to execute the actual functionality.


## How do you create a new entry in the Module Center?

Each entry in the Module Center has its class, which must extend the abstract class `AbstractModuleCenterModule`.
If you want to create such a class, you can create it using GXModules
(`GXModules/<Vendor>/<Module>/Admin/Classes/MySampleModuleCenterModule.inc.php`). Please mind the following naming
convention: `[ModuleName]ModuleCenterModule.inc.php`. Every class implementing the abstract class
`AbstractModuleCenterModule` needs to use the `ModuleCenterModule` for their class names.
  
Such a class has three characteristics:

- Title
- Description
- Sort number
  
These must be set using the protected method `_init()`. The class variables are called `title`, `description` and
`sortOrder`. To set title and description language-dependent, the `\LanguageTextManager` is available as a class
variable `languageTextManager`. Please note that the description is limited to 500 characters and no HTML tags are
allowed. Title and description should only consist of a short module description.

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

The installation and uninstallation don't need to be implemented. During installation a data record with the key
`MODULE_CENTER_[MOLDULE_NAME]_INSTALLED` is by default created in the table `gx_configuration`. As value, `1` is saved
for **installed** and `0` for **uninstalled**. The value can be retrieved shop-wide with the function
`gm_get_conf($key)` method. The status can also be queried via the public method `isInstalled()` of the class itself.

Optionally, code can be executed during installation and uninstallation. The public methods `install` and `uninstall`
are available for this purpose. The database can be accessed via the class variable `db`. Please note that
`parent::install()` or `parent::uninstall()` have to be called if an entry is to be created in the `gm_configuration`
table. This is strongly recommended! Otherwise, the method `_setIsInstalled` has to be implemented, which sets the
status of the class variable `isInstalled` according to Boolean.

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

In the Module Center an **Edit** button can be found for each entry after installation. The behaviour of this button is
controlled by a controller class, which must extend the abstract class `AbstractModuleCenterModuleController`. You can
create this using GXModules (`GXModules/<Vendor>/<Module>/Admin/Classes/MySampleModuleCenterModuleController.inc.php`).
The following naming convention applies `[ModuleName]ModuleCenterModuleController.inc.php`.
 
If the **Edit** button is to redirect to another page, it is sufficient to write the URL in the protected method
`init` in the class variable `redirectUrl`.

```php
class MySampleModuleCenterModuleController extends AbstractModuleCenterModuleController
{
   protected function _init()
   {
      $this->redirectUrl = xtc_href_link('sample.php');
   }
}
```  

If several pages are to be called up via the Module Center entry, the **Edit** button can lead to a subpage where
further linked buttons for the desired pages are displayed. For this purpose, the protected method `_init` no longer
sets the class variable `redirectUrl`, but defines a title for the subpage and fills an array of buttons. In
the controller class the `\LanguageTextManager` for language-dependent texts is again available as class variable
`languageTextManager`. The page title and the buttons are set in the class variables `pageTitle` and `buttons`.
`buttons` has the following structure:

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
  

The complete example looks like this:

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

It is also possible to control the entire module configuration in the controller itself and not use any other classes
and pages at all. A `ModuleCenterModuleController` is a normal `AdminHttpViewController`, which can be used to create
an entire admin page.


## What should I pay special attention to when working with the Module Center or which common mistakes should I avoid?

- After creating the classes for the Module Center entry, the cache for **module information** must be cleared in the
  admin under the **menu item Toolbox > Cache**.
- Do not forget to register the controller in the EnvironmentHttpViewControllerRegistryFactory.


## Examples that can be tested in the shop

[Here](./../_samples/module-center.zip) you can find an example containing all showed components, like;

- **Example Module Center Module** inside the `GXMainComponents/Modules` directory.
- **Example Module Center Controller** inside the `GXMainComponents/Controllers/HttpView/ModuleCenter` directory.
- **Example module page** inside the `admin/html/content/module_center` directory.
- **English language file menu item** inside the `lang/english/user_sections` directory.
- **English language file module center entry** inside the `lang/english/user_sections` directory.
- **German language file menu entry** inside the `lang/german/user_sections` directory.
- **German language file module center entry** inside the `lang/german/user_sections` directory.
- **Example menu item** inside the `GXUserComponents/conf/admin_menu` directory.
   
To test the example, after copying the files, the cache for **texts**, **module information** and **page output** must
be cleared in the admin under the **menu item Toolbox > Cache**.
   
