# Product Variant

A product variant represents a specific combination of selectable option values. After a customer or visitor of the
shop selected on of more linked option values of a specific product, then a product variant can be determined.
This way the customers can specify the product they want to buy, like a red or blue t-shirt or a specific pattern.
If a product has one or more variants only its variants can be added to the shopping cart.

The product variants can be combined with product options.

Functionally this domain/system can be compared with the old product properties. The main difference is here that it's
no longer based on the properties.


## Product variant domain

The product variant domain provides management functionality (create, read, update and delete), as well as the
possibility to filter all existing variants. This domain references a combination based on option and option values
of the option domain.


### Aggregate root and domain model

The aggregate root `Gambio\Admin\Modules\ProductVariant\Model\ProductVariant` is one specific combination of selectable
option values linked to a specific product. A product variant encapsulates general information like a model number,
EAN, stock, price, etc. that overwrite the corresponding attributes of the referenced product.

After creation, the aggregate root provides the possibility to change the attributes of the product variant itself.


### Use cases using read service


#### Fetching all or a specific variant

```php
/** $readService \Gambio\Admin\Modules\ProductVariant\Services\ProductVariantReadService **/

$allProductVariants     = $readService->getProductVariantsByProductId($productId = 1);
$specificProductVariant = $readService->getProductVariantById($variantId = 1);
```


### Use cases using write service


#### Creating a new product variant

```php
use Gambio\Admin\Modules\ProductVariant\Model\ValueObjects\ProductCustomization;
use Gambio\Admin\Modules\ProductVariant\Model\ValueObjects\ProductVariantStock;

/** $writeService \Gambio\Admin\Modules\ProductVariant\Services\ProductVariantWriteService **/
/** $factory \Gambio\Admin\Modules\ProductVariant\Services\ProductVariantFactory **/

$combination                  = $factory->createOptionAndOptionValueIds(
    $factory->createOptionAndOptionValueId($optionId1 = 1, $optionValueId1 = 1),
    $factory->createOptionAndOptionValueId($optionId2 = 2, $optionValueId2 = 1)
);
$imageListId                  = 1; // Can also be null if no image list exists for this product variant
$productCustomization         = $factory->createProductCustomization(
    $deliveryTimeId = 1, $priceType = ProductCustomization::PRICE_TYPE_ADDITION, $price = 0,
    $weightType = ProductCustomization::WEIGHT_TYPE_ADDITION, $weight = 0, $vpeScalarValue = 0, $vpeUnitId = null
);
$productIdentificationNumbers = $factory->createProductIdentificationNumbers(
    $modelNumber = 'abc123', $ean = '978020137962', $gtin = '04012345123456', $asin = 'B088W5PS35'
);
$stock                        = $factory->createProductVariantStock(
    $stock = 0, $stockType = ProductVariantStock::STOCK_TYPE_NOT_MANAGED
);

$id = $writeService->createProductVariant(
    $productId = 1, $combination, $imageListId, $productCustomization,
    $productIdentificationNumbers, $stock, $sortOrder = 1
);
```


#### Creating multiple product variants at once

