# TODO'S

- define events name and FQN to extend on listing item level

# To Discuss

### Decide: `AfterProductListingFetchEvent` or `PostProductListingFetchEvent`

Name of the event that is dispatched after product listing collection data is fetched, for example used to extend
listings on item level

`[After]ProductListingFetchEvent` (in case a "before" event is required: `[After]ProductListingFetchEvent`)  
`[Post]ProductListingFetchEvent` (in case a "before" event is required: `[Pre]ProductListingFetchEvent`)

We have to chose one of the event names for that.

### product_listing.shipping.range object similarity to old implementation

In the product listing model, the `item.shipping.range` object is implemented like previously in `products_ORIGIN`. We
should discuss how and where it is used and if this structure makes sense at all.

### Product Options, Variants

Discuss with other team members which are the most needed & useful to include and not provided in the current product
listing.

# Preparation

- collect data schema for Options (product variants, options, downloads)

- For what those columns is used?
    - `products.products_ordered`
    - `products.group_ids`

Is `products.products_weight` always in Kilo Gram?

# Notes

We may remove the following data from the product listing item model:

- `PRODUCTS_IMAGE_W`
- `PRODUCTS_IMAGE_H`
- `PRODUCTS_IMAGE_WIDTH`
- `PRODUCTS_IMAGE_PADDING`
- `PRODUCTS_BUTTON_BUY_NOW`

> We are aware that there are some inconsistencies between e.g. type names and documentation.
> Those inconsistencies will be cleaned up after the documents core concepts have been discussed

# Service API

The listing service API has only one method:

```php
use Gambio\Shop\Sample\ProductListing\Services\ListingFilter;
use Gambio\Shop\Sample\ProductListing\Services\ListingItemCollection;
use Gambio\Shop\Sample\ProductListing\Services\ListingPagination;

public function getListing(
    ListingFilter $filter, 
    ListingPagination $pagination
): ListingItemCollection;
```

The two arguments control the behaviour of the listing. The first one, `ListingFilter $filter`, controls which products
appear in the final listing. For example, there could be a filter called "`UpcomingProductsFilter`", and when using it,
only products that will be published in the future will be displayed.

The second one, `ListingPagination $pagination`, is used to divide the result into pages and to add further metadata,
such as the total number of results found with the filter and the maximum page, based on the value of the items to be
displayed per page.

## Filter

The listings filter responsibility is to produce a list of product ids. It is up to the implementor how to produce that
list. It is also recommendable to implement some kind caching mechanism to provide fast access the listing ids.

```php
use Gambio\Shop\Sample\ProductListing\Services\ListingItemIdCollection;

public function getFilterIds(): ListingItemIdCollection;
```

The list of item ids can be of any size. Another mechanism is responsible to create pagination data for the listing.

## Pagination

The pagination takes two inputs:

- `int $page`: Current page of listing items. If `$page` <= 0, it is automatically set to the value `1`.
- `int $perPage`: Count of listing items per page. If `$page` <= 0, it is automatically set to the value `1`.

The pagination has the responsibility to limit the result set and provide an offset in order to divide the items into
pages. Also, additional metadata for the whole result set is produces, namely `int $total` and `int $maxPage`.

# Todo: ::registerExtender

### Example

```php
/** @var Gambio\Shop\Sample\ProductListing\Services\ListingService $service **/

$productListing = $service->getListing($filter, $pagination);
```

# Extendability

## Listing

There are three methods to write additional data into the listing items structure:

- `extendItem`: Adds additional data to listing item by identifier
- `extendItems`: Adds additional data to listing item**s** by identifier**s**
- `extendList` Adds additional data to all listing items

All of them take `$namespace` and `$payload` as argument to add additional product information. The other argument might
be used to only modify specific listing items.

> This approach only adds data to the listing, but is not able to modify/change any of the existing data

### Extending listing item collection

There are two ways to extend the listing items, depending on your use case.

Both solutions are capable to extend all listings or dedicated ones.

------

#### Events

One possible approach is using events everywhere. So we could fire an event which is dispatched for all listings and
therefore can be used to extend any product listing type. Also, the filter can define an optional event which will be
dispatched only for that specific listing type.

##### Sample

When using events, the event class must somehow expose whether the items itself or must provide some kind of access to
the ListingItems "modification" methods (`::extendItem`, `::extendItems`, `::extendList`).

