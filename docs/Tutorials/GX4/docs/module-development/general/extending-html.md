# Extending existing HTML

No matter whether you want to extend the HTML in the public store or admin area, you need to use the Smarty block
system. Smarty blocks are spread around all the HTML templates and allow you to add content before or after a block
as well as replacing a block entirely.


## Smarty blocks

With Smarty 3 it has become possible to realize inheritance. This makes it possible to transfer content from a basic
HTML file to one or more child HTML files.

There are different procedures for this. On the one hand, it is possible to work with the Smarty function `{extends}`,
which allows extending a specific HTML file by several areas. On the other hand, the `{block}` element can also be
extended by the attributes `append` or `prepend`.

This tutorial will explain how you can use these functions to extend HTML files. 


### The `block` tag

A Smarty block is always identified by the `{block}` tag. It indicates an area that you can extend or replace. To
specifically overwrite or extend a particular block it needs a name. You can assign this name as follows:

```html
{block name="example-block"}{/block}
```


### General working with blocks

First we define a basic HTML file `basic.html`, in which we can overwrite or extend content as we like. This could
look like this:

```html
{block name="example-block"}
    <div class="example-content">
        {block name="example-block-text"}
            <p>Some random text.</p>
        {/block}
    </div>
{/block}
```

If you want to extend or overwrite this content you need a child HTML file, which inherits from your base HTML file
`basic.html`. The content of the child HTML file could look like this:

```html
{extends file="basic.html"}

{block name="example-block"}
    <h1>Overridden Content</h1>
{/block}
```

The example above would result in replacing the `div` block of the base HTML file with an `h1` heading. However, if
you only want to add content before or after the actual content, it is recommended to use the `append` or `prepend`
attributes.

__Add content before the block:__

```html
{extends file="basic.html"}

{block name="example-block" prepend}
    <h1>New Headline</h1>
{/block}
```

__Add content after the block:__

```html
{extends file="basic.html"}

{block name="example-block" append}
    <div class="new-content">
        Some new Content
    </div>
{/block}
```


## Usage in the shop software

How you extend a template file in the shop depends on which template you want to extend. In general, you need to create
a new HTML file inside your module directory (e.g. `GXModules/<Vendor>/<Module>`), but the specific path of the
template you want to extend determines the specific path of the HTML file you need to create inside your modules
directory.

The following overview lists all possible template paths as well as the corresponding path of the HTML file you need to
create:


### Extending a theme template
**Template path:**  
`themes/<ThemeName>/<PathToTemplate>/<TemplateName>.html`

**GXModule path:**  
`GXModules/<Vendor>/<Module>/Shop/Themes/<ThemeName>/<PathToTemplate>/<TemplateName>.html`
                       
**Example:**  
`themes/Honeygrid/html/system/index.html` &#10145;
`GXModules/<Vendor>/<Module>/Shop/Themes/html/system/index.html`


### Extending a new admin module template
**Template path:**  
`GambioAdmin/Modules/<AdminModuleName>/ui/<PathToTemplate>/<TemplateName>.html`

**GXModule path:**  
`GXModules/<Vendor>/<Module>/Admin/Html/<AdminModuleName>/ui/<PathToTemplate>/<TemplateName>.html`
                       
**Example:**  
`GambioAdmin/Modules/Dashboard/ui/dashboard.html` &#10145;
`GXModules/<Vendor>/<Module>/Admin/Html/Dashboard/ui/dashboard.html`


### Extending a new admin layout template
**Template path:**  
`GambioAdmin/Layout/ui/template/<PathToTemplate>/<TemplateName>.html`

**GXModule path:**  
`GXModules/<Vendor>/<Module>/Admin/Html/Layout/<PathToTemplate>/<TemplateName>.html`
                       
**Example:**  
`GambioAdmin/Layout/ui/template/header/index.html` &#10145;
`GXModules/<Vendor>/<Module>/Admin/Html/Layout/header/index.html`


### Extending an old admin template (will surely be deprecated in some future version)
**Template path:**  
`admin/html/content/<PathToTemplate>/<TemplateName>.html`

**GXModule path:**  
`GXModules/<Vendor>/<Module>/Admin/Html/<PathToTemplate>/<TemplateName>.html`
                       
**Example:**  
`admin/html/content/quick_edit/overview.html` &#10145;
`GXModules/<Vendor>/<Module>/Admin/Html/quick_edit/overview.html`

!!! Warning "Note"
    This will surely be deprecated in some future version, because with the refactoring of the Gambio Admin we are
    going to use the `GambioAdmin/Modules` directory. Please use the new admin module template files if possible.


### Extending an old template set template
**Template path:**  
`templates/<TemplateSet>/<PathToTemplate>/<TemplateName>.html`

**GXModule path:**  
`GXModules/<Vendor>/<Module>/Shop/Templates/<TemplateSet>/<PathToTemplate>/<TemplateName>.html`
                       
**Example:**  
`templates/Honeygrid/module/product_info/standard.html` &#10145;
`GXModules/<Vendor>/<Module>/Shop/Templates/Honeygrid/module/product_info/standard.html`

!!! Warning "Note"
    This will surely be deprecated in some future version, because the old template sets will be removed at some
    point. Please use themes instead.
