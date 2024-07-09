## Service Provider


### Einführung

Service Provider sind ein wichtiger Bestandteil des Anwendungskerns und ihre Aufgabe ist es die einzelnen Service
Klassen bereitzustellen.

In der Regel definiert ein Service Provider zwei Dinge. Zum einen beinhaltet er Informationen, welche Services
vom [DI Container][ioc container] angefragt werden können und andererseits definiert er die Schnittstellen und
Abhändigkeiten der Service Klassen.

Im Shop gibt es einen [Bootstrapper][admin service providers], der alle Service Provider zum
[DI Container][ioc container] hinzufügt.


### `provides` Klassenattribut

Über das Klassenattribut `provides` wird definiert, welche Services später über den [DI Container][ioc container]
angefragt werden können. Interne Komponenten, die der Service verwendet, müssen nicht in dem `provides` Attribut
aufgelistet werden und sind von außen über den [DI Container][ioc container] nicht verfügbar. 

```php
use Vendor\MyPackage\MyService;
use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;

/**
 * Class MyServiceProvider
 * @property-read Container $container
 */
class MyServiceProvider extends AbstractServiceProvider
{
    /** @var string[]  */
    protected $provides = [MyService::class];
}
```


### `register` Methode

In der `register` Methode fügen wir den Service, sowie alle vom Service benötigten Komponenten zum 
[DI Container][ioc container] hinzu.


```php
use Doctrine\DBAL\Connection;
use League\Container\Container;
use Vendor\MyPackage\MyService;
use Vendor\MyPackage\MyServiceImplementation;
use Vendor\MyPackage\MyServiceDependency;
use League\Container\ServiceProvider\AbstractServiceProvider;

/**
 * Class MyServiceProvider
 * @property-read Container $container
 */
class MyServiceProvider extends AbstractServiceProvider
{
    /** @var string[]  */
    protected $provides = [MyService::class];

    public function register(): void
    {
        $this->container->share(MyService::class, MyServiceImplementation::class)
            ->addArgument(MyServiceDependency::class);
        
        $this->container->share(MyServiceDependency::class)
            ->addArgument(Connection::class);
    }
}
```


### Bootable

Man kann einen Service Provider auch als *Bootable* kennzeichnen, indem man ihn das `BootableServiceProviderInterface`
Interface hinzufügt. Bootable bedeutet, dass man eine weitere Methode `boot` implementieren kann, die ausgeführt wird,
sobald der Service Provider zum [DI Container][ioc container] hinzugefügt wird.

```php
use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

/**
 * Class MyServiceProvider
 * @property-read Container $container
 */
class MyServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    // ...
    
    public function boot(): void
    {
        // Dieser Abschnitt wird ausgeführt, sobald der Service Provider zum DI Container hinzugefügt wird.
    }
}
```


[ioc container]: ./ioc_container.md
[admin service providers]: ../../../src/GambioAdmin/Application/Kernel/Bootstrapper/AdminServiceProviderRegistration.php
