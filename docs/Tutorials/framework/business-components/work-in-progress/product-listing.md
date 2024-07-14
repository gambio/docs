# Product Listing

Every list of products in the gambio shop is a Product Listing. They can be of different kinds, for example there could
be a listing for upcoming products and another listing for specials.  
Pages often contain multiple listings. They can provide links to the product or for example links to put them into the
cart directly.

## Product Listing Domain

The Product Listing Domain provides a service that is used to retrieve any kind of listing. It has a single method,
which most important parameter is the filter, which defines the kind of listing.

There are several ways to extend Product Listings. It is possible to extend all listings, only specific kinds, or
exclude specific kinds. Also, it is possible to extend the whole listing at once, listing items with a specific id and a
batch extending mechanism by multiple ids.

## Aggregate root and domain model

The aggregate root `Gambio\Shop\Modules\ProductListing\Model\Listing` contains listing
items `Gambio\Shop\Modules\ProductListing\Model\ListingItem`. Listing items contains product- and customer related,
translated product information like the product name, description, prices, tax, stock information and more. They can be
extended in different ways, which will be explained in the
chapters [Extending a listing item](#extending-a-listing-item), [Extending a listing](#extending-a-listing)
, [Extending with extenders](#extending-with-extenders), and [Extending with events](#extending-with-events).

> Note: In the first iteration, the listing item contains only a small dataset. In further iterations,
> we add more data until we archive the final result.

## Use case

The `Gambio\Shop\Modules\ProductListing\Service\ListingService` provides a single method to obtain an extended listing.
Filters determine the kind of listing.

```php
$listing = $listingService->getListing($filter, $pagination, $listingSettings);
```

### Filter

Filters must implement `Gambio\Shop\Modules\ProductListing\Service\ListingFilter`. They produce a list of product ids
for the service, which are used to create the listing items.

They determine the kind of listings and are therefore an important component of the domain. Filters are responsible to
determine product ids for a specific tasks. This can be done through external input, like for a search page, or through
internal data, like dates defined in some products related tables.

Additionally, filters can define an event that will be dispatched in order to provide extendability by event for that
filter.

> Event tho filters might get components injected in order to perform complex operations to produce the product ids,
> it is **not** recommended setting up filter in service provider. Instead, inject those components for example in
> action classes or dedicated factories in order to also take external input into account when creating filters.

```php
$filter        = $filterFactory->createSearchFilter($searchQuery);
$searchListing = $listingService->getListing($filter, ...);
```

### Other service input

For pagination, the service needs the current page and the items per page as input. Additionally, the language id and
user id is required in order to fetch translated items with the correct customer related data.

#### Extending a listing item

Listing items provides a method to extend the internal data. A namespace must be provided to distinguish between
different extenders. The provided payload can be of any type.

```php
public function extend(string $namespace, $payload): void;
```

#### Extending a listing

The aggregate root provides methods to extend listing items:

1. Extend whole list
2. Extend listing item with specific id
3. Extend listing items with specific ids
4. Extend listing items without specific id
5. Extend listing items without specific ids

The aggregate root will be exposed to [Extenders](#extending-with-extenders) and [Events](#extending-with-events), so
they can use the methods to add their own data.

```php
public function extend(string $namespace, $payload): void;
public function extendById(ListingItemId $id, string $namespace, $payload): void;
public function extendByIds(ListingItemIds $ids, string $namespace, $payload): void;
public function extendWithoutId(ListingItemId $id, string $namespace, $payload): void;
public function extendWithoutIds(ListingItemIds $ids, string $namespace, $payload): void;
```

#### Extending with extenders

Extenders must implement the `Gambio\Shop\Modules\ProductListing\Service\ListingExtender` interface and can be
registered by inflecting the `::registerExtender` method of the service in a bootable service provider.

```php
use Gambio\Shop\Modules\ProductListing\Model\Listing;
use Gambio\Shop\Modules\ProductListing\Service\ListingFilter;

public function extend(Listing $listing, ListingFilter $filter);
```

#### Extending with events

Event listeners can be attached to specific events in order to extend the listing. There is an abstract product listing
event class `Gambio\Shop\Modules\ProductListing\Events\AbstractListingEvent` and it is recommended to extend from that
class. It provides all necessary extending functionality, so implementing events are only used to determine the kind of
listing.

The event `Gambio\Shop\Modules\ProductListing\Events\ListingCollected` is dispatched for all listings. Additionally,
filters can optionally define events to be dispatched.

