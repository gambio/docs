# Tracking Code

Tracking codes provide information about the parcel service, that is responsable for shipping an order, but also about
the current shipping status itself, by providing a specific URL for that parcel service.

The following sections describe the domain, model, use cases and business rules.


## Tracking code domain

The tracking code domain provides management functionality (create, read, and delete), as well as the possibility to
filter all existing tracking codes. In general this domain is very basic, except one constrain. It is not possible
to update a created tracking code, therefore, it must be deleted and created again.


### Aggregate root and domain model

The aggregate root `Gambio\Admin\Modules\TrackingCode\Model\TrackingCode` provides information about the order,
the tracking code itself, when it's created, as well as details regarding the corresponding parcel service.


### Use cases using read service


#### Fetching all or a specific tracking code

```
/** $readService \Gambio\Admin\Modules\TrackingCode\Services\TrackingCodeReadService **/

$allTrackingCodes     = $readService->getTrackingCodes();
$specificTrackingCode = $readService->getTrackingCodeById(1);
```


### Use cases using write service


#### Creating a new tracking code

```
/** $writeService \Gambio\Admin\Modules\TrackingCode\Services\TrackingCodeWriteService **/
/** $factory \Gambio\Admin\Modules\TrackingCode\Services\TrackingCodeFactory **/

$orderId                   = 20024;
$code                      = '123456789-abcdef';
$languageCode              = 'en';
$parcelServiceId           = 1;
$parcelServiceName         = 'sample name';
$parcelServiceUrl          = 'http://example.com/123456789-abcdef';
$parcelServiceComment      = 'sample comment';
$parcelServiceShipmentType = 'sample shipment type';
$parcelServiceDetails      = $factory->createParcelServiceDetails(
                                 $languageCode,
                                 $parcelServiceId,
                                 $parcelServiceName,
                                 $parcelServiceUrl,
                                 $parcelServiceComment,
                                 $parcelServiceDetails
                             );
$isReturnDelivery          = true;

$id = $writeService->createTrackingCode($orderId, $code, $parcelServiceDetails, $isReturnDelivery);
```


#### Creating multiple tracking codes at once

You can create multiple tracking codes at once if you provide all needed information as an array.

```
/** $writeService \Gambio\Admin\Modules\TrackingCode\Services\TrackingCodeWriteService **/
/** $factory \Gambio\Admin\Modules\TrackingCode\Services\TrackingCodeFactory **/

$orderIds                   = [20024, 20025];
$codes                      = ['123456789-abcdef', '987654321-fedcba'];
$languageCodes              = ['en', 'de'];
$parcelServiceIds           = [1, 1];
$parcelServiceNames         = ['sample name', 'sample name'];
$parcelServiceUrls          = ['http://example.com/123456789-abcdef', 'http://example.de/987654321-fedcba'];
$parcelServiceComments      = ['sample comment', 'sample comment'];
$parcelServiceShipmentTypes = ['sample shipment type', 'sample shipment type'];
$parcelServiceDetails  = [
    $factory->createParcelServiceDetails(
        $languageCodes[0],
        $parcelServiceIds[0],
        $parcelServiceNames[0],
        $parcelServiceUrls[0],
        $parcelServiceComments[0],
        $parcelServiceShipmentTypes[0]
    ),
    $factory->createParcelServiceDetails(
        $languageCodes[1],
        $parcelServiceIds[1],
        $parcelServiceNames[1],
        $parcelServiceUrls[1],
        $parcelServiceComments[1],
        $parcelServiceShipmentTypes[1]
    ),
];
$isReturnDeliveries          = [true, false];

$ids = $writeService->createTrackingCodes(
           [$orderIds[0], $codes[0], $parcelServiceDetails[0], $isReturnDeliveries[0]],
           [$orderIds[1], $codes[1], $parcelServiceDetails[1], $isReturnDeliveries[1]]
       );
```


#### Delete tracking codes

```
/** $writeService \Gambio\Admin\Modules\TrackingCode\Services\TrackingCodeWriteService **/

$id = 1;

$writeService->deleteTrackingCodes($id);
// Method can handle multiple IDs like: $writeService->deleteTrackingCodes($id1, $id2, $id3);
```


### Use cases using filter service


#### Filter all existing tracking codes including sorting and pagination

```
/** $filterService \Gambio\Admin\Modules\TrackingCode\Services\TrackingCodeFilterService **/

$filters = [
    'code' => '*12345789*', // Tracking code contains "12345789"
];
$sorting = '-createdOn'; // In descending order of creation date
$limit   = 25;
$offset  = 0;

$filteredTrackingCodes             = $filterService->filterTrackingCodes($filters, $sorting, $limit, $offset);
$totalCountOfFilteredTrackingCodes = $filterService->getTrackingCodesTotalCount($filters);
```


##### Filtering

The filter array that is given to the filter service maps the attributes of the tracking code and the filtering term.
The assigned string (e.g. `get|2020-01-01`) always contains the comparison value, but it also may contain an
operation (e.g. `gte` for greater than or equals to). Leaving the operation (e.g. `2020-01-01`) will be the same
as using *equals to* (`eq`).

The following table shows all attributes and the operations that can be used on them.


|   | like (`*`) | equals to (`eq`) | lower than (`lt`) | lower than or equals to (`lte`) | greater than (`gt`) | greater than or equals to (`gte`) |
|---|:---:|:---:|:---:|:---:|:---:|:---:|
| `id`                          |   | X | X | X | X | X |
| `orderId`                     |   | X | X | X | X | X |
| `code`                        | X | X |   |   |   |   |
| `isReturnDelivery`            |   | X |   |   |   |   |
| `parcelService.id`            |   | X | X | X | X | X |
| `parcelService.languageCode`  | X | X |   |   |   |   |
| `parcelService.name`          | X | X |   |   |   |   |
| `parcelService.url`           | X | X |   |   |   |   |
| `parcelService.comment`       | X | X |   |   |   |   |
| `parcelService.shipmentType`  | X | X |   |   |   |   |
| `createdOn`                   |   | X | X | X | X | X |


##### Sorting

To change the sorting, you can provide a string that describes the sorting order. The string must contain the
attributes used for sorting. If there is a minus (`-`) in front of the attribute, it will be sorted in descending
order. You can use multiple attributes to change the sorting order by linking them with a comma (`,`).


### Business rules

There are no specific business rules.


### Domain events

| Event | Description |
| ----- | ----------- |
| `Gambio\Admin\Modules\TrackingCode\Model\Events\TrackingCodeCreated`             | Will be raised if a tracking code has been created. |
| `Gambio\Admin\Modules\TrackingCode\Model\Events\TrackingCodeDeleted`             | Will be raised if a tracking code has been removed. |