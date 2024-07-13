# Extend Layout Data of gambio admin

In the tutorial I will demonstrate how to pass your data to the admin template. Some techniques are used, which 
are explained in detail in a separate tutorial. Nevertheless you should be able to follow the tutorial without problems. 

If you need more information about how it works, you can just have a look at the respective tutorials.

## Plugin class

First we need a plugin class. The shop system determines it automatically after the module cache has been cleared. 
In this class we define which other classes should be used by the module.  
In our case we need a service provider, 
command handler and a so called LayoutLoader, which I will explain in more detail later.
All classes must be able to be found by the autoloader.

- [Plugin](../create-a-module/entrypoint.md)
- [ServiceProvider](../core-architecture/service-provider.md)
- [Autoloader](../create-a-module/autoloading.md)

```php
// Filepath: ./GxModules/MyVendor/MyModule/MyPlugin.php

namespace GxModules\MyVendor\MyModule;

use Gambio\Admin\Layout\Smarty\LoadLayoutData;
use Gambio\Core\Application\Plugins\AbstractPlugin;

class MyPlugin extends AbstractPlugin
{
    public function commandHandlers(): ?array
    {
        return [
            LoadLayoutData::class => [
                MyLoadLayoutDataHandler::class
            ]
        ];
    }

    public function serviceProviders(): ?array
    {
        return [MyServiceProvider::class];
    }
}
```

## Command Handler

The command handler must have the ::invoke method. It receives the command as a parameter and must also return it.

The LoadLayoutData command has the method ::addLoader, to which we pass our LayoutLoader. To have the LayoutLoader 
available at the location, we must pass it as a constructor parameter. We can use the service provider to inject 
the LayoutLoader.

- [Commands](./commands.md)

```php
// Filepath: ./GxModules/MyVendor/MyModule/MyLoadLayoutDataHandler.php

namespace GxModules\MyVendor\MyModule;

use Gambio\Admin\Layout\Smarty\LoadLayoutData;

class MyLoadLayoutDataHandler
{
    private $layoutLoader;
    public function __construct(MyLayoutLoader $layoutLoader) 
    {
        $this->layoutLoader = $layoutLoader;
    }

    public function __invoke(LoadLayoutData $command): LoadLayoutData
    {
        $command->addLoader($this->layoutLoader);
    
        return $command;
    }
}
```

## Layout Loader

```php
// Filepath: ./GxModules/MyVendor/MyModule/MyLayoutLoader.php

namespace GxModules\MyVendor\MyModule;

use Gambio\Admin\Layout\LayoutLoader;

class MyLayoutLoader
{
    
}
```
