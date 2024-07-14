# Option

An option represents a specific trait that can be assigned to product like *size*, *color*, *as a gift*, *pattern*,
and so on. An option always provides a number of option values which specifies the trait, for instance the size *XL*
or color *red*.

Functional it can be compared as a combination of the old attribute and property system. So that it's now easier to
manage them in a single place and as a single entity (or construct).


## Option domain

The option domain provides management functionality (create, read, update and delete), as well as the
possibility to filter all existing options. It's important to know that the option values are referenced by the other
domains like *product options* or *product variants*, therefore, it's not possible to delete option or option values
that are used in these domains.


## Aggregate root and domain model

The aggregate root `Gambio\Admin\Modules\Option\Model\Option` encapsulates general information like a sort order and
type, as well as language-dependent details like a label, admin label, or description. Furthermore, each option may
have several option values, which contain product-specific information (model number, weight, price, ...) and
language-dependent details like the option itself.

After creation, the aggregate root provides the possibility to change the attributes of the option itself, as well as,
adding, updating or removing option values.


### Use cases using read service


#### Fetching all or a specific option

```php
/** $readService \Gambio\Admin\Modules\Option\Services\OptionReadService **/

$allOptions     = $readService->getAllOptions();
$specificOption = $readService->getOptionById($optionId = 1);
```


### Use cases using write service


#### Creating a new option

```php
use Gambio\Admin\Modules\Option\Model\ValueObjects\OptionType;

/** $writeService \Gambio\Admin\Modules\Option\Services\OptionWriteService **/
/** $factory \Gambio\Admin\Modules\Option\Services\OptionFactory **/

$details = [
    $factory->createOptionDetail('en', 'label - en', 'admin label - en', 'description - en'),
    $factory->createOptionDetail('de', 'label - de', 'admin label - de', 'description - de'),
];
$optionDetails = $factory->createOptionDetails(...$details);

$id = $writeService->createOption(
    $optionDetails, $optionValues = [], $optionType = OptionType::DROPDOWN_TYPE, $optionSortOrder = 1
);
```

!!! note "Note"
    In this example, we don't add option values to keep this sample shorter. To know which content the `$optionValues`
    variable would have needed, see the *Adding new option values to an option* use case.


#### Creating multiple options at once

```php
use Gambio\Admin\Modules\Option\Model\ValueObjects\OptionType;

/** $writeService \Gambio\Admin\Modules\Option\Services\OptionWriteService **/
/** $factory \Gambio\Admin\Modules\Option\Services\OptionFactory **/

$details = [
    'first-option'  => [
        $factory->createOptionDetail('en', 'label 1 - en', 'admin label 1 - en', 'description 1 - en'),
        $factory->createOptionDetail('de', 'label 1 - de', 'admin label 1 - de', 'description 1 - de'),
    ],
    'second-option' => [
        $factory->createOptionDetail('en', 'label 2 - en', 'admin label 2 - en', 'description 2 - en'),
        $factory->createOptionDetail('de', 'label 2 - de', 'admin label 2 - de', 'description 2 - de'),
    ]
];

$optionDetails   = [
    'first-option'  => $factory->createOptionDetails(...$details),
    'second-option' => $factory->createOptionDetails(...$details),
];
$optionValues = [];
$optionTypes   = [
    'first-option'  => OptionType::DROPDOWN_TYPE,
    'second-option' => OptionType::IMAGE_TYPE,
];
$optionSortOrders   = [
    'first-option'  => 1,
    'second-option' => 2,
];

$creationArgs = [
    [$optionDetails['first-option'], $optionValues, $optionTypes['first-option'], $optionSortOrders['first-option']],
    [$optionDetails['second-option'], $optionValues, $optionTypes['second-option'], $optionSortOrders['second-option']],
];

$ids = $writeService->createOptions(...$creationArgs);
```


#### Updating the options details
```php
use Gambio\Admin\Modules\Option\Model\ValueObjects\OptionType;

/** $readService \Gambio\Admin\Modules\Option\Services\OptionReadService **/
/** $writeService \Gambio\Admin\Modules\Option\Services\OptionWriteService **/
/** $factory \Gambio\Admin\Modules\Option\Services\OptionFactory **/

$details = [
    $factory->createOptionDetail('en', 'new label - en', 'new admin label - en', 'new description - en'),
    $factory->createOptionDetail('de', 'new label - de', 'new admin label - de', 'new description - de'),
];
$optionDetails = $factory->createOptionDetails(...$details);

$option = $readService->getOptionById($optionId = 1);
$option->changeDetails($optionDetails);

$writeService->storeOptions($option);
```


