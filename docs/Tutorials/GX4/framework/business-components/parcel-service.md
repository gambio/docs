# Parcel Service

Parcel services provide information about the company that is responsable for shipping an order to the customer.
Therefore, it's important to manage specific informationen like name, description, and the URL for looking up the
current shipping status.

The following sections describe the domain, model, use cases and business rules.


## Parcel service domain

The parcel service domain provides management functionality (create, read, update and delete), as well as the
possibility to filter all existing parcel services. In general this domain is very basic and there aren't any
specific business rules or constrains.


### Aggregate root and domain model

The aggregate root `Gambio\Admin\Modules\ParcelService\Model\ParcelService` encapsulates details regarding the 
corresponding name and description of a specific parcel service. One parcel service can be selected as default,
which will always be pre-selected if a tracking code is added to an order.

`{TRACKING_NUMBER}` can be used as a placeholder for the tracking code inside the description URL. 


### Use cases using read service


#### Fetching all or a specific parcel service

```
/** $readService \Gambio\Admin\Modules\ParcelService\Services\ParcelServiceReadService **/

$allParcelServices     = $readService->getParcelServices();
$specificParcelService = $readService->getParcelServiceById(1);
```


### Use cases using write service


#### Updating the name

```
/** $readService \Gambio\Admin\Modules\ParcelService\Services\ParcelServiceReadService **/
/** $writeService \Gambio\Admin\Modules\ParcelService\Services\ParcelServiceWriteService **/

$newName = 'new-name';

$parcelService = $readService->getParcelServiceById(1);
$parcelService->changeName($newName);

$writeService->storeParcelServices($parcelService);
```


#### Defining as default

```
/** $readService \Gambio\Admin\Modules\ParcelService\Services\ParcelServiceReadService **/
/** $writeService \Gambio\Admin\Modules\ParcelService\Services\ParcelServiceWriteService **/

$parcelService = $readService->getParcelServiceById(1);
$parcelService->setAsDefault();

$writeService->storeParcelServices($parcelService);
```


#### Updating the descriptions

```
/** $readService \Gambio\Admin\Modules\ParcelService\Services\ParcelServiceReadService **/
/** $writeService \Gambio\Admin\Modules\ParcelService\Services\ParcelServiceWriteService **/
/** $factory \Gambio\Admin\Modules\ParcelService\Services\ParcelServiceFactory **/

$deDescription   = $factory->createParcelServiceDescription('de', 'http://example.de/{TRACKING_NUMBER}', 'sample de comment');
$enDescription   = $factory->createParcelServiceDescription('en', 'http://example.com/{TRACKING_NUMBER}', 'sample en comment');
$newDescriptions = $factory->createParcelServiceDescriptions($deDescription, $enDescription);

$parcelService = $readService->getParcelServiceById(1);
$parcelService->changeDescriptions($newDescriptions);

$writeService->storeParcelServices($parcelService);
```


#### Updating the shipment type

```
/** $readService \Gambio\Admin\Modules\ParcelService\Services\ParcelServiceReadService **/
/** $writeService \Gambio\Admin\Modules\ParcelService\Services\ParcelServiceWriteService **/

$newShipmentType = 'new shipment type';

$parcelService = $readService->getParcelServiceById(1);
$parcelService->changeShipmentType($newShipmentType);

$writeService->storeParcelServices($parcelService);
```


#### Creating a new parcel service

__Full example:__

```
/** $writeService \Gambio\Admin\Modules\ParcelService\Services\ParcelServiceWriteService **/
/** $factory \Gambio\Admin\Modules\ParcelService\Services\ParcelServiceFactory **/

$name          = 'sample name';
$deDescription = $factory->createParcelServiceDescription('de', 'http://example.de/{TRACKING_NUMBER}', 'sample de comment');
$enDescription = $factory->createParcelServiceDescription('en', 'http://example.com/{TRACKING_NUMBER}', 'sample en comment');
$descriptions  = $factory->createParcelServiceDescriptions($deDescription, $enDescription);
$isDefault     = false;
$shipmentType  = 'shipment type';


$id = $writeService->createParcelService($name, $descriptions, $isDefault, $shipmentType);
```

__Minimal example with default values:__

```
/** $writeService \Gambio\Admin\Modules\ParcelService\Services\ParcelServiceWriteService **/
/** $factory \Gambio\Admin\Modules\ParcelService\Services\ParcelServiceFactory **/

$name          = 'sample name';
$deDescription = $factory->createParcelServiceDescription('de', 'http://example.de/{TRACKING_NUMBER}', 'sample de comment');
$enDescription = $factory->createParcelServiceDescription('en', 'http://example.com/{TRACKING_NUMBER}', 'sample en comment');
$descriptions  = $factory->createParcelServiceDescriptions($deDescription, $enDescription);

$id = $writeService->createParcelService($name, $descriptions);
```