```php
use Gambio\Admin\Modules\ProductVariant\Model\ValueObjects\ProductCustomization;
use Gambio\Admin\Modules\ProductVariant\Model\ValueObjects\ProductVariantStock;

/** $writeService \Gambio\Admin\Modules\ProductVariant\Services\ProductVariantWriteService **/
/** $factory \Gambio\Admin\Modules\ProductVariant\Services\ProductVariantFactory **/

$productIds                   = [
    'first-product-variant'  => 1, 
    'second-product-variant' => 1,
];
$combinations                 = [
    'first-product-variant'  => $factory->createOptionAndOptionValueIds(
        $factory->createOptionAndOptionValueId($optionId1 = 1, $optionValueId1 = 1),
        $factory->createOptionAndOptionValueId($optionId2 = 2, $optionValueId2 = 1)
    ),
    'second-product-variant' => $factory->createOptionAndOptionValueIds(
        $factory->createOptionAndOptionValueId($optionId1 = 1, $optionValueId1 = 1),
        $factory->createOptionAndOptionValueId($optionId2 = 2, $optionValueId2 = 2)
    ),
];
$imageListIds                 = [
    'first-product-variant'  => 1, 
    'second-product-variant' => null,
];
$productCustomizations        = [
    'first-product-variant'  => $factory->createProductCustomization(
        $deliveryTimeId = 1, $priceType = ProductCustomization::PRICE_TYPE_ADDITION, $price = 0,
        $weightType = ProductCustomization::WEIGHT_TYPE_ADDITION, $weight = 0, $vpeScalarValue = 0, $vpeUnitId = null
    ),
    'second-product-variant' => $factory->createProductCustomization(
        $deliveryTimeId = 1, $priceType = ProductCustomization::PRICE_TYPE_REPLACING, $price = 56.78,
        $weightType = ProductCustomization::WEIGHT_TYPE_REPLACING, $weight = 12.34, $vpeScalarValue = 0, $vpeUnitId = null
    ),
];
$productIdentificationNumbers = [
    'first-product-variant'  => $factory->createProductIdentificationNumbers(
        $modelNumber = 'abc123', $ean = '978020137962', $gtin = '04012345123456', $asin = 'B088W5PS35'
    ),
    'second-product-variant' => $factory->createProductIdentificationNumbers(
        $modelNumber = 'abc123', $ean = '978020137962', $gtin = '04012345123456', $asin = 'B088W5PS35'
    ),
];
$stocks                       = [
    'first-product-variant'  => $factory->createProductVariantStock(
        $stock = 0, $stockType = ProductVariantStock::STOCK_TYPE_NOT_MANAGED
    ),
    'second-product-variant' => $factory->createProductVariantStock(
        $stock = 0, $stockType = ProductVariantStock::STOCK_TYPE_NOT_MANAGED
    ),
];
$sortOrders                   = [
    'first-product-variant'  => 1, 
    'second-product-variant' => 2,
];;

$creationArguments = [
    [
        $productIds['first-product-variant'], $combinations['first-product-variant'],
        $imageListIds['first-product-variant'], $productCustomizations['first-product-variant'],
        $productIdentificationNumbers['first-product-variant'], $stocks['first-product-variant'],
        $sortOrders['first-product-variant']
    ],
    [
        $productIds['second-product-variant'], $combinations['second-product-variant'],
        $imageListIds['second-product-variant'], $productCustomizations['second-product-variant'],
        $productIdentificationNumbers['second-product-variant'], $stocks['second-product-variant'],
        $sortOrders['second-product-variant']
    ],
];

$ids = $writeService->createMultipleProductVariants(...$creationArguments);
```


#### Updating the product variants combination
```php
/** $readService \Gambio\Admin\Modules\Variant\Services\VariantReadService **/
/** $writeService \Gambio\Admin\Modules\Variant\Services\VariantWriteService **/
/** $factory \Gambio\Admin\Modules\Variant\Services\VariantFactory **/

$newCombination = $factory->createOptionAndOptionValueIds(
    $factory->createOptionAndOptionValueId($optionId1 = 1, $optionValueId1 = 1),
    $factory->createOptionAndOptionValueId($optionId2 = 2, $optionValueId2 = 1)
);

$productVariant = $readService->getProductVariantById($productVariantId = 1);
$productVariant->changeCombination($newCombination);

$writeService->storeProductVariants($productVariant);
```


#### Updating the product variants stock
```php
use Gambio\Admin\Modules\ProductVariant\Model\ValueObjects\ProductVariantStock;

/** $readService \Gambio\Admin\Modules\Variant\Services\VariantReadService **/
/** $writeService \Gambio\Admin\Modules\Variant\Services\VariantWriteService **/
/** $factory \Gambio\Admin\Modules\Variant\Services\VariantFactory **/

$newStock = $factory->createProductVariantStock($stock = 0, $stockType = ProductVariantStock::STOCK_TYPE_NOT_MANAGED);

$productVariant = $readService->getProductVariantById($productVariantId = 1);
$productVariant->changeStock($newStock);

$writeService->storeProductVariants($productVariant);
```


