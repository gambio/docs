# Gambio Admin - Entrypoint

## Introduction

When developing frontend code for the gambio admin, we use TypeScript as programming language and webpack for the build
process.

## Create an entrypoint

To create a new frontend entrypoint for the gambio admin, it is required to create a TypeScript file following this
convention: `src/GambioAdmin/Modules/<ModuleName>/ui/assets/index.ts`.  
The build process produces a javascript file in the build directory: `src/GambioAdmin/build/<module_name>.js`.

#### TLDR:

`src/GambioAdmin/Modules/<ModuleName>/ui/assets/index.ts` => `src/GambioAdmin/build/<module_name>.js`

## Integrate entrypoint in HTML

### Abstract VuePageAction

The easiest way to integrate the new entrypoint is by extending from the
abstract `Gambio\Admin\Application\Http\VuePageAction` and implementing the `::jsEntrypoint` method. The method should
return `<module_name>` from the `src/GambioAdmin/build/` directory. As a result, the render method takes care to
integrate the script tag with the defined entrypoint.

When using the `VuePageAction` and being in development mode, the frontend development mode can be enabled using the
most left icon on the gambio admin header bar (![DevModeIcon](./_assets/dev-mode-icon.png)). This results in loading the
frontend assets from a local webpack-dev-server. To start the webpack-dev-server, run `yarn next:dev`.

#### Example

```php
use Gambio\Admin\Application\Http\VuePageAction;
use Gambio\Core\Application\Http\Request;
use Gambio\Core\Application\Http\Response;

class MyAction extends VuePageAction
{
    public function handle(Request $request,Response $response) : Response
    {
        $template = $this->render('My Page', 'path/to/template');
        
        return $response->write($template);
    }


    public function jsEntrypoint() : string
    {
        return '<module_name>';
    }
}
```

### HTML Template Script-Tag

Another way to integrate the entrypoint is by using a script tag in the page template. When overwriting the right
template block, it is very easy and flexible way to integrate the entrypoint.

> Note: This will load the frontend assets exactly as defined. If you want to utilize the webpack-dev-server, 
> please refer to `src/GambioAdmin/Layout/ui/template/scripts.html` for a proper template setup.

#### Example

```smarty
{extends file="layout.html"}

{* Other smarty block definitions *}

{block name="custom_scripts"}
    {$smarty.block.parent}
    <script type="text/javascript" src="{$baseUrl}/GambioAdmin/build/<my_module>.js"></script>
{/block}

```