#### Creating multiple parcel services at once

You can create multiple parcel services at once if you provide all needed information as an array.

```
/** $writeService \Gambio\Admin\Modules\ParcelService\Services\ParcelServiceWriteService **/
/** $factory \Gambio\Admin\Modules\ParcelService\Services\ParcelServiceFactory **/

$deDescription1 = $factory->createParcelServiceDescription('de', 'http://example.de/{TRACKING_NUMBER}', 'sample de comment 1');
$enDescription1 = $factory->createParcelServiceDescription('en', 'http://example.com/{TRACKING_NUMBER}', 'sample en comment 1');

$deDescription2 = $factory->createParcelServiceDescription('de', 'http://example.de/{TRACKING_NUMBER}', 'sample de comment2');
$enDescription2 = $factory->createParcelServiceDescription('en', 'http://example.com/{TRACKING_NUMBER}', 'sample en comment2');

$names        = ['sample name 1', 'sample name 2'];
$descriptions = [
                    $factory->createParcelServiceDescriptions($deDescription1, $enDescription1),
                    $factory->createParcelServiceDescriptions($deDescription2, $enDescription2),
                ];

$ids = $writeService->createParcelServices(
           [$names[0], $descriptions[0]],
           [$names[1], $descriptions[1]]
       );
```


#### Delete parcel services

```
/** $writeService \Gambio\Admin\Modules\ParcelService\Services\ParcelServiceWriteService **/

$id = 1;

$writeService->deleteParcelServices($id);
// Method can handle multiple IDs like: $writeService->deleteParcelServices($id1, $id2, $id3);
```


### Use cases using filter service


#### Filter all existing parcel services including sorting and pagination

```
/** $filterService \Gambio\Admin\Modules\ParcelService\Services\ParcelServiceFilterService **/

$filters = [
    'isDefault' => '0', // Parcel service is not default
];
$sorting = '-name'; // In descending order of name
$limit   = 25;
$offset  = 0;

$filteredParcelServices             = $filterService->filterParcelServices($filters, $sorting, $limit, $offset);
$totalCountOfFilteredParcelServices = $filterService->getParcelServicesTotalCount($filters);
```


##### Filtering

The filter array that is given to the filter service maps the attributes of the parcel service and the filtering term.
The assigned string (e.g. `get|2020-01-01`) always contains the comparison value, but it also may contain an
operation (e.g. `gte` for greater than or equals to). Leaving the operation (e.g. `2020-01-01`) will be the same
as using *equals to* (`eq`).

The following table shows all attributes and the operations that can be used on them.


|   | like (`*`) | equals to (`eq`) | lower than (`lt`) | lower than or equals to (`lte`) | greater than (`gt`) | greater than or equals to (`gte`) |
|---|:---:|:---:|:---:|:---:|:---:|:---:|
| `id`                          |   | X | X | X | X | X |
| `name`                        | X | X |   |   |   |   |
| `isDefault`                   |   | X |   |   |   |   |
| `descriptions.languageCode`   | X | X |   |   |   |   |
| `descriptions.url`            | X | X |   |   |   |   |
| `descriptions.comment`        | X | X |   |   |   |   |
| `shipmentType`                | X | X |   |   |   |   |


##### Sorting

To change the sorting, you can provide a string that describes the sorting order. The string must contain the
attributes used for sorting. If there is a minus (`-`) in front of the attribute, it will be sorted in descending
order. You can use multiple attributes to change the sorting order by linking them with a comma (`,`).


### Business rules

There are no specific business rules.


### Domain events

| Event | Description |
| ----- | ----------- |
| `Gambio\Admin\Modules\ParcelService\Model\Events\ParcelServiceCreated`             | Will be raised if a parcel service has been created. |
| `Gambio\Admin\Modules\ParcelService\Model\Events\ParcelServiceDeleted`             | Will be raised if a parcel service has been removed. |
| `Gambio\Admin\Modules\ParcelService\Model\Events\ParcelServiceDescriptionsUpdated` | Will be raised if the descriptions have been updated. |
| `Gambio\Admin\Modules\ParcelService\Model\Events\ParcelServiceMarkedAsDefault`     | Will be raised if a parcel service is defined as default. |
| `Gambio\Admin\Modules\ParcelService\Model\Events\ParcelServiceNameUpdated`         | Will be raised if a name has been updated. |
| `Gambio\Admin\Modules\ParcelService\Model\Events\ParcelServiceShipmentTypeUpdated` | Will be raised if a shipment type has been updated. |