#### Updating the options type
```php
use Gambio\Admin\Modules\Option\Model\ValueObjects\OptionType;

/** $readService \Gambio\Admin\Modules\Option\Services\OptionReadService **/
/** $writeService \Gambio\Admin\Modules\Option\Services\OptionWriteService **/
/** $factory \Gambio\Admin\Modules\Option\Services\OptionFactory **/

$newType = OptionType::TEXT_TYPE;

$option = $readService->getOptionById($optionId = 1);
$option->changeType($factory->createOptionType($newType = OptionType::TEXT_TYPE));

$writeService->storeOptions($option);
```


#### Updating the options sort order
```php
/** $readService \Gambio\Admin\Modules\Option\Services\OptionReadService **/
/** $writeService \Gambio\Admin\Modules\Option\Services\OptionWriteService **/

$option = $readService->getOptionById($optionId = 1);
$option->changeSortOrder($newSortOrder = 1);

$writeService->storeOptions($option);
```


#### Adding a (option) value to an option
```php
use Gambio\Admin\Modules\Option\Model\ValueObjects\OptionValueStock;

/** $readService \Gambio\Admin\Modules\Option\Services\OptionReadService **/
/** $writeService \Gambio\Admin\Modules\Option\Services\OptionWriteService **/
/** $factory \Gambio\Admin\Modules\Option\Services\OptionFactory **/

$details = [
    'first-option-value'  => [
        $factory->createOptionValueDetails('en', 'label 1 - en', 'description 1 - en'),
        $factory->createOptionValueDetails('de', 'label 1 - de', 'description 1 - de'),
    ],
    'second-option-value' => [
        $factory->createOptionValueDetails('en', 'label 2 - en', 'description 2 - en'),
        $factory->createOptionValueDetails('de', 'label 2 - de', 'description 2 - de'),
    ],
];
$optionValuesProductDetails = [
    'first-option-value' => $factory->createOptionValuesProductDetails($details['first-option-value']),
    'second-option-value' => $factory->createOptionValuesProductDetails($details['second-option-value']),
];
$optionValuesStocks = [
    'first-option-value' => $factory->createOptionValueStock(OptionValueStock::POSITIVE_STOCK_TYPE, 1, true),
    'second-option-value' => $factory->createOptionValueStock(OptionValueStock::NOT_MANAGED_STOCK_TYPE, 0, false),
];
$optionValuesSortOrders = [
    'first-option-value' => 1,
    'second-option-value' => 2,
];
$optionValuesImages = [
    'first-option-value' => '/var/www/.../option-value-1-image.png',
    'second-option-value' => '/var/www/.../option-value-2-image.png',
];

$newOptionValues = [
    $factory->createNewOptionValue(
        $optionValuesProductDetails['first-option-value'], $optionValuesStocks['first-option-value'],
        $optionValuesSortOrders['first-option-value'], $optionValuesImages['first-option-value']
    ),
    $factory->createNewOptionValue(
        $optionValuesProductDetails['second-option-value'], $optionValuesStocks['second-option-value'],
        $optionValuesSortOrders['second-option-value'], $optionValuesImages['second-option-value']
    ),
];

$option = $readService->getOptionById($optionId = 1);
$option->addNewValues(...$newOptionValues);

$writeService->storeOptions($option);
```


#### Updating a (option) value of an option
```php
/** $readService \Gambio\Admin\Modules\Option\Services\OptionReadService **/
/** $writeService \Gambio\Admin\Modules\Option\Services\OptionWriteService **/
/** $factory \Gambio\Admin\Modules\Option\Services\OptionFactory **/

$option      = $readService->getOptionById($optionId = 1);
$optionValue = $option->values()->getOptionValueById($optionValueId = 1);

if($optionValue !== null){
    $optionValue = $optionValue->withSortOrder($newSortOrder = 42);
    $option->changeValues($optionValue);
    $writeService->storeOptions($option);
}
```


#### Removing a (option) value from an option
```php
/** $readService \Gambio\Admin\Modules\Option\Services\OptionReadService **/
/** $writeService \Gambio\Admin\Modules\Option\Services\OptionWriteService **/
/** $factory \Gambio\Admin\Modules\Option\Services\OptionFactory **/

$option = $readService->getOptionById($optionId = 1);
$option->removeValues($factory->createOptionValueId($optionValueId = 1));

$writeService->storeOptions($option);
```


#### Deleting an option
```php
/** $writeService \Gambio\Admin\Modules\Option\Services\OptionWriteService **/

$optionIds = [1, 2];

$writeService->deleteOptions(...$optionIds);
```


