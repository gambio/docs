# Product Option

A product option is a specific option together with some of its values that has been assigned to a specific product.
The customer or visitor of the shop can select one of thies linked option values. This way the customers can specify
the product they want to buy, like buying a PC with a specific CPU or the product already wrapped up in gift paper.

The product options can be combined with product variants.

Functionally this domain/system can be compared with the old product attributes. The main difference is here that it's
no longer based on the attributes.


## Product option domain

The product option domain provides management functionality (create, read, update and delete), as well as the
possibility to filter all existing options. This domain references the options and option values of the option domain.


### Aggregate root and domain model

The aggregate root `Gambio\Admin\Modules\ProductOption\Model\ProductOption` encapsulates general information like 
references for a product, option values, and an image list. As well as information about the customization of the
option value attributes, product option stock, and a sort order.

After creation, the aggregate root provides the possibility to change the attributes of the product option itself.


### Use cases using read service


#### Fetching all or a specific option

```php
/** $readService \Gambio\Admin\Modules\ProductOption\Services\ProductOptionReadService **/

$allProductOptions     = $readService->getProductOptionsByProductId($productId = 1);
$specificProductOption = $readService->getProductOptionById($optionId = 1);
```


### Use cases using write service


#### Creating a new product option

```php
use Gambio\Admin\Modules\ProductOption\Model\ValueObjects\ProductOptionStock;

/** $writeService \Gambio\Admin\Modules\ProductOption\Services\ProductOptionWriteService **/
/** $factory \Gambio\Admin\Modules\ProductOption\Services\ProductOptionFactory **/

$optionAndOptionValueId   = $factory->createOptionAndOptionValueId($optionId = 1, $optionValueId = 1);
$imageListId              = $factory->createImageListId($imageListId = 1); // Id can be null if no image list exists
$optionValueCustomization = $factory->createOptionValueCustomization(
    $modelNumber = 'abc123', $weight = 1.23, $price = 4.56
);
$productOptionStock       = $factory->createProductOptionStock(
    $stock = 0, $stockType = ProductOptionStock::STOCK_TYPE_NOT_MANAGED
);

$id = $writeService->createProductOption(
    $productId = 1, $optionAndOptionValueId, $imageListId, $optionValueCustomization,
    $productOptionStock, $sortOrder = 1
);
```


#### Creating multiple product options at once

```php
use Gambio\Admin\Modules\ProductOption\Model\ValueObjects\ProductOptionStock;

/** $writeService \Gambio\Admin\Modules\ProductOption\Services\ProductOptionWriteService **/
/** $factory \Gambio\Admin\Modules\ProductOption\Services\ProductOptionFactory **/

$productIds                = [
    'first-product-option' => 1,
    'second-product-option' => 1,
];
$optionAndOptionValueIds   = [
    'first-product-option' => $factory->createOptionAndOptionValueId(1, 1),
    'second-product-option' => $factory->createOptionAndOptionValueId(1, 2),
];
$imageListIds              = [
    'first-product-option' => $factory->createImageListId(1),
    'second-product-option' => $factory->createImageListId(null),
];
$optionValueCustomizations = [
    'first-product-option' => $factory->createOptionValueCustomization('abc123', 1.23, 4.56),
    'second-product-option' => $factory->createOptionValueCustomization('def456', 4.56, 7.89),
];
$productOptionStocks       = [
    'first-product-option' => $factory->createProductOptionStock(12, ProductOptionStock::STOCK_TYPE_ALWAYS_POSITIV),
    'second-product-option' => $factory->createProductOptionStock(-10, ProductOptionStock::STOCK_TYPE_MAY_BE_NEGATIVE),
];
$sortOrders                = [
    'first-product-option' => 1,
    'second-product-option' => 2,
];

$creationArguments = [
    [
        $productIds['first-product-option'], $optionAndOptionValueIds['first-product-option'],
        $imageListIds['first-product-option'], $optionValueCustomizations['first-product-option'],
        $productOptionStocks['first-product-option'], $sortOrders['first-product-option']
    ],
    [
        $productIds['second-product-option'], $optionAndOptionValueIds['second-product-option'],
        $imageListIds['second-product-option'], $optionValueCustomizations['second-product-option'],
        $productOptionStocks['second-product-option'], $sortOrders['second-product-option']
    ],
];

$ids = $writeService->createMultipleProductOptions(...$creationArguments);
```


#### Updating the product options image list ID
```php
/** $readService \Gambio\Admin\Modules\Option\Services\OptionReadService **/
/** $writeService \Gambio\Admin\Modules\Option\Services\OptionWriteService **/
/** $factory \Gambio\Admin\Modules\Option\Services\OptionFactory **/

$newImageListId = 2;

$productOption = $readService->getProductOptionById($productOptionId = 1);
$productOption->changeImageListId($factory->createImageListId($newImageListId));

$writeService->storeProductOptions($productOption);
```


