# Components

## Product Listing Item

The product listing item contains all product related data and can be extended.

At first, we can use a "fake" item implementation containing only a small subset of the actual data to build the other
system around.

Also, in the first iteration, the model contains only methods to serialize into a php array and necessary methods to
check for specific items (in order to implement the extending functionality).

Further iterations might extend the item by composing traits into the model implementation providing methods for
accessing and mutating the internal state.

### Extendability

Product listing items can be extended. They provide a method for that that takes a namespace and payload as parameter.
The signature might look like this: `(string $namespace, mixed $payload)`. At least at the first iteration, we only
provide a mechanism to add data to the listing item, but there is **no** mechanism to change existing data. Also, it is
not possible in the first iteration to reference any existing data of the item (due to the lack of accessors), but this
feature should be added ASAP after the first iteration.

## Listing

The listing represents the aggregate-root of the product listing subdomain. It is identified by the listing item ids
produces from a [Filter](#filter).

It is a collection of [Product Listing Items](#product-listing-item) and contains additional metadata for pagination.

The listing is the only class that will be exposed by the service. It **MUST NOT** expose the internal collection, but
rather provide methods for extendability and serialization.

### Pagination

The pagination contains metadata that is only important when serializing the listing into an array, so it can be used
e.g. by the UI.

### Extendability

The listing provides a couple of methods to extend the listing items:

1. Extend whole list

2. Extend listing item with specific id

3. Extend listing items with specific ids

4. Extend listing items without specific id

5. Extend listing items without specific ids

## Service

The service provides a single method to obtain product listings. It takes a couple of parameters, but the most important
one is the filter. The filter is responsible to produce a list of product ids for all items that could appear in the
listing. The other parameters are the pagination setup and some global identifier, like the currents user and language
id in order to fetch the correct prices of that customer with a correct translation.

### Pagination

The pagination is just responsible to take the current page and items per page as input and use this information to
enhance the final listing with metadata used to navigate between pages.

## Filter

### Producing product listing item ids

The product listing filter defines the kind of product listing. For example, when you want to have a product listing for
all specials, the filter ensures to provide product ids of specials.

Filters can take arbitrary input in order to perform their task (producing product ids). Service providers can be used
to perform complex operations to calculate the filter listing items ids.

### (Optional) Event definition

Filters optionally can define events that are dispatched when the filter is used. It is recommended to inject
the [Product Listing](#listing) in the events' constructor, so listeners can extend the listing.

#### Idea

We could provide an abstract event implementation containing all necessary methods and force implementors to extend from
that class in order to ensure the [Listing](#listing) is injected and has all necessary methods.  
Then, implementors just have to create an empty event class extending the abstract implementation. It would make things
easy and the reason to provide events in filters is that listeners can distinguish between different listings.

## Extender

Extender provide another way to extend the listing. It takes the [Listing](#listing) and [Filter](#filter) as parameter
and can therefore perform different operations than the events' mechanism. The core itself will not provide any
extenders, but this is a good place for third party developers to hook in the system.
