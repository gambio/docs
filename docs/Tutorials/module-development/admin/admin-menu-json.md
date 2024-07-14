# Extending the Admin Menu

To extend the Admin Menu, you need to create a specific JSON file within your GXModules module directory (e.g.
`GXModules/<Vendor>/<Module>`), which defines the menu items you want to add or replace. The JSON file must end with
`.menu.json` (e.g. `SampleModuleMenuFile.menu.json`), so that shop system can find and register it.

The menu splits into groups and items. While the groups are always visible and contain the items, the items will be
hidden if the user collapses the admin menu. The schema of the menu JSON file must match the existing schema of the menu
dataset. You will find the [schema definitions] at the bottom of this tutorial.

The default admin menu is defined by the `GambioAdmin/Layout/Menu/data/GambioAdminMenu.json` file.

## Adding a new item to an existing group

To add a new item to an existing group, you have to use the same `id` attribute as in the group. Using the `sort`
attribute, you can change the sorting order of the group items.

The following example adds a new group item to the existing **orders** (`BOX_HEADING_ORDERS`) group:

```json
[
    {
        "id": "BOX_HEADING_ORDERS",
        "items": [
            {
                "sort": 15,
                "link": "<Link>",
                "title": "<SectionName>.<TextPhrase>"
            }
        ]
    }
]
```

## Adding a new group to the menu

If you want to add a new menu group, use a unique unoccupied `id`. The `sort` attribute will determine the sorting
order.

The `title` attribute is similar to some other systems and provides a text phrase reference. The shop will map this
reference into an existing text phrase and use it as the title of your group. The `title` attribute follows the
convention: `<Section>.<TextPhrase>` (e.g. `sample_language_file.sample_text_phrase`).

```json
[
    {
        "id": "<GroupId>",
        "sort": 250,
        "class": "fa <FontAwesomeClass>",
        "title": "<SectionName>.<TextPhrase>",
        "items": [
            {
                "sort": 10,
                "link": "<Link>",
                "title": "<SectionName>.<TextPhrase>"
            },
            {
                "sort": 20,
                "link": "<Link>",
                "title": "<SectionName>.<TextPhrase>"
            }
        ]
    }
]
```

