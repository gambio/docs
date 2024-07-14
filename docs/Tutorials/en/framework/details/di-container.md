# Dependency Injection Container

The [Application Core] (complete namespace `Gambio\Core\Application\Application`) acts as a dependency injection
container (DI container, or sometimes Dependency Container) and therefore one of its tasks is to provide all
components and services. From a technical point of view this corresponds to the implementation of an *Inversion of
Control Container* (IoC Container for short) and follows the PHP standard *PSR-11*.

The following sections explain the terms *Dependency Injection*, *Inversion* and *Inversion of control containers*
and their use in development.

__What is an *Inversion of Control Container*?__

The [SOLID Principles]{target=_blank} are rules that should lead to a good
object-oriented design. The fifth principle (Dependency Inversion Principle) deals with the topic *Dependency
Injection* and the reduction of couplings between classes and objects.


## Dependency Injection

*Dependency Injection* means that constructors and methods of classes *never* directly instantiate new classes but
the dependencies of the respective classes will be defined and passed to them as function parameters.

__Wrong:__

```php
class MyClass
{
    private $dependency;

    public function __construct() 
    {
        // Here is the mistake! "Dependency" should be provided as a parameter and new be created with "new".
        $this->dependency = new Dependency();
    }

    public function method(): void
    {
        // Same mistake as above.
        $otherDependency = new OtherDependency();
        
        $this->dependency->doSomething($otherDependency);
    }

    ...
}
```

__Correct:__

```php
class MyClass
{
    private $dependency;

    // The dependency is provided as a parameter and initialed as a class attribute.
    public function __construct(Dependency $dependency) 
    {
        $this->dependency = $dependency;
    }

    // The dependency is also provided as a parameter but because it will only be used in this method it's not
    // initialed as a class attribute.
    public function method(OtherDependency $otherDependency): void
    {
        $this->dependency->doSomething($otherDependency);
    }
    
    ...
}
```

This makes it much easier to create *Unit Tests* for these classes, which significantly reduces the error-proneness
of the system. But why does following the Dependency Injection pattern make it easier to write unit tests?

In unit tests, dependencies can easily be *faked*. This means that instead of passing an object to the concrete class,
you pass a so-called *dummy* object that fulfills the requirements of the method signatures (so that PHP does not
trigger an error). The test then only checks the interaction between the class under test and the dependency.

Another advantage of the design pattern is that it significantly reduces the codes complexity. Classes generally
depend on other classes. In the example above neither `Dependency` nor `OtherDependency` had a constructor
parameter. But this is rarely the case because a lot of classes usually have additional dependencies, which
`MyClass' would have to know.

With the *Dependency Injection Principle*, the dependency is defined in the constructor or a method and can then
interact with it in the code. The dependencies of this class can be recognized directly from methods (unlike the
example with `MyClass`)  or the method signature of the constructor. The objects are usually created and passed
externally in factory classes.

The Dependency Injection design pattern makes it much easier to comply with the first SOLID principle (Single
Responsibility). The advantages mentioned above are a nice side effect.


## Dependency Inversion

Dependency Injection and Inversion can easily be confused by the wording. *Dependency Inversion* means that abstract
classes or even better interfaces are used to define dependencies rather than concrete classes. This reduces the
coupling between classes even further and makes it easier to exchange implementations.

## Inversion of control container

Now we know what the terms *Dependency Injection* and *Inversion* mean. But what is the *Inversion of Control
container*?

The task of the IoC container is to provide all service classes, whereas the task of the shop system is to answer
incoming HTTP requests using these service classes.

Answering incoming HTTP requests works, roughly speaking, by assigning a function to a URL. A controller class for
example, can provide several of these functions in the form of methods. Another mechanism recognizes the URL of the
incoming HTTP request and then executes the desired function.

In the best case, one or more service classes have now been injected into the controller via the constructor. Therefor
all of the Clean Code principles are adhered and we can now use the service to execute complex functionalities.

This is where the *Inversion of control container* or our `Application` class comes in. Its task is to provide all
services for the shop system.

When the shop application initializes, all *Service Providers* are loaded. Within the *Service Provider* several
dependencies of the service will be defined. Only when a particular service has been requested by the container, it
starts the initialization for this service and returns it.


## Legacy DI Container

To ensure that the new core components and services can not only be used via the new [Application Core], we have
provided an interface in the form of an additional *DI Container* (similar to the `Application` class).

The class `LegacyDependencyContainer` can be called globally in the old application kernel and serves as
[Service Locator]{target=_blank}.

If you now want to request e.g. the new `ConfigurationService` by using the `LegacyDependencyContainer`, this could be
done like this:

```php
// Imaging this code belongs to the file
// GXModules/Vendor/Library/Shop/Overloads/BestsellerBoxContentView/MyBestsellerBoxOverload.php

use Gambio\Admin\Configuration\ConfigurationService;

class MyBestsellerBoxOverload extends MyBestsellerBoxOverload_parent
{
    public function prepare_data()
    {
        parent::prepare_data();
        $service = LegacyDependencyContainer::getInstance()->get(ConfigurationService::class);

        // now you can use the configuration service
    }
}
```



[Application Core]: ./../application-core.md
[Service Locator]: https://de.wikipedia.org/wiki/Service-Locator
[SOLID Principles]: https://de.wikipedia.org/wiki/Solid_(Software)