#### Updating the product options option value customization
```php
/** $readService \Gambio\Admin\Modules\Option\Services\OptionReadService **/
/** $writeService \Gambio\Admin\Modules\Option\Services\OptionWriteService **/
/** $factory \Gambio\Admin\Modules\Option\Services\OptionFactory **/

$newOptionValueCustomization = $factory->createOptionValueCustomization(
    $modelNumber = 'abc123', $weight = 1.23, $price = 4.56
);

$productOption = $readService->getProductOptionById($productOptionId = 1);
$productOption->changeOptionValueCustomization($newOptionValueCustomization);

$writeService->storeProductOptions($productOption);
```


#### Updating the product options option value customization
```php
use Gambio\Admin\Modules\ProductOption\Model\ValueObjects\ProductOptionStock;

/** $readService \Gambio\Admin\Modules\Option\Services\OptionReadService **/
/** $writeService \Gambio\Admin\Modules\Option\Services\OptionWriteService **/
/** $factory \Gambio\Admin\Modules\Option\Services\OptionFactory **/

$newProductOptionStock = $factory->createProductOptionStock(
    $stock = 0, $stockType = ProductOptionStock::STOCK_TYPE_NOT_MANAGED
);

$productOption = $readService->getProductOptionById($productOptionId = 1);
$productOption->changeProductOptionStock($newProductOptionStock);

$writeService->storeProductOptions($productOption);
```


#### Updating the product options sort order
```php
/** $readService \Gambio\Admin\Modules\Option\Services\OptionReadService **/
/** $writeService \Gambio\Admin\Modules\Option\Services\OptionWriteService **/

$productOption = $readService->getProductOptionById($productOptionId = 1);
$productOption->changeSortOrder($newSortOrder = 2);

$writeService->storeProductOptions($productOption);
```


#### Deleting a product option
```php
/** $writeService \Gambio\Admin\Modules\Option\Services\OptionWriteService **/

$productOptionIds = [1, 2];

$writeService->deleteOptions(...$productOptionIds);
```


### Use cases using filter service


#### Filter all existing options including sorting and pagination

```php
/** $filterService \Gambio\Admin\Modules\ProductOption\Services\ProductOptionFilterService **/

$productId = 1;
$filters = [
    'optionId' => 1, // Product options based on the option with the ID 1
];
$sorting = '-price'; // In descending order of the price

$filteredProductOptions             = $filterService->filterProductOptions(
    $productId, $filters, $sorting, $limit = 25, $offset = 0
);
$totalCountOfFilteredProductOptions = $filterService->getProductOptionsTotalCount($productId, $filters);
```


##### Filtering

The filter array that is given to the filter service maps the attributes of the product option and the filtering term.
The assigned string (e.g. `get|2020-01-01`) always contains the comparison value, but it also may contain an
operation (e.g. `gte` for greater than or equals to). Leaving the operation (e.g. `2020-01-01`) will be the same
as using *equals to* (`eq`).

The following table shows all attributes and the operations that can be used on them.

|   | like (`*`) | equals to (`eq`) | lower than (`lt`) | lower than or equals to (`lte`) | greater than (`gt`) | greater than or equals to (`gte`) |
|---|:---:|:---:|:---:|:---:|:---:|:---:|
| `id`            |   | X | X | X | X | X |
| `optionId`      |   | X | X | X | X | X |
| `optionValueId` |   | X | X | X | X | X |
| `imageListId`   |   | X | X | X | X | X |
| `modelNumber`   | X | X |   |   |   |   |
| `weight`        |   | X | X | X | X | X |
| `price`         |   | X | X | X | X | X |
| `stockType`     | X | X |   |   |   |   |
| `stock`         |   | X | X | X | X | X |
| `sortOrder`     |   | X | X | X | X | X |


##### Sorting

To change the sorting, you can provide a string that describes the sorting order. The string must contain the
attributes used for sorting. If there is a minus (`-`) in front of the attribute, it will be sorted in descending
order. You can use multiple attributes to change the sorting order by linking them with a comma (`,`).


## Business rules

- The combination of product, option and option value must be uniq.
- The `stockType` determines the behavior for the stock management. Three options are available here:
  - `only-positive`: Only positive values are allowed as stock, including zero.
  - `all-numbers`: All numbers are allowed as stock.
  - `not-managed`: The stock is not actively managed, which means that this value is not considered for the determination of the current stock.


### Domain events

| Event | Description |
| ----- | ----------- |
| `Gambio\Admin\Modules\ProductOption\Model\Events\ProductOptionCreated`                    | Will be raised if a new product option has been created. |
| `Gambio\Admin\Modules\ProductOption\Model\Events\ProductOptionDeleted`                    | Will be raised if an product option has been deleted. |
| `Gambio\Admin\Modules\ProductOption\Model\Events\ProductOptionsImageListIdUpdated`        | Will be raised if the image list ID of an product option has been updated. |
| `Gambio\Admin\Modules\ProductOption\Model\Events\ProductOptionsSortOrderUpdated`          | Will be raised if the sort order of an product option has been updated. |
| `Gambio\Admin\Modules\ProductOption\Model\Events\ProductOptionsStockUpdated`              | Will be raised if the stock of an product option has been updated. |
| `Gambio\Admin\Modules\ProductOption\Model\Events\ProductOptionsValueCustomizationUpdated` | Will be raised if the option value customization of an product option has been updated. |