> Note: You can find an overview of all FontAwesome classes on
> [their website](https://fontawesome.com/icons?d=gallery&m=free).

## Filter

Some menu items should only be displayed if a condition applies. Menu filters can be used for this purpose.

The shop system provides a few menu filters by default. To use them, you need to add an `if` attribute in the JSON. They
can be applied to menu groups and menu items. It is possible to provide an array with filter objects to the `if`
attribute to apply multiple filters.

The `filter` attribute must match the registered filter name. The `args` attribute must an array containing mixed type
elements. The args count is based on the filter implementation.

__Example:__

```json
[
    {
        "sort": 1,
        "link": "<Link>",
        "title": "<SectionName>.<TextPhrase>",
        "if": {
            "filter": "configActive",
            "args": [
                "<ConfigKey>"
            ]
        }
    },
    {
        "sort": 2,
        "link": "<Link>",
        "title": "<SectionName>.<TextPhrase>",
        "if": [
            {
                "filter": "configActive",
                "args": [
                    "<ConfigKey>"
                ]
            },
            {
                "filter": "configActive",
                "args": [
                    "<OtherConfigKey>"
                ]
            }
        ]
    }
]
```

### Core filter

- `Gambio\Admin\Layout\Menu\Filter\Types\ConfigActive`
    - **filter**: `configActive`
    - **args**: [(string $configKey)]

- `Gambio\Admin\Layout\Menu\Filter\Types\ConfigExists`
    - **filter**: `configExists`
    - **args**: [(string ...$configKeys)]

- `Gambio\Admin\Layout\Menu\Filter\Types\DisplayOldModuleCenter`
    - **filter**: `displayOldModuleCenter`
    - **args**: [()]

- `Gambio\Admin\Layout\Menu\Filter\Types\TemplateVersion`
    - **filter**: `templateVersion`
    - **args**: [(string $operator)]
    - `$operator` **must be** `>`, `>=`, `<`, `<=`, or `=`

### Custom filter

Custom filters can be implemented with the `Gambio\Admin\Layout\Menu\Filter\FilterInterface` Interface. It is possible
to inject any class which is registered in the DI-Container into the filter implementation.

The `check` method gets an instance of `Gambio\Admin\Layout\Menu\Filter\FilterConditionArguments` as argument which can
be used to access values passed in the `args` array of the menu JSON filter object.

Filters can be added to the application with a bootable [Service Provider]. The application should inflect
the `Gambio\Admin\Layout\Menu\Filter\FilterFactory::addLoader` method, passing the loader name as first argument and the
full qualified filter classname string as second argument to the inflection registration.

__Example Filter:__

```php
<?php

namespace GXModules\<Vendor>\<Module>;

use Gambio\Admin\Layout\Menu\Filter\FilterConditionArguments;
use Gambio\Admin\Layout\Menu\Filter\FilterInterface;

class ExampleFilter implements FilterInterface
{
    public function check(FilterConditionArguments $condition): bool
    {
        $args = $condition->args();
        
        return array_key_exists(0, $args) && $args[0] === true;
    }
}
```

__Example ServiceProvider integration:__

```php
<?php

namespace GXModules\<Vendor>\<Module>;

use GXModules\<Vendor>\<Module>\ExampleFilter;
use Gambio\Admin\Layout\Menu\Filter\FilterFactory;
use Gambio\Core\Application\DependencyInjection\AbstractModuleBootableServiceProvider;

class ExampleServiceProvider extends AbstractModuleBootableServiceProvider
{
    public function boot(): void
    {
        $this->application->inflect(FilterFactory::class)
            ->invokeMethod('addFilter', ['exampleFilter', ExampleFilter::class]);
    }
    
    
    public function provides(): array
    {
        // define public available DI-container definitions
        return [];
    }
    
    
    public function register(): void
    {
        // component registration code
    }
}
```

__Menu JSON:__
```json
{
    "sort": 1,
    "link": "<Link>",
    "title": "<SectionName>.<TextPhrase>",
    "if": {
        "filter": "exampleFilter",
        "args": [
            false
        ]
    }
}
```

## Caching

We cache the menu dataset to improve the performance. If you change the dataset of the menu, you need to clear the
module cache in the Gambio Admin (**Toolbox > Caches**).

### Clear menu cache

In case you need to clear the menu cache by yourself, you can use the `Gambio\Admin\Layout\Menu\AdminMenuService`
class like shown in the following example:

```php
use Gambio\Admin\Layout\Menu\AdminMenuService;

/**
 * Class SampleClass
 */
class SampleClass
{
    /**
     * @var AdminMenuService
     */
    private $adminMenuService;
    
    
    /**
     * SampleClass constructor.
     *
     * @param AdminMenuService $adminMenuService
     */
    public function __construct(AdminMenuService $adminMenuService)
    {
        $this->adminMenuService = $adminMenuService;
    }
    
    
    public function clearAdminMenuCache(): void
    {
        $this->adminMenuService->deleteMenuCache();
    }
}
```

!!! Notice "Notice"
    This example expects you to use the [Service Provider] to register your classes to the [Application Core].
    If you are using the legacy architecture, you need to fetch this service using the [Legacy DI Container].

## Admin Menu JSON schema

the following schema defines the menu dataset schema. Further down, you will find further information about the specific
attributes inside this schema.

```json
{
    "$id": "http://gambio.shop.com/admin/menu",
    "$schema": "http://json-schema.org/draft-07/schema#",
    "description": "JSON Schema for gambio admin menu",
    "type": "array",
    "items": {
        "$ref": "#/definitions/menuGroup"
    },
    "definitions": {
        "menuGroup": {
            "type": "object",
            "properties": {
                "id": {
                    "type": "string"
                },
                "title": {
                    "type": "string"
                },
                "sort": {
                    "type": "integer"
                },
                "class": {
                    "type": "string"
                },
                "type": {
                    "type": "string",
                    "enum": [
                        "standalone"
                    ]
                },
                "brand": {
                    "type": "string",
                    "enum": [
                        "alt"
                    ]
                },
                "items": {
                    "type": "array",
                    "items": {
                        "$ref": "#/definitions/menuItem"
                    }
                }
            },
            "required": [
                "id"
            ]
        },
        "menuItem": {
            "type": "object",
            "properties": {
                "title": {
                    "type": "string"
                },
                "sort": {
                    "type": "integer"
                },
                "link": {
                    "type": "string"
                },
                "link_param": {
                    "type": "string"
                }
            },
            "required": [
                "title",
                "sort",
                "link"
            ]
        }
    }
}
```

### Menu Group attributes

| Attribute | Description                                                              | Required |
|-----------|--------------------------------------------------------------------------|----------|
| `id`      | Menu Group Identifier                                                    | true     |
| `title`   | Menu Group Title                                                         | false    |
| `sort`    | Sort order                                                               | false    |
| `class`   | [FontAwesome-Icon class](https://fontawesome.com/icons?d=gallery&m=free) | false    |
| `type`    | if set to `standalone`, items will be hidden                             | false    |
| `brand`   | if set to `alt`, group will be colored in gambio yellow                  | false    |
| `items`   | Menu items of group                                                      | true     |

### Menu Item attributes

| Attribute    | Description                                    | Required |
|--------------|------------------------------------------------|----------|
| `title`      | Menu Item Title                                | true     |
| `sort`       | Sort order                                     | true     |
| `link`       | Admin page link without (`my-shop.com/admin/`) | true     |
| `link_param` | Optional link param                            | false    |

[schema definitions]: #admin-menu-json-schema

[Application Core]: ./../../framework/application-core.md

[Service Provider]: ./../../framework/details/service-provider.md

[Legacy DI Container]: ./../../framework/details/di-container.md#legacy-di-container