#### Updating the product variants image list ID
```php
/** $readService \Gambio\Admin\Modules\Variant\Services\VariantReadService **/
/** $writeService \Gambio\Admin\Modules\Variant\Services\VariantWriteService **/
/** $factory \Gambio\Admin\Modules\Variant\Services\VariantFactory **/

$productVariant = $readService->getProductVariantById($productVariantId = 1);
$productVariant->changeImageListId($factory->createImageListId($imageListId = 1));

$writeService->storeProductVariants($productVariant);
```


#### Updating the product variants sort order
```php
/** $readService \Gambio\Admin\Modules\Variant\Services\VariantReadService **/
/** $writeService \Gambio\Admin\Modules\Variant\Services\VariantWriteService **/

$productVariant = $readService->getProductVariantById($productVariantId = 1);
$productVariant->changeSortOrder($newSortOrder = 2);

$writeService->storeProductVariants($productVariant);
```


#### Updating the product variants sort order
```php
use Gambio\Admin\Modules\ProductVariant\Model\ValueObjects\ProductCustomization;

/** $readService \Gambio\Admin\Modules\Variant\Services\VariantReadService **/
/** $writeService \Gambio\Admin\Modules\Variant\Services\VariantWriteService **/

$newProductCustomization = $factory->createProductCustomization(
    $deliveryTimeId = 1, $priceType = ProductCustomization::PRICE_TYPE_ADDITION, $price = 0,
    $weightType = ProductCustomization::WEIGHT_TYPE_ADDITION, $weight = 0, $vpeScalarValue = 0, $vpeUnitId = null
);

$productVariant = $readService->getProductVariantById($productVariantId = 1);
$productVariant->changeProductCustomization($newProductCustomization);

$writeService->storeProductVariants($productVariant);
```


#### Updating the product variants sort order
```php
/** $readService \Gambio\Admin\Modules\Variant\Services\VariantReadService **/
/** $writeService \Gambio\Admin\Modules\Variant\Services\VariantWriteService **/

$newProductIdentificationNumbers = $factory->createProductIdentificationNumbers(
    $modelNumber = 'abc123', $ean = '978020137962', $gtin = '04012345123456', $asin = 'B088W5PS35'
);

$productVariant = $readService->getProductVariantById($productVariantId = 1);
$productVariant->changeProductIdentificationNumbers($newProductIdentificationNumbers);

$writeService->storeProductVariants($productVariant);
```


#### Deleting a product variant
```php
/** $writeService \Gambio\Admin\Modules\Variant\Services\VariantWriteService **/

$productVariantIds = [1, 2];

$writeService->deleteVariants(...$productVariantIds);
```


### Use cases using filter service


#### Filter all existing variants including sorting and pagination

```php
/** $filterService \Gambio\Admin\Modules\ProductVariant\Services\ProductVariantFilterService **/

$productId = 1;
$filters = [
    'combination.optionId' => 1, // Product variants based on the option with the ID 1
];
$sorting = '-stock'; // In descending order of the stock

$filteredProductVariants             = $filterService->filterProductVariants(
    $productId, $filters, $sorting, $limit = 25, $offset = 0
);
$totalCountOfFilteredProductVariants = $filterService->getProductVariantsTotalCount($productId, $filters);
```


##### Filtering

The filter array that is given to the filter service maps the attributes of the product variant and the filtering term.
The assigned string (e.g. `get|2020-01-01`) always contains the comparison value, but it also may contain an
operation (e.g. `gte` for greater than or equals to). Leaving the operation (e.g. `2020-01-01`) will be the same
as using *equals to* (`eq`).

