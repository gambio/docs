# Adding and managing HTTP routes

Routes can easily be created and managed by creating a `routes.php` file anywhere inside your modules directory (e.g.
`GXModules/<Vendor>/<Module>/routes.php`). The shop software will automatically determine these files and use them to
define the available HTTP routes of the application.

These `routes.php` will be included and therefore need to return a callback method. The first parameter of this
callback method must be the `Gambio\Core\Application\Routing\RouteCollector`, which is used to manage the HTTP routes.

The following example shows the content of such a `routes.php` file and how routes can be added and modified:

## Adding a GET/POST/etc. route

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


## Replace callback for an already defined route

```php
use Gambio\Core\Application\Routing\RouteCollector;
use GXModules\<Vendor>\<Module>\HTTPActions\AnotherSampleGetAction;

return static function (RouteCollector $routeCollector) {
    $routeCollector->getDefinedRoute('/admin/my-module', 'get')->setCallback(AnotherSampleGetAction::class);
};
```


## Add a middleware to a specific route

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


## Add an argument to a specific route

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


## Add a name to a specific route

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
