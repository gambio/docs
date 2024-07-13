# Service Providers

Service Providers are an essential part of the Application Core and their task is to manage and provide the components
and services of the application.

A Service Provider usually defines two things. First, it contains information about which service can be requested
from the [DI Container] and second, it defines the interfaces and dependencies of the service classes.

When implementing a Service Provider, ensure that they either inherit from
`Gambio\Core\Application\DependencyInjection\AbstractModuleServiceProvider` or
`Gambio\Core\Application\DependencyInjection\AbstractModuleBootableServiceProvider`.


## Available services and classes

The method `provides` defines which services or classes can later be requested via the [DI Container]. Internal
components used by the services don't have to be mentioned in the `provides` method, which also means they won't be
available from outside of the Service Provider. 

```php
namespace GXModules\<Vendor>\<Module>;

use Gambio\Core\Application\DependencyInjection\AbstractModuleServiceProvider;
use GXModules\<Vendor>\<Module>\MyService;

/**
 * Class SampleServiceProvider
 * @package GXModules\<Vendor>\<Module>
 */
class SampleServiceProvider extends AbstractModuleServiceProvider
{
    /**
     * @inheritDoc
     */
    public function provides(): array
    {
        return [
            MyService::class,
        ];
    }
    
    ...
}
```

!!! Notice "Notice"
    Minding the [PSR-4]{target=_blank} namespace, this `SampleServiceProvider` would be located at
    `GXModules/<Vendor>/<Module>/SampleServiceProvider.php` inside the file structure of the shop.
    It's also possible to change the location of this file, which would also change the namespace.


## Register services and classes

In the `register' method, we add the service or classes and all required components to the [DI Container].


```php
namespace GXModules\<Vendor>\<Module>;

use Doctrine\DBAL\Connection;
use Gambio\Core\Application\DependencyInjection\AbstractModuleServiceProvider;
use GXModules\<Vendor>\<Module>\MyService;
use GXModules\<Vendor>\<Module>\MyServiceImplementation;
use GXModules\<Vendor>\<Module>\MyServiceDependency;

/**
 * Class SampleServiceProvider
 * @package GXModules\<Vendor>\<Module>
 */
class SampleServiceProvider extends AbstractModuleServiceProvider
{
    /**
     * @inheritDoc
     */
    public function provides(): array
    {
        return [
            MyService::class,
        ];
    }

    /**
     * @inheritDoc
     */
    public function register(): void
    {
        $this->application->registerShared(MyService::class, MyServiceImplementation::class)
             ->addArgument(MyServiceDependency::class);
        
        $this->application->registerShared(MyServiceDependency::class)
             ->addArgument(Connection::class);
    }
}
```

!!! Notice "Notice"
    Minding the [PSR-4]{target=_blank} namespace, this `SampleServiceProvider` would be located at
    `GXModules/<Vendor>/<Module>/SampleServiceProvider.php` inside the file structure of the shop.
    It's also possible to change the location of this file, which would also change the namespace.


## Bootable Service Provider

You can also mark a Service Provider as *bootable* by inheriting from `AbstractModuleBootableServiceProvider`.
Bootable means that you can implement another method called `boot`, which is executed when the Service Provider has
been added to the [DI Container].

The boot method is important for the defined interfaces between your module and the shop software. For instance,
registering specific components to their managing aggregates and services. For these cases you need to use the
`inflect` method to tell certain system components, that your module specific components needs to be considered,
in case these system components do something important. A good example for this might be the registration of
event listeners by using inflections.

```php
use Gambio\Core\Application\DependencyInjection\AbstractModuleBootableServiceProvider;
use Gambio\Core\Event\EventListenerProvider;
use GXModules\<Vendor>\<Module>\...\SampleEvent;
use GXModules\<Vendor>\<Module>\...\SampleEventLister;

/**
 * Class BootableSampleServiceProvider
 */
class BootableSampleServiceProvider extends AbstractModuleBootableServiceProvider
{
    ...
    
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        // this code will be executed as soon as the Service Provider will be registered to the DI Container
        
        // the following lines are an example of how to register an event lister using inflections
        $this->application->inflect(EventListenerProvider::class)
             ->invokeMethod('attachListener', [SampleEvent::class, SampleEventLister::class])
    }
}
```

!!! Notice "Notice"
    Minding the [PSR-4]{target=_blank} namespace, this `SampleServiceProvider` would be located at
    `GXModules/<Vendor>/<Module>/BootableSampleServiceProvider.php` inside the file structure of the shop.
    It's also possible to change the location of this file, which would also change the namespace.



[PSR-4]: https://www.php-fig.org/psr/psr-4/
[DI Container]: ./di-container.md