The following table shows all attributes and the operations that can be used on them.

|   | like (`*`) | equals to (`eq`) | lower than (`lt`) | lower than or equals to (`lte`) | greater than (`gt`) | greater than or equals to (`gte`) |
|---|:---:|:---:|:---:|:---:|:---:|:---:|
| `id`                        |   | X | X | X | X | X |
| `productId`                 |   | X | X | X | X | X |
| `combination.optionId`      |   | X | X | X | X | X |
| `combination.optionValueId` |   | X | X | X | X | X |
| `sortOrder`                 |   | X | X | X | X | X |
| `modelNumber`               | X | X |   |   |   |   |
| `GTIN`                      | X | X |   |   |   |   |
| `ASIN`                      | X | X |   |   |   |   |
| `EAN`                       | X | X |   |   |   |   |
| `stockType`                 | X | X |   |   |   |   |
| `stock`                     |   | X | X | X | X | X |
| `weightType`                | X | X |   |   |   |   |
| `weight`                    |   | X | X | X | X | X |
| `priceType`                 | X | X |   |   |   |   |
| `price`                     |   | X | X | X | X | X |
| `vpeScalarValue`            |   | X | X | X | X | X |
| `vpeUnitId`                 |   | X | X | X | X | X |
| `deliveryTimeId`            |   | X | X | X | X | X |
| `imageListId`               |   | X | X | X | X | X |


##### Sorting

To change the sorting, you can provide a string that describes the sorting order. The string must contain the
attributes used for sorting. If there is a minus (`-`) in front of the attribute, it will be sorted in descending
order. You can use multiple attributes to change the sorting order by linking them with a comma (`,`).


## Business rules

- The combination of option values must be uniq for a specific product. (Important for adding and updating product
  variants!)
- If a new option values are added to the combinations of existing variants, the product variants should be **generated
  by coping the existing ones.**
- It is not possible to add a product variant with a combination of option values with more or less option values as the
  existing product variants
- The `weightType` determine if the weight is added to the product weight or replaces it.
- The `priceType` determine if the price is added to the product price or replaces it.
- The `stockType` determines the behavior for the stock management. Three options are available here:
  - `only-positive`: Only positive values are allowed as stock, including zero.
  - `all-numbers`: All numbers are allowed as stock.
  - `not-managed`: The stock is not actively managed, which means that this value is not considered for the determination of the current stock.
- When removing an option from the product variant combinations, it's needed to provide a contained option value, that
  defines which product variants should be kept. The option is then removed completely from the combinations.



### Domain events

| Event | Description |
| ----- | ----------- |
| `Gambio\Admin\Modules\ProductVariant\Model\Events\\ProductVariantCreated`                             | Will be raised if a new product variant has been created. |
| `Gambio\Admin\Modules\ProductVariant\Model\Events\\ProductVariantDeleted`                             | Will be raised if an existing product variant has been removed. |
| `Gambio\Admin\Modules\ProductVariant\Model\Events\\UpdatedProductVariantProductCustomization`         | Will be raised if the product customizations of a product variant has been updated. |
| `Gambio\Admin\Modules\ProductVariant\Model\Events\\UpdatedProductVariantProductIdentificationNumbers` | Will be raised if the product identification numbers of a product variant has been updated. |
| `Gambio\Admin\Modules\ProductVariant\Model\Events\\UpdatedProductVariantsCombination`                 | Will be raised if the combination of a product variant has been updated. |
| `Gambio\Admin\Modules\ProductVariant\Model\Events\\UpdatedProductVariantsImageListId`                 | Will be raised if the image list ID of a product variant has been updated. |
| `Gambio\Admin\Modules\ProductVariant\Model\Events\\UpdatedProductVariantsSortOrder`                   | Will be raised if the sort order of a product variant has been updated. |
| `Gambio\Admin\Modules\ProductVariant\Model\Events\\UpdatedProductVariantsStock`                       | Will be raised if the stock of a product variant has been updated. |