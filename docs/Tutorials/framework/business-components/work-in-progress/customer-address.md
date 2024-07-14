# Work in progress - Customer Address

Each customer need to provide an address while registering, but it's possible add and manage additional addresses.
These customer addresses are used for payment or shipping and can be selected in the checkout process.

The following sections describe the model, use cases, business rules, and events.


### Aggregate root and domain model

The aggregate root `Gambio\Admin\Modules\Customer\Submodules\Address\Model\CustomerAddress` provides information like street name,
house number, city, and similar. Addresses can be marked as default shipping or payment addresses.


### Use cases using read service


#### Fetching all or a specific customer address

```
/** $readService \Gambio\Admin\Modules\Customer\Submodules\Address\Services\CustomerAddressReadService **/

$allCustomerAddresses    = $readService->getAllCustomerAddresses();
$allCustomersAddresses   = $readService->getCustomerAddressesByCustomerId(1);
$specificCustomerAddress = $readService->getCustomerAddressById(1);
$defaultPaymentAddress   = $readService->getDefaultPaymentAddressByCustomerId(1);
$defaultShippingAddress  = $readService->getDefaultShippingAddressByCustomerId(1);
```


### Use cases using write service


#### Updating the personal details

```
/** $readService \Gambio\Admin\Modules\Customer\Submodules\Address\Services\CustomerAddressReadService **/
/** $writeService \Gambio\Admin\Modules\Customer\Submodules\Address\Services\CustomerAddressWriteService **/
/** $factory \Gambio\Admin\Modules\Customer\Submodules\Address\Services\CustomerAddressFactory **/

$gender           = 'm'; // or $gender = \Gambio\Admin\Modules\Customer\Submodules\Address\Model\CustomerAddress::GENDER_MALE;
$firstName        = 'John';
$lastName         = 'Doe';
$companyName      = 'Gambio GmbH';
$personalDetails  = $factory->createPersonalDetails($gender, $firstName, $lastName, $companyName);

$customerAddress = $readService->getCustomerAddressById(1);
$customerAddress->updatePersonalDetails($personalDetails);

$writeService->storeCustomerAddresses($customerAddress);
// Method can handle multiple customer addresses like:
// $writeService->storeCustomerAddresses($customerAddress1, $customerAddress2, $customerAddress3);
```


#### Updating the location details

```
/** $readService \Gambio\Admin\Modules\Customer\Submodules\Address\Services\CustomerAddressReadService **/
/** $writeService \Gambio\Admin\Modules\Customer\Submodules\Address\Services\CustomerAddressWriteService **/
/** $factory \Gambio\Admin\Modules\Customer\Submodules\Address\Services\CustomerAddressFactory **/

$street          = 'Parallelweg';
$houseNumber     = '30';
$additionalInfo  = '';
$suburb          = '';
$postcode        = '28217';
$city            = 'Bremen';
$state           = 'Bremen';
$countryId       = 81;
$zoneId          = 1355;
$locationDetails = $factory->createLocationDetails(
                       $street,
                       $houseNumber,
                       $additionalInfo,
                       $suburb,
                       $postcode,
                       $city,
                       $state,
                       $countryId,
                       $zoneId
                   );

$customerAddress = $readService->getCustomerAddressById(1);
$customerAddress->updateLocationDetails($personalDetails);

$writeService->storeCustomerAddresses($customerAddress);
// Method can handle multiple customer addresses like:
// $writeService->storeCustomerAddresses($customerAddress1, $customerAddress2, $customerAddress3);
```


#### Mark as default payment address

```
/** $readService \Gambio\Admin\Modules\Customer\Submodules\Address\Services\CustomerAddressReadService **/
/** $writeService \Gambio\Admin\Modules\Customer\Submodules\Address\Services\CustomerAddressWriteService **/
/** $factory \Gambio\Admin\Modules\Customer\Submodules\Address\Services\CustomerAddressFactory **/

$customerAddress = $readService->getCustomerAddressById(1);
$customerAddress->setAsPaymentDefaultAddress();

$writeService->storeCustomerAddresses($customerAddress);
// Method can handle multiple customer addresses like:
// $writeService->storeCustomerAddresses($customerAddress1, $customerAddress2, $customerAddress3);
```


#### Mark as default shipping address

