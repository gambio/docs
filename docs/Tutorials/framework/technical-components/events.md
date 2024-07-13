# Events
 
We implemented an event system for dispatching events and the registration of event handlers based on
[PSR 14]{target=_blank}. Events differ from command by pointing out something happened, while
commands trigger a specific process inside the application.

The following example shows how to implement an event and event handler:

```php
namespace GXModules\<Vendor>\<Module>\Events;

/**
 * Class SampleEvent
 * @package GXModules\<Vendor>\<Module>\Events
 */
class SampleEvent
{
}
```

```php
namespace GXModules\<Vendor>\<Module>\EventListeners;

use GXModules\<Vendor>\<Module>\Events\SampleEvent;

/**
 * Class SampleEventListener
 * @package GXModules\<Vendor>\<Module>\EventListeners
 */
class SampleEventListener
{
    /**
     * @param SampleEvent $event
     */
    public function __invoke(SampleEvent $event): void
    {
        // do something
    }
}
```

It is common to inject some services in the handler to provide functionality. This should be done with the help of
a [Service Provider].


## Dispatching events

If you want to dispatch your own or existing events, you need to use `Gambio\Core\Event\Interfaces\EventDispatcher`.

The following example shows how to dispatch the `SampleEvent`:

```php
namespace GXModules\<Vendor>\<Module>;

use Psr\EventDispatcher\EventDispatcherInterface;
use GXModules\<Vendor>\<Module>\Events\SampleEvent;

/**
 * Class AbstractModule
 * @package GXModules\<Vendor>\<Module>
 */
class SampleClass
{
    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;

    /**
     * SampleClass constructor.
     *
     * @param EventDispatcher $eventDispatcher
     */
    public function __construct(EventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }
    
    public function doSomething(): void
    {
        $event = new SomeEvent();
        $this->eventDispatcher->dispatch($event);
    }
}
```

!!! Notice "Notice"
    This example expects you to use the [Service Provider] to register your classes to the [Application Core].
    If your are using the legacy architecture, you need to fetch this service using the [Legacy DI Container].


## Handling an event

To handle an event you need to register your event handler, which will then be executed after the specific
event has been dispatched. Therefore, you have two ways of doing so.


### Register event handler by defining a specific module class

The shop software can identify modules by specific module classes (more information can be found in the tutorial about
[configuring a module]). This module class needs to implement an `EventListeners` method, which provides an array that
maps the event handlers to their events.

The system that reads all module classes will then automatically register your event handlers.

The following example shows the implementation of such a module class:

```php
namespace GXModules\<Vendor>\<Module>;

use Gambio\Core\Application\Modules\AbstractModule;
use GXModules\<Vendor>\<Module>\EventListeners\SomeEventListener;
use GXModules\<Vendor>\<Module>\Events\SampleEvent;

/**
 * Class SampleModule
 * @package GXModules\<Vendor>\<Module>
 */
class SampleModule extends AbstractModule
{
    /**
     * @inheritDoc
     */
    public function eventListeners(): array
    {
        return [
            SomeEvent::class => [
                SomeEventListener::class,
            ]
        ];
    }
}
```


### Service Provider registration

Alternatively, it's also possible to use a bootable Service Provider to register your event handler.

The following example shows how to do this:

```php
namespace GXModules\<Vendor>\<Module>;

use Gambio\Core\Application\DependencyInjection\AbstractModuleBootableServiceProvider;
use GXModules\<Vendor>\<Module>\EventListeners\SomeEventListener;
use GXModules\<Vendor>\<Module>\Events\SampleEvent;

/**
 * Class MyBootableServiceProvider
 * @package GXModules\<Vendor>\<Module>
 */
class MyBootableServiceProvider extends AbstractModuleBootableServiceProvider
{
    /**
     * @inheritDoc
     */
    public function provides(): array
    {
        return [
            SomeEventListener::class,
        ];
    }

    /**
     * @inheritDoc
     */
    public function register(): void
    {
        $this->application->registerShared(SomeEventListener::class);
    }

    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        $this->application->attachEventListener(SomeEvent::class, SomeEventListener::class);
    }
}
```


## Prioritised event handlers

Additional to normal event handlers, it's possible to register prioritised event handlers. This means, that the order
in which the event handlers are executed is defined by the priority defined by each event handler.

To create a prioritised event handler your class can extend from the
`Gambio\Core\Event\Abstracts\AbstractPrioritizedEventListener` or implement the
`Gambio\Core\Event\PrioritizedEventListener` interface by itself.

```php
namespace GXModules\<Vendor>\<Module>\EventListeners;

use GXModules\<Vendor>\<Module>\Events\SampleEvent;
use Gambio\Core\Event\PrioritizedEventListener;

/**
 * Class PrioritisedSampleEventListener
 * @package GXModules\<Vendor>\<Module>\EventListeners
 */
class PrioritisedSampleEventListener implements PrioritizedEventListener
{
    /**
     * @inheritDoc
     */
    public function priority(): int
    {
        return PrioritizedEventListener::PRIORITY_VERY_HIGH; // or: return self::PRIORITY_VERY_HIGH;
    }
    
    /**
     * @param SampleEvent $event
     */
    public function __invoke(SampleEvent $event): void
    {
        // do something
    }
}
```

The registration is similar to the registration of a non-prioritised event handler:

```php
namespace GXModules\<Vendor>\<Module>;

use Gambio\Core\Application\DependencyInjection\AbstractModuleBootableServiceProvider;
use GXModules\<Vendor>\<Module>\EventListeners\PrioritisedSampleEventListener;
use GXModules\<Vendor>\<Module>\Events\SampleEvent;

/**
 * Class MyBootableServiceProvider
 * @package GXModules\<Vendor>\<Module>
 */
class MyBootableServiceProvider extends AbstractModuleBootableServiceProvider
{
    ...
    
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        $this->application->attachPrioritisedEventListener(SomeEvent::class, PrioritisedSampleEventListener::class);
    }
}
```

!!! Notice "Notice"
    Please have in mind, that this is only possible by using a [Service Provider].


[Application Core]: ./../application-core.md
[PSR 14]: https://www.php-fig.org/psr/psr-14/
[Service Provider]: ./../details/service-provider.md
[Legacy DI Container]: ./../details/di-container.md#legacy-di-container
[configuring a module]: ./../../module-development/general/defining-a-module.md
