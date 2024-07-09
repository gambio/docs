# Defining a module

The definition, configuration or registration of a module to the system can be done in two ways and depends on what
your module does. A module can have a so-called `GXModule.json` file and/or a module PHP class inside the root
directory of it. Both files will be handled differently and define or configure different parts of the shop software.


## The module class

If you're using the new [Application Core], you need to create a specific module class inside your modules root
directory. Our module system will detect this module class (at least after clearing the module caches) and
register your event listener, command handler and/or HTTP routes.

The mechanism for searching the GXModules directory for module classes is based on these two conventions:

1. The class name must have a `Module` suffix, which means that the file name must end with `Module.php`
   (e.g. `GXModules/<Vendor>/<Module>/SampleModule.php`).
2. The module class must extend the `Gambio\Core\Application\Modules\AbstractModule` class.

As new modules are added to the system, the modules cache must be renewed in the Gambio Admin (**Toolbox > Caches**).

Your module class may implement several methods that provide information about your module. The following examples
give an overview of these methods. Mind that not every method needs to be implemented because of the abstract
base class.

```php

namespace GXModules\<Vendor>\<Module>;

use Gambio\Admin\Modules\Withdrawal\Model\Events\CreatedWithdrawal;
use Gambio\Core\Application\Modules\AbstractModule;
use GXModules\<Vendor>\<Module>\Events\SampleEvent;
use GXModules\<Vendor>\<Module>\EventListener\SampleEventListener;
use GXModules\<Vendor>\<Module>\EventListener\SampleCreatedWithdrawalEventListener;

/**
 * Class SampleModule
 * @package GXModules\<Vendor>\<Module>
 */
class SampleModule extends AbstractModule
{
    /**
     * Lists all event listeners.
     *
     * The list must be a multidimensional array in the following format:
     * key   := full qualified class name of the event class
     * value := numeric, one dimensional array with full qualified class name
     *          of the event listener class
     *
     * @return array|null
     */
    public function eventListeners(): ?array
    {
        return [
            SampleEvent::class => [
                SampleEventListener::class
            ],
            CreatedWithdrawal::class => [
                SampleCreatedWithdrawalEventListener::class
            ],
        ];
    }
}
```


### Register your Service Provider

Adding your [Service Provider] to the [Application Core] is pretty straightforward. Similar to the mechanism
that is looking for a module class inside your modules root directory, it's also looking for a [Service Provider].

The mechanism is based on these two conventions:

1. The class name must have a `ServiceProvider` suffix, which means that the file name must end with
   `ServiceProvider.php` (e.g. `GXModules/<Vendor>/<Module>/SampleServiceProvider.php`).
2. The [Service Provider] class must extend the
   `Gambio\Core\Application\DependencyInjection\AbstractModuleServiceProvider` or
   `Gambio\Core\Application\DependencyInjection\AbstractModuleBootableServiceProvider` class.

More information about the implementation of a [Service Provider] can be found in the corresponding tutorial.


## The `GXModule.json` file

Creating a `GXModules.json` file inside your modules directory (e.g. `GXModules/<Vendor>/<Module>/GXmodule.json`),
you can provide some basic information about your module and create an entry inside our Module Center, where your
module then can be installed or uninstalled.

If you don't create such a file, there will be no entry inside our Module Center and your module can't be installed
or uninstalled. This way, our automatic mechanics and processes will always process all files of your modules. Doing
so is neither good nor bad, it depends on what your module does or needs.


### The basic information

As said, the `GXModule.json` need to be placed inside the root directory of your module. The essential content of
this file looks like this:

```json
{
    "title": "sample_module_text_section.module_title",
    "description": "sample_module_text_section.module_description",
    "forceIncludingFiles": false
}
```

The values of the attributes `title` and `descriptions` contain a reference to the module title or description. The
left side (starting from the dot) indicates the language section, while the right side shows the text phrase.

The value of the `forceIncludingFiles` attribute indicates if our system should process all of your module files even
if the module isn't installed.

!!! Notice "Notice"
    Our language and text system can only look up the title and description if you also provide the text phrases in
    form of a language text file.


### Execute custom logic on install or uninstall

If you want to provide extra custom logic that will be executed on the installation or uninstallation of your module,
you can create a specific class and reference it inside the `GXModule.json` using the following schema:

```json
{
   "install": {
       "controller": "MyModuleInstallerClass",
   	   "method": "onInstallation"
   	},
   	"uninstall": {
   	    "controller": "MyModuleInstallerClass",
   	    "method": "onUninstallation"
   	}
}
```

The `controller` and `method` attributes define which class and method should be initialized and executed. You need
to make sure, this class is registered by a service provider.

The following example shows the implementation of the install and uninstall methods:

```php
namespace GXModules\<Vendor>\<Module>;

/**
 * MyModuleInstallerClass
 * @package GXModules\<Vendor>\<Module>
 */
class MyModuleInstallerClass
{
    /**
     * @param array $gxmodulesJsonData
     */
	public function onInstallation(array $gxModulesJsonData): void
	{
		// do some stuff before install
	}
	
    /**
     * @param array $gxmodulesJsonData
     */
	public function onUninstallation(array $gxModulesJsonData): void
	{
		// do some stuff after uninstall
	}
}
```

!!! Notice "Notice"
    The `$gxModulesJsonData` parameter will be containing the parsed content of the modules `GXModule.json`.



[Application Core]: ./../../framework/application-core.md
[Service Provider]: ./../../framework/details/service-provider.md
[legacy architecture]: ./../../framework/legacy-architecture.md
