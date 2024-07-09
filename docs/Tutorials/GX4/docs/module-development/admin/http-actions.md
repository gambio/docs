# Creating a new HTTP action

Action classes are responsible for processing HTTP requests of specific routes. If a route has been called, the
assigned action class will be executed. Every route can only have one action class assigned.

There are abstract classes with additional functionality, from which your action class can be inherited. For example,
the `Gambio\Admin\Application\Http\AdminModuleAction` provides a `render` method to create Gambio Admin pages.  

The `handle` method provides the parameters (`\Gambio\Core\Application\Http\Request $request` and
`\Gambio\Core\Application\Http\Response $response`) to access request information and building a response.

The action class must implement the abstract method `handle`, which will be called when processing the action class
and must return a response object.

It is recommended to inject your services in actions to perform any business logic by registering the action
class using a [Service Provider].


## Examples

### Simple text response

```php
namespace GXModules/<Vendor>/<Module>;

use Gambio\Core\Application\Http\Request;
use Gambio\Core\Application\Http\Response;
use Gambio\Admin\Application\Http\AdminModuleAction;

/**
 * Class SampleAction
 * @package GXModules/<Vendor>/<Module>
 */
class SampleAction extends AdminModuleAction
{
    /**
     * Returns a text response.
     * 
     * @return Response
     */
    public function handle(Request $request, Response $response): Response
    {
        return $response->write('Hello World');
    }
}
```

### JSON response
```php
namespace GXModules/<Vendor>/<Module>;

use Gambio\Core\Application\Http\Request;
use Gambio\Core\Application\Http\Response;
use Gambio\Admin\Application\Http\AdminModuleAction;

/**
 * Class SampleAction
 * @package GXModules/<Vendor>/<Module>
 */
class SampleAction extends AdminModuleAction
{
    /**
     * Returns a JSON response.
     * 
     * @return Response
     */
    public function handle(Request $request, Response $response): Response
    {
        $data = ['hello' => 'world'];
        
        return $response->withJson($data);
    }
}
```

### Redirect
```php
namespace GXModules/<Vendor>/<Module>;

use Gambio\Core\Application\Http\Request;
use Gambio\Core\Application\Http\Response;
use Gambio\Admin\Application\Http\AdminModuleAction;

/**
 * Class SampleAction
 * @package GXModules/<Vendor>/<Module>
 */
class SampleAction extends AdminModuleAction
{
    /**
     * Does a redirect.
     * 
     * @return Response
     */
    public function handle(Request $request, Response $response): Response
    {
        $url = "{$this->url->admin()}/sample-redirect-url";
        
        return $response->withRedirect($url);
    }
}
```

### Gambio Admin page response

```php
namespace GXModules/<Vendor>/<Module>;

use Gambio\Core\Application\Http\Request;
use Gambio\Core\Application\Http\Response;
use Gambio\Admin\Application\Http\AdminModuleAction;

/**
 * Class SampleAction
 * @package GXModules/<Vendor>/<Module>
 */
class SampleAction extends AdminModuleAction
{
    /**
     * Renders a admin template.
     * 
     * @return Response
     */
    public function handle(Request $request, Response $response): Response
    {
        $pageTitle    = $this->translate('sample_module_title_text_phrase', 'sample_module_section');
        $templatePath = '/path/to/template/file.html';
        $templateData = [
            // key value pairs that are accessible in the template
            'greeting' => 'Hello World'
        ];
        $template     = $this->render($pageTitle, $templatePath, $templateData);
        
        return $response->write($template);
    }
}
```

For this example, the template file could look like this:

```html
<!-- /path/to/template/file.html -->
{extends file="layout.html"}

{block name="content"}
	<div>{$greeting}</div>
{/block}
```


[Service Provider]: ./../../framework/details/service-provider.md