```php
class ListingEvent
{
    private ListingItems $items;

    public function __construct(ListingItems $items)
    {
        $this->items = $items;
    }
}

class ListingEventListener
{
    public function __invoke(ListingEvent $event): ListingEvent
    {
        // Do something with event
        return $event;
    }
}
```

The drawback of events is that the event class have to define an additional api to access te internal listing. On the
other hand, combining events with filters provides a very simple solution to extend per listing.

------

#### Extender

Another approach are listing extenders. They are executed for all listings. Extenders get the listing items and filter
as an argument and are self-responsible to decide if they should extend the current list.

The extender way, for example, has direct access to the listing items and can therefore call directly the modification
methods. Also, any other methods of the listing items are accessible.

```php
public function extend(ListingItems $listingItems, ListingFilter $filter): void;
```

## Product Item Level

There is an event that will be dispatched after the core collects all product listing items. The event provides an API
to extend the internal listing items.

`public function extendItem(ProductListingId $productListingId, string $namespace, $additionalData): void`

- `ProductListingId $productListingId`: Identifies which listing item will be extended
- `string $namespace`: Unique namespace which will be applied in the "additionalData" block
- `mixed $additionalData`: Data which is added in the used namespace of "additionalData"

> NOTE: The argument `$namespace` **MUST** be unique! Using the same namespace twice overrides any existing data.

Attaching additional data to product listing items can be done by using the events API method:

```php
$productListingItemId = ProductListingItemId::fromInt(1);

$event->extendItem($productListingItemId, 'additional_data_null', null);
$event->extendItem($productListingItemId, 'additional_data_bool', random_int(1, 2) === 1);
$event->extendItem($productListingItemId, 'additional_data_int', 123);
$event->extendItem($productListingItemId, 'additional_data_float', 1.23);
$event->extendItem($productListingItemId, 'additional_data_string', 'string data');
$event->extendItem($productListingItemId, 'additional_data_array', ['foo' => 42, 'bar' => ['key' => 'value']]);
```

The example above would result in an `additionalData` structure for the listing item with id 1 like here:

```json lines
{
    "id": 1,
    // ...
    "additionalData": {
        "additional_data_null": null,
        "additional_data_bool": false,
        "additional_data_int": 123,
        "additional_data_float": 1.23,
        "additional_data_string": "string data",
        "additional_data_array": {
            "foo": 42,
            "bar": {
                "key": "value"
            }
        }
    },
}
```

> NOTE: Only listing items with matching id are affected

### Example event listener for product listings

This event listener simulates a module which functionality is to provide cross product graduated prices. Cross products
graduated prices are e.g. if you can choose between 10 different T-Shirts and the price of one unit is 10 €, five unit 8
€ (per unit) and at ten units for 5 € (per unit) for example.

The module somehow checks if listing items are affected by cross product graduated prices and if yes, the graduated
price for that item has to be determined somehow, and finally must be attached to the product listing data structure.

A "real world" module would usually inject other components in the event listener (via service provider) to provide the
functionality for cross product graduated prices. In this example, we choose to simply "fake" the implementation.

```php
// ...
class CrossProductGraduatedPricesEventListener
{
    private const ADDITIONAL_DATA_NAMESPACE = 'gx_cross_product_graduated_prices';
    
    private const SAMPLE_PRODUCT_IDS = [
        1,
        // ..
    ];
    
    private const SAMPLE_GRADUATED_PRICES = [
        [
            'quantity' => 1,
            'price'    => 99.99,
        ],
        // ...
    ];
    
    
    public function __invoke(ProductListingItemsCollectedEvent $event): ProductListingItemsCollectedEvent
    {
        $productListingIds = $event->getListingItemIds();
        
        foreach ($productListingIds as $productListingId) {
            if ($this->hasCrossProductGraduatedPrices($productListingId)) {
                $event->extendItem(
                    ProductListingItemId::fromInt($productListingId),
                    static::ADDITIONAL_DATA_NAMESPACE,
                    static::SAMPLE_GRADUATED_PRICES
                );
            }
        }
        
        return $event;
    }
    
    
    private function hasCrossProductGraduatedPrices(int $productListingId): bool
    {
        return in_array($productListingId, static::SAMPLE_PRODUCT_IDS, true);
    }
}
```