```
/** $readService \Gambio\Admin\Modules\Customer\Submodules\Address\Services\CustomerAddressReadService **/
/** $writeService \Gambio\Admin\Modules\Customer\Submodules\Address\Services\CustomerAddressWriteService **/
/** $factory \Gambio\Admin\Modules\Customer\Submodules\Address\Services\CustomerAddressFactory **/

$customerAddress = $readService->getCustomerAddressById(1);
$customerAddress->setAsShippingDefaultAddress();

$writeService->storeCustomerAddresses($customerAddress);
// Method can handle multiple customer addresses like:
// $writeService->storeCustomerAddresses($customerAddress1, $customerAddress2, $customerAddress3);
```


#### Creating a new customer address

```
/** $writeService \Gambio\Admin\Modules\Customer\Submodules\Address\Services\CustomerAddressWriteService **/
/** $factory \Gambio\Admin\Modules\Customer\Submodules\Address\Services\CustomerAddressFactory **/

$gender      = 'm'; // or $gender = \Gambio\Admin\Modules\Customer\Submodules\Address\Model\CustomerAddress::GENDER_MALE;
$firstName   = 'John';
$lastName    = 'Doe';
$companyName = 'Gambio GmbH';

$street         = 'Parallelweg';
$houseNumber    = '30';
$additionalInfo = '';
$suburb         = '';
$postcode       = '28217';
$city           = 'Bremen';
$state          = 'Bremen';
$countryId      = 81;
$zoneId         = 1355;

$customerId      = 1;
$personalDetails = $factory->createPersonalDetails($gender, $firstName, $lastName, $companyName);
$locationDetails = $factory->createLocationDetails(
                       $street, $houseNumber, $additionalInfo, $suburb,
                       $postcode, $city, $state, $countryId, $zoneId
                   );

$id = $writeService->createCustomerAddress($customerID, $personalDetails, $locationDetails);
```


#### Creating multiple customer addresses at once

You can create multiple customer addresses at once if you provide all needed information as an array.

```
/** $writeService \Gambio\Admin\Modules\Customer\Submodules\Address\Services\CustomerAddressWriteService **/
/** $factory \Gambio\Admin\Modules\Customer\Submodules\Address\Services\CustomerAddressFactory **/

$genders      = ['m', 'w'];
$firstNames   = ['John', 'Jane'];
$lastNames    = ['Doe', 'Doe'];
$companyNames = ['Gambio GmbH', 'Gambio GmbH'];

$streets         = ['Parallelweg', 'Parallelweg'];
$houseNumbers    = ['30', '30'];
$additionalInfos = ['', ''];
$suburbs         = ['', ''];
$postcodes       = ['28217', '28217'];
$citys           = ['Bremen', 'Bremen'];
$states          = ['Bremen', 'Bremen'];
$countryIds      = [81, 81];
$zoneIds         = [1355, 1355];

$customerIds     = [1, 1];
$personalDetails = [
                        $factory->createPersonalDetails($genders[0], $firstNames[0], $lastNames[0], $companyNames[0]),
                        $factory->createPersonalDetails($genders[1], $firstNames[1], $lastNames[1], $companyNames[1]),
                   ];
$locationDetails = [
                        $factory->createLocationDetails(
                            $streets[0], $houseNumbers[0], $additionalInfos[0], $suburbs[0],
                            $postcodes[0], $citys[0], $states[0], $countryIds[0], $zoneIds[0]
                        ),
                        $factory->createLocationDetails(
                            $streets[1], $houseNumbers[1], $additionalInfos[1], $suburbs[1],
                            $postcodes[1], $citys[1], $states[1], $countryIds[1], $zoneIds[1]
                        ),
                    ];

$ids = $writeService->createMultipleCustomerAddresses(
           [$customerIds[0], $personalDetails[0], $locationDetails[0]],
           [$customerIds[1], $personalDetails[1], $locationDetails[1]]
       );
```


#### Delete customer addresses

```
/** $writeService \Gambio\Admin\Modules\Customer\Submodules\Address\Services\CustomerAddressWriteService **/

$id = 1;

$writeService->deleteCustomerAddresses($id);
// Method can handle multiple IDs like: $writeService->deleteCustomerAddresses($id1, $id2, $id3);
```


### Use cases using filter service


#### Filter all customer addresses including sorting and pagination

```
/** $filterService \Gambio\Admin\Modules\Customer\Submodules\Address\Services\CustomerAddressFilterService **/

$filters    = [
    'companyNames' => '*Gambio*', // Company name contains "Gambio"
];
$sorting    = '-createdOn'; // In descending order of creation date
$limit      = 25;
$offset     = 0;

$filteredCustomerAddresses             = $filterService->filterCustomerAddresses($filters, $sorting, $limit, $offset);
$totalCountOfFilteredCustomerAddresses = $filterService->getCustomerAddressesTotalCount($filters);
```


