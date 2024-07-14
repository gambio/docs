# Creating a new HTTP controller

Before you want to create a new HTTP controller, you should understand the HTTP service. Therefore, this section will
primarily focus on the HTTP service and explain how you can write your controller for HTTP requests.

!!! Warning "Notice"
    This tutorial is based on the [legacy architecture] and isn't compatible with the new one. See
    [tutorial for the admin area].


## What is the HTTP service and what is it for? 

The HTTP service is a fundamental part of the GXEngine. The client, for example a browser, uses HTTP to interact
with a web server on which the shop is installed. The dialogue between the server and the client takes place via
well-defined messages. The client sends a so-called "request" to the Web server, which in turn replies with a response. 

In PHP the request of the client is represented by the global variables `$_GET`, `$_POST`, `$_FILE`, `$_COOKIE`,
`$_SESSION`. The response message is generated with functions like `echo` or `header`. 

One goal of the HTTP service is to replace the global PHP variables and functions with an object-oriented layer. The
front controllers of the shop `admin/admin.php` or `shop.php` use the service to control which `HTTPViewController`
child classes are to be used for the current request. They in turn generate the response message for the client.
This means that the same script is used for each request at a central point in the software. New pages can easily be
created using an `HttpViewController` and a template file defined in the controller.


## What is a front controller?

The front controller is a central script that receives all client requests and delegates them to a specific controller
(`HttpViewController`). Generic tasks, which have to be done at each page request, are executed before the delegation. 

In the shop two scripts, acting as entry points for the HTTP, request handling.

- **Frontend**: `shop.php`
- **Gambio Admin**: `admin/admin.php`

For the controller to delegate to an `HttpViewController`, the script has to be called with the `$_GET` parameters `do`.

- `shop.php?do=NewFrontendModule`: Delegation to `NewFrontendModuleController`
- `admin/admin.php?do=NewBackendModule`: Delegation to `NewBackendModuleController`

The `HttpViewControllers` have different action methods (see next section for details). The `actionDefault` method
exists in every controller and every action method has to return a response object.

Imagine the `NewBackendModuleController` has an action method called `actionInstall`, to which you want to delegate.
The requested URL has to look like this:

- `admin/admin.php?do=NewBackendModule/Install`: Delegation to the method `NewBackendModuleController::actionInstall`

The value of the `$_GET` parameter with the key `do` after the slash specifies the action method. Additional `$_GET`
parameters can be added as usual (e.g. `admin/admin.php?do=NewBackendModule/Install&module=moduleToInstall`).


## What is the HttpViewController and what is it for?

All controller classes that can be accessed through the frontend entry points inherit from the `HttpViewController`
class. It provides some auxiliary methods to access the request variables and the possibility to define and render
a template file.

Each `HttpViewController` has so-called `action` methods, which further specify the control of the request. They
return instances of objects that implement the `HttpControllerResponseInterface` *(the response message)* . The
response instances are automatically further processed by the HTTP service and transmitted to the client (browser).
Action methods can be controlled by the front controller, as described above. They have to be defined as `public`,
have an `action` prefix in the method name and return an object of type `HttpControllerResponseInterface`. If no
action method is specified in the `do` parameter, the `actionDefault` method is executed. 

We take the following request URL as an example: `shop.php?do=NewFrontendModule/Install`. The corresponding
`HttpViewController` should be structured as follows.

```php
// Request URL: shop.php?do=NewFrontendModule/Install
class NewFrontendModuleController extends HttpViewController
{
	public function actionInstall()
	{
		// Execute business logic here!
		
		return new HttpControllerResponse('Hello World!');
	}
}
```

Depending on whether the requests are delegated by the entry point of the frontend or Gambio Admin, the
`HttpViewController` class has to inherit from another parent class.

- **Frontend**: `HttpViewController`
- **Gambio Admin**: `AdminHttpViewController`

The `AdminHttpViewController` ensures that only a logged-in user with admin privileges can view these pages. 


### HttpViewController `protected` helper

- `_callActionMethod`: Calls an internally available action method.
- `_render`: Renders the passed template file *(1st argument)* and sets the template variables *(2nd argument)*.
- `_getQueryParametersCollection`: Returns a collection class containing all values of the global `$_GET` variable.
- `_getPostDataCollection`: Returns a collection class containing all values of the global `$_POST` variable.
- `_getQueryParameter`: Return a contained value from `$_GET`.
- `_getPostData`: Return a contained value from `$_POST`.
- `_validatePageToken`: Checks the page token and generates an exception if it is not valid.


### Valid return values of the action methods

All action methods have to return objects of type `HttpControllerResponseInterface`! List of objects that implement
the `HttpControllerResponseInterface`:

- `HttpControllerResponse`: Response object for pages in the frontend.
- `AdminPageHttpControllerResponse`: Response object for pages in the Gambio Admin.
- `AdminLayoutHttpControllerResponse`: Response object for **new pages** in Gambio Admin.
- `RedirectHttpControllerResponse`: Response object for forwarding.
- `JsonHttpControllerResponse`: Response object for JSON (for example for Ajax requests).


### Working with template files

The method `_render($templateFile, $keyValuePairs)` returns a rendered template. The first parameter specifies the
path to the template file. The second parameter has to be an associative array, where the key is the variable name of
the template and the value is the value to be output. The path to the template file must be relative to the template
directory of the ContentView. The template directory can be changed within the controller:

`$this->contentView->set_template_dir('/absolute/path/to/new/template/directory');`

The return value of the `_render` method can afterwards simply be passed to the response object as a second parameter,
e.g.:

```php
return new AdminPageHttpControllerResponse(
	'Page Title', 
	$this->_render('template_file.html', array('templateVariable', 'templateValue'))
);
```


### Determination of controller classes

Controller classes that inherit from the `HttpViewController` class will automatically be recognized and registered
by the system. The system determines controllers inside the following directories: 

- `GXEngine`
- `GXMainComponents`
- `GXModules`


## Summary

- Entry points:
    - **Frontend**: `shop.php`
    - **Gambio Admin**: `admin/admin.php`
- Creating a new controller class
 	- Class has to contain `Controller` as a suffix in the class name.
 	- Class has to inherit from `HttpViewController`. If delegated by Gambio Admin Entry point has to inherit from
 	  `AdminHttpViewController`.
- If required, add more action methods and develop the corresponding template file.
- Empty the cache: For the MainFactory to find the new controller class, the class registry cache has to be cleared.


### Common sources of error

- Class registry cache not cleared
- New controller does not inherit from `HttpViewController` or `AdminHttpViewController`
- Non-existent action method
- Incorrect return value of the executed action method
- Template directory in `ContentView` set incorrectly


### Sample controller

You can find sample controllers with instructions on how to use them [here](./../_samples/sample-controllers.zip).



[legacy architecture]: ./../../framework/legacy-architecture.md
[tutorial for the admin area]: ./../admin/http-actions.md