### Use cases using filter service


#### Filter all existing options including sorting and pagination

```php
use Gambio\Admin\Modules\Option\Model\ValueObjects\OptionType;

/** $filterService \Gambio\Admin\Modules\Option\Services\OptionFilterService **/

$filters = [
    'type' => OptionType::IMAGE_TYPE, // Options with image type
    'values.stock' => '>10',          // and a stock above 10 units.
];
$sorting = '-details.adminLabel'; // In descending order of admin label

$filteredOptions             = $filterService->filterOptions($filters, $sorting, $limit = 25, $offset = 0);
$totalCountOfFilteredOptions = $filterService->getOptionsTotalCount($filters);
```


##### Filtering

The filter array that is given to the filter service maps the attributes of the option and the filtering term.
The assigned string (e.g. `get|2020-01-01`) always contains the comparison value, but it also may contain an
operation (e.g. `gte` for greater than or equals to). Leaving the operation (e.g. `2020-01-01`) will be the same
as using *equals to* (`eq`).

The following table shows all attributes and the operations that can be used on them.

|   | like (`*`) | equals to (`eq`) | lower than (`lt`) | lower than or equals to (`lte`) | greater than (`gt`) | greater than or equals to (`gte`) |
|---|:---:|:---:|:---:|:---:|:---:|:---:|
| `id`                           |   | X | X | X | X | X |
| `type`                         | X | X |   |   |   |   |
| `sortOrder`                    |   | X | X | X | X | X |
| `details.languageCode`         | X | X |   |   |   |   |
| `details.label`                | X | X |   |   |   |   |
| `details.adminLabel`           | X | X |   |   |   |   |
| `details.description`          | X | X |   |   |   |   |
| `values.id`                    |   | X | X | X | X | X |
| `values.sortOrder`             | X | X |   |   |   |   |
| `values.image`                 | X | X |   |   |   |   |
| `values.modelNumber`           | X | X |   |   |   |   |
| `values.weight`                |   | X | X | X | X | X |
| `values.price`                 |   | X | X | X | X | X |
| `values.stockType`             | X | X |   |   |   |   |
| `values.stock`                 |   | X | X | X | X | X |
| `values.stockCentrallyManaged` |   | X | X | X | X | X |
| `values.details.languageCode`  | X | X |   |   |   |   |
| `values.details.label`         | X | X |   |   |   |   |
| `values.details.description`   | X | X |   |   |   |   |


##### Sorting

To change the sorting, you can provide a string that describes the sorting order. The string must contain the
attributes used for sorting. If there is a minus (`-`) in front of the attribute, it will be sorted in descending
order. You can use multiple attributes to change the sorting order by linking them with a comma (`,`).


## Business rules

- The name of an option value must be uniq for an option.
- The `weightType` determine if the weight is added to the product weight or replaces it.
- The `priceType` determine if the price is added to the product price or replaces it.
- The `stockType` determines the behavior for the stock management. Three options are available here:
  - `only-positive`: Only positive values are allowed as stock, including zero.
  - `all-numbers`: All numbers are allowed as stock.
  - `not-managed`: The stock is not actively managed, which means that this value is not considered for the determination of the current stock.
- The `stockCentrallyManaged` determines if the stock of product option values is manageable. If this flag is active,
  then the stock of this option value will be managed centrally by itself.


## Domain events

| Event | Description |
| ----- | ----------- |
| `Gambio\Admin\Modules\Option\Model\Events\NewOptionValueAdded`     | Will be raised if a new option value has been added to an option. |
| `Gambio\Admin\Modules\Option\Model\Events\OptionCreated`           | Will be raised if a new option has been created. |
| `Gambio\Admin\Modules\Option\Model\Events\OptionDeleted`           | Will be raised if an option has been deleted. |
| `Gambio\Admin\Modules\Option\Model\Events\OptionDetailsUpdated`    | Will be raised if the details of an option has been updated. |
| `Gambio\Admin\Modules\Option\Model\Events\OptionsSortOrderUpdated` | Will be raised if the sorting order of an option has been updated. |
| `Gambio\Admin\Modules\Option\Model\Events\OptionsTypeUpdated`      | Will be raised if the type of an option has been updated. |
| `Gambio\Admin\Modules\Option\Model\Events\OptionValueAdded`        | Will be raised if an option value has been added to an option. |
| `Gambio\Admin\Modules\Option\Model\Events\OptionValueDeleted`      | Will be raised if an option value has been removed from an option. |
| `Gambio\Admin\Modules\Option\Model\Events\OptionValueUpdated`      | Will be raised if an option value of an option has been updated. |