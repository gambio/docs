# Routing

For managing routes the `Gambio\Core\Application\Routing\RouteCollector` will be used. This component is not directly
available through the [DI Container] but will be given as function argument in callback methods that define routes.
More about how to define routes can be found in the [Adding and managing HTTP routes] tutorial.

Another component, which is available through the [DI Container], is the `Gambio\Core\Application\Routing\RouteParser`
which can be used to generate URLs for specific routes.


### Route Collector

The following examples shows the usage of the available method this component provides.


#### Adding a GET/POST/etc. route

```php
use Gambio\Core\Application\Routing\RouteCollector;
use GXModules\<Vendor>\<Module>\HttpActions\SampleGetAction;
use GXModules\<Vendor>\<Module>\HttpActions\SamplePostAction;

return static function (RouteCollector $routeCollector) {
    $routeCollector->get('/admin/my-module', SampleGetAction::class);
    $routeCollector->post('/admin/my-module', SamplePostAction::class);
    // ... similar for PUT, PATCH, DELETE and OPTION
};
```


#### Replace callback for an already defined route

```php
use Gambio\Core\Application\Routing\RouteCollector;
use GXModules\<Vendor>\<Module>\HTTPActions\AnotherSampleGetAction;

return static function (RouteCollector $routeCollector) {
    $routeCollector->getDefinedRoute('/admin/my-module', 'get')->setCallback(AnotherSampleGetAction::class);
};
```


#### Add a middleware to a specific route

```php
use Gambio\Core\Application\Routing\RouteCollector;
use GXModules\<Vendor>\<Module>\HttpActions\SampleGetAction;
use GXModules\<Vendor>\<Module>\HttpActions\SamplePostAction;
use GXModules\<Vendor>\<Module>\HttpMiddlewares\SampleGetMiddleware;
use GXModules\<Vendor>\<Module>\HttpMiddlewares\SamplePostMiddleware;

return static function (RouteCollector $routeCollector) {
    $routeCollector->get('/admin/my-module', SampleGetAction::class)->addMiddleware(SampleGetMiddleware::class);
    $routeCollector->post('/admin/my-module', SamplePostAction::class);
    
    // If route has been already defined 
    $routeCollector->getDefinedRoute('/admin/my-module', 'post')->addMiddleware(SampleGetMiddleware::class);
};
```


#### Add an argument to a specific route

```php
use Gambio\Core\Application\Routing\RouteCollector;
use GXModules\<Vendor>\<Module>\HttpActions\SampleGetAction;
use GXModules\<Vendor>\<Module>\HttpActions\SamplePostAction;

return static function (RouteCollector $routeCollector) {
    $sampleArgumentName = 'argumentName';
    $sampleArgumentValue = 'argumentValue';

    $routeCollector->get('/admin/my-module', SampleGetAction::class)->addArgument($sampleArgumentName, $sampleArgumentValue);
    $routeCollector->post('/admin/my-module', SamplePostAction::class);
    
    // If route has been already defined 
    $routeCollector->getDefinedRoute('/admin/my-module', 'post')->addArgument($sampleArgumentName, $sampleArgumentValue);
};
```


#### Add a name to a specific route

```php
use Gambio\Core\Application\Routing\RouteCollector;
use GXModules\<Vendor>\<Module>\HttpActions\SampleGetAction;
use GXModules\<Vendor>\<Module>\HttpActions\SamplePostAction;

return static function (RouteCollector $routeCollector) {
    $routeCollector->get('/admin/my-module', SampleGetAction::class)->setName('my-sample-get-route');
    $routeCollector->post('/admin/my-module', SamplePostAction::class);
    
    // If route has been already defined 
    $routeCollector->getDefinedRoute('/admin/my-module', 'post')->setName('my-sample-post-route');
};
```


### Route Parser

The following example shows the usage of the `Gambio\Core\Application\Routing\RouteParser`.

```php
use Gambio\Core\Application\Routing\RouteParser;

/**
 * Class SampleClass
 */
class SampleClass
{
    /**
     * @var RouteParser
     */
    private $routeParser;
    
    
    /**
     * SampleClass constructor.
     *
     * @param RouteParser $routeParser
     */
    public function __construct(RouteParser $routeParser)
    {
        $this->routeParser = $routeParser;
    }
    
    /**
     * @return array
     */
    public function getMySampleRouteUrls(): array
    {
        $myRouteName = 'my-sample-get-route';

        return [
            'withBasePath' => $this->routeParser->urlFor($myRouteName),
            'relativeUrl'  => $this->routeParser->relativeUrlFor($myRouteName),
            'fullUrl'      => $this->routeParser->fullUrlFor($myRouteName),
        ];
    }
}
```

!!! Notice "Notice"
    This example expects you to use the [Service Provider] to register your classes to the [Application Core].
    If your are using the legacy architecture, you need to fetch this service using the [Legacy DI Container].
    


[Adding and managing HTTP routes]: ./../../module-development/admin/define-http-routes.md
[DI Container]: ./../details/di-container.md
[Application Core]: ./../application-core.md
[Service Provider]: ./../details/service-provider.md
[Legacy DI Container]: ./../details/di-container.md#legacy-di-container