##### Filtering

The filter array that is given to the filter service maps the attributes of the customer address and the filtering term.
The assigned string (e.g. `get|2020-01-01`) always contains the comparison value, but it also may contain an
operation (e.g. `gte` for greater than or equals to). Leaving the operation (e.g. `2020-01-01`) will be the same
as using *equals to* (`eq`).

The following table shows all attributes and the operations that can be used on them.


|   | like (`*`) | equals to (`eq`) | lower than (`lt`) | lower than or equals to (`lte`) | greater than (`gt`) | greater than or equals to (`gte`) |
|---|:---:|:---:|:---:|:---:|:---:|:---:|
| `id`                      |   | X | X | X | X | X |
| `customerId`              |   | X | X | X | X | X |
| `isPaymentDefault`        |   | X |   |   |   |   |
| `isShippingDefault`       |   | X |   |   |   |   |
| `personal.gender`         | X | X |   |   |   |   |
| `personal.firstName`      | X | X |   |   |   |   |
| `personal.lastName`       | X | X |   |   |   |   |
| `personal.companyName`    | X | X |   |   |   |   |
| `location.street`         | X | X |   |   |   |   |
| `location.houseNumber`    | X | X |   |   |   |   |
| `location.additionalInfo` | X | X |   |   |   |   |
| `location.suburb`         | X | X |   |   |   |   |
| `location.postcode`       | X | X |   |   |   |   |
| `location.city`           | X | X |   |   |   |   |
| `location.state`          | X | X |   |   |   |   |
| `location.countryId`      | X | X |   |   |   |   |
| `location.zoneId`         | X | X |   |   |   |   |
| `createdOn`               |   | X | X | X | X | X |
| `lastModified`            |   | X | X | X | X | X |


##### Sorting

To change the sorting, you can provide a string that describes the sorting order. The string must contain the
attributes used for sorting. If there is a minus (`-`) in front of the attribute, it will be sorted in descending
order. You can use multiple attributes to change the sorting order by linking them with a comma (`,`).


### Business rules

- Minimal length of attributes (first name, street, etc.) is determined by the general shop configurations.
  - `ENTRY_CITY_MIN_LENGTH`
  - `ENTRY_COMPANY_MIN_LENGTH`
  - `ENTRY_FIRST_NAME_MIN_LENGTH`
  - `ENTRY_HOUSENUMBER_MIN_LENGTH`
  - `ENTRY_LAST_NAME_MIN_LENGTH`
  - `ENTRY_PASSWORD_MIN_LENGTH`
  - `ENTRY_POSTCODE_MIN_LENGTH`
  - `ENTRY_STATE_MIN_LENGTH`
  - `ENTRY_STREET_ADDRESS_MIN_LENGTH`
  - `ENTRY_TELEPHONE_MIN_LENGTH`
- Each customer can only have one default payment and shipping address.
- The attribute gender can only be used, if the configuration `ACCOUNT_ADDITIONAL_INFO` is enabled.
- The attribute state can only be used, if the configuration `ACCOUNT_STATE` is enabled.
- The attribute suburb can only be used, if the configuration `ACCOUNT_SUBURB` is enabled.
- The attribute suburb can only be used, if the configuration `ACCOUNT_SUBURB` is enabled.
- The attributes street and house number are splitted, if the configuration `ACCOUNT_SPLIT_STREET_INFORMATION` is enabled.


### Domain events

| Event | Description |
| ----- | ----------- |
| `Gambio\Admin\Modules\Customer\Submodules\Address\Model\Events\CustomerAddressCreated`                  | Will be raised if a customer address has been created. |
| `Gambio\Admin\Modules\Customer\Submodules\Address\Model\Events\CustomerAddressDeleted`                  | Will be raised if a customer address has been removed. |
| `Gambio\Admin\Modules\Customer\Submodules\Address\Model\Events\CustomersPaymentMarkedAsDefaultAddress`  | Will be raised if a customer address has been marked as payment default address. |
| `Gambio\Admin\Modules\Customer\Submodules\Address\Model\Events\CustomersShippingMarkedAsDefaultAddress` | Will be raised if a customer address has been marked as shipping default address. |
| `Gambio\Admin\Modules\Customer\Submodules\Address\Model\Events\CustomerAddressLocationDetailsUpdate`    | Will be raised if the location details has been updated. |
| `Gambio\Admin\Modules\Customer\Submodules\Address\Model\Events\CustomerAddressPersonalDetailsUpdate`    | Will be raised if the personal details has been updated. |
