# Deliverables

## First iteration

### Very simple product listing item

The product listing item should only contain for example the translated name, raw base price from database table and an
additional member holding data for the extending mechanism.

#### Methods

1. Simple initialization: (Constructor | with translated name and raw base price)
2. Mechanism to add additional data: `string $namespace, mixed $payload`
3. Identification mechanisms: `::equalsId | ::equals`

### Product Listing

The product listings is a collection of the product listing items and contains additional metadata for pagination. Here,
it makes sense to implement a couple of features immediately in the first iteration. For usability, the listing should
be iterable. Also, it makes sense to implement a couple methods for extendability:

1. Extend whole list
2. Extend listing item with specific id
3. Extend listing items with specific ids
4. Extend listing items without specific id
5. Extend listing items without specific ids

Finally, the pagination metadata should be computed correctly.

### Service

The service class will be registered in the DI-Container to be used in different modules. This is the point where the
product listing subdomain introduce coupling to other domains.

It provides a single method, taking a filter, pagination and some identifier (for language and current user) as input
and produces the final listing.  
It is also responsible to dispatch any events and providing another extendability mechanism beside
events ([Extender](#extender)) so the listing can be extended before it is returned by the service.

#### Pseudo example:

```php
public function getListing($filter, $pagination, $userId, $languageId)
{
    // use repo to get listing based on inputs
    // dispatch filter based event (if available)
    // dispatch general listing event
    // executing extending mechanism using extenders
    // return listing
}
```

#### Details

The repository implementation **must** be exchangeable, so we can first implement a lightweight version of the listing
items and later on replaced it with the full-featured version.

### Filter

We implement at least one simple filter that also provides an event, so we can use it for testing and gathering
feedback. Later on, we define different kind of filters and divide their implementations across the team.

### Extender

Extenders are another way to extend listing beside events. The signature looks like this: `$listing, $filter`. Having
access to [Listing](#product-listing) makes it possible to use any of the extend* methods. The advantage to events is
having direct access the [Listing](#product-listing) and having the filter as reference opens different possibilities,
like only use extender for specific filter or event exclude specific filters from extenders.

The first iteration should implement a first GXModules sample showcasing extenders.
