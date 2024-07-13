# Customer


Customers are an essential part of the shop software. For ordering a product a visitor of the shop must create an
account. Each account is connected to other parts of the shop software like orders, reviews, addresses etc. Even the
admins are based on customer accounts and have extended permissions and additional functionalities.

Customers refer to a person that have a registered or guest account. A customer account is needed for certain actions
like placing orders, writing reviews, and so on.

The following sections describe the domain, model, use cases, business rules, and events.


## Customer Domain


The Customer domain provides management functionality (create, read, update and delete), as well as the possibility to
filter all existing customers.

It's linked with other domains which sums up to the general customer management domain:

- [Customer Memo]
- [Customer Addon Value]
- [Customer Credential]
- Customer Address
- Customer Address Addon Value
- Customer Group

### Aggregate root and domain model


The aggregate root `Gambio\Admin\Modules\Customer\Model\Customer` encapsulates personal, business, contact, and credit
information. A customer itself can be created as normal or guest account. Guest account can only be used temporary to
order products and can be deleted by an admin, if they aren't in use anymore.

Furthermore, a customer can be assigned a merchant state, which is mainly done by adding the customer to a specific
customer group (the merchants).

There are some configurations like disallowed payment and shipping methods or the newsletter subscription that are
customer-specific and can be configured by referencing an existing customer in services of other domains.

![Aggregate root and domain model](diagrams/customer/model.png "Aggregate root and domain model"){.enlargeable .fullWidth}


## Read and write services


![Read and write service of the customer memo's](diagrams/customer/services.png ""){.enlargeable .fullWidth}


### Use cases using read services


#### Fetching all or a specific customer

```php
/** @var $readService \Gambio\Admin\Modules\Customer\Services\CustomerReadService **/

$allCustomers     = $readService->getCustomers();
$allGuestAccounts = $readService->getGuestAccounts();
$specificCustomer = $readService->getCustomerById($customerId = 1);
```

### Use cases using write service


#### Creating a new customer (as guest account)

```php
use Gambio\Admin\Modules\Customer\Model\ValueObjects\CustomerGender;

/** @var $writeService \Gambio\Admin\Modules\Customer\Services\CustomerWriteService **/
/** @var $factory \Gambio\Admin\Modules\Customer\Services\CustomerFactory **/

$personalInformation = $factory->createPersonalInformation(
    $gender = CustomerGender::GENDER_DIVERSE, 
    $firstName = 'John', 
    $lastName = 'Doe', 
    $customerNumber = 'c-001', 
    $dateOfBirth = new DateTimeImmutable('1970-01-01 00:00:00')
);

$businessInformation = $factory->createBusinessInformation(
    $companyName = 'Gambio GmbH', $vatId = '', $isMerchant = false
);

$contactInformation = $factory->createContactInformation(
    $email = 'admin@example.org',
    $phoneNumber = '0170123456789',
    $faxNumber = '0170987654321'
);

$id = $writeService->createCustomer(
    $personalInformation, $businessInformation, $contactInformation,
    $credit = 10000, $isFavorite = false, $customerGroup = 1
);

// It's also possible to define them as guest accounts when creating them.
// Therefore, we provide a specific method in the write service:
// 
// $id = $writeService->createGuestAccount(
//     $personalInformation, $businessInformation, $contactInformation,
//     $credit = 10000, $isFavorite = false, $customerGroup = 1
// );
```

!!! note "Notice"
Please don't forget to create a default address, because the legacy frontend expects one for each customer.


#### Creating multiple customers (as guest accounts) at once

```php
use Gambio\Admin\Modules\Customer\Model\ValueObjects\CustomerGender;

/** @var $writeService \Gambio\Admin\Modules\Customer\Services\CustomerWriteService **/
/** @var $factory \Gambio\Admin\Modules\Customer\Services\CustomerFactory **/

$personalInformation = [
    $factory->createPersonalInformation(
        $gender = CustomerGender::GENDER_DIVERSE, 
        $firstName = 'John', 
        $lastName = 'Doe', 
        $customerNumber = 'c-001', 
        $dateOfBirth = new DateTimeImmutable('1970-01-01 00:00:00')
    ),
    $factory->createPersonalInformation(
        $gender = CustomerGender::GENDER_FEMALE, 
        $firstName = 'Jane', 
        $lastName = 'Doe', 
        $customerNumber = 'c-002', 
        $dateOfBirth = new DateTimeImmutable('1970-01-01 00:00:00')
    )
];

$businessInformation = [
    $factory->createBusinessInformation(
        $companyName = 'Gambio GmbH', $vatId = '', $isMerchant = false
    ),
    $factory->createBusinessInformation(
        $companyName = 'Gambio GmbH', $vatId = '', $isMerchant = false
    ),
];

$contactInformation  = [
    $factory->createContactInformation(
        $email = 'admin@example.org', $phoneNumber = '0170123456789',
        $faxNumber = '0170987654321'
    ),
    $factory->createContactInformation(
        $email = 'admin2@example.org', $phoneNumber = '0170123456789',
        $faxNumber = '0170987654321'
    ),
];

$creationArgs = [
    [
        $personalInformation[0], $businessInformation[0], $contactInformation[0], 
        $credits = 10000, $isFavorite = false, $customerGroup = 1,
    ],
    [
        $personalInformation[1], $businessInformation[1], $contactInformation[1], 
        $credits = 0, $isFavorite = true, $customerGroup = 2,
    ],
];

$ids = $writeService->createMultipleCustomers(...$creationArgs);

// It's also possible to define them as guest accounts when creating them.
// Therefore, we provide a specific method in the write service:
// 
// $ids = $writeService->createMultipleGuestAccounts(...$creationArgs);
```

!!! note "Notice"
Please don't forget to create a default address, because the legacy frontend expects one for each customer.


#### Updating the customers customer group

```php
use Gambio\Admin\Modules\Customer\Model\ValueObjects\CustomerGender;

/** @var $readService \Gambio\Admin\Modules\Customer\Services\CustomerReadService **/
/** @var $writeService \Gambio\Admin\Modules\Customer\Services\CustomerWriteService **/
/** @var $factory \Gambio\Admin\Modules\Customer\Services\CustomerFactory **/

$customerGroup = $this->factory->createCustomerGroup($customerGroup = 1);

$customer = $readService->getCustomerById($customerId = 1);
$customer->changeCustomerGroup($customerGroup);

$writeService->storeCustomers($customer);
```

#### Updating the customers personal information

```php
use Gambio\Admin\Modules\Customer\Model\ValueObjects\CustomerGender;

/** @var $readService \Gambio\Admin\Modules\Customer\Services\CustomerReadService **/
/** @var $writeService \Gambio\Admin\Modules\Customer\Services\CustomerWriteService **/
/** @var $factory \Gambio\Admin\Modules\Customer\Services\CustomerFactory **/

$personalInformation = $factory->createPersonalInformation(
    $gender = CustomerGender::GENDER_DIVERSE, 
    $firstName = 'John', 
    $lastName = 'Doe', 
    $customerNumber = 'c-001', 
    $dateOfBirth = new DateTimeImmutable('1970-01-01 00:00:00')
);

$customer = $readService->getCustomerById($customerId = 1);
$customer->changePersonalInformation($personalInformation);

$writeService->storeCustomers($customer);
```

#### Updating the customers business information

```php
/** @var $readService \Gambio\Admin\Modules\Customer\Services\CustomerReadService **/
/** @var $writeService \Gambio\Admin\Modules\Customer\Services\CustomerWriteService **/
/** @var $factory \Gambio\Admin\Modules\Customer\Services\CustomerFactory **/

$businessInformation = $factory->createBusinessInformation(
    $companyName = 'Gambio GmbH', $vatId = '', $isMerchant = false
);

$customer = $readService->getCustomerById($customerId = 1);
$customer->changeBusinessInformation($businessInformation);

$writeService->storeCustomers($customer);
```

#### Updating the customers contact information

```php
/** @var $readService \Gambio\Admin\Modules\Customer\Services\CustomerReadService **/
/** @var $writeService \Gambio\Admin\Modules\Customer\Services\CustomerWriteService **/
/** @var $factory \Gambio\Admin\Modules\Customer\Services\CustomerFactory **/

$contactInformation = $factory->createContactInformation(
    $email = 'admin@example.org', $phoneNumber = '0170123456789',
    $faxNumber = '0170987654321'
);

$customer = $readService->getCustomerById($customerId = 1);
$customer->changeContactInformation($contactInformation);

$writeService->storeCustomers($customer);
```

#### Updating the customers credit

```php
/** @var $readService \Gambio\Admin\Modules\Customer\Services\CustomerReadService **/
/** @var $writeService \Gambio\Admin\Modules\Customer\Services\CustomerWriteService **/
/** @var $factory \Gambio\Admin\Modules\Customer\Services\CustomerFactory **/

$customer = $readService->getCustomerById($customerId = 1);
$customer->changeCredit($factory->createCredit(0));

$writeService->storeCustomers($customer);
```

#### Updating the customers is-favorite state

```php
/** @var $readService \Gambio\Admin\Modules\Customer\Services\CustomerReadService **/
/** @var $writeService \Gambio\Admin\Modules\Customer\Services\CustomerWriteService **/
/** @var $factory \Gambio\Admin\Modules\Customer\Services\CustomerFactory **/

$customer = $readService->getCustomerById($customerId = 1);
$customer->changeIsFavoriteState(false);

$writeService->storeCustomers($customer);
```

#### Setting the customers password

```php
/** @var $passwordService \Gambio\Admin\Modules\Customer\Services\CustomerPasswordWriteService **/

$passwordService->setCustomerPassword($customerId = 1, $password = 'my-new-password');
```

#### Deleting a customer

```php
/** @var $writeService \Gambio\Admin\Modules\Customer\Services\CustomerWriteService **/
$ids = [1, 3, 5];

$writeService->deleteCustomers(...$ids);
```

#### Deleting a guest customers

```php
/** @var $writeService \Gambio\Admin\Modules\Customer\Services\CustomerWriteService **/

$writeService->deleteOutdatedGuestAccounts();
```

### Use cases using filter service


#### Filter all existing customers including sorting and pagination

```php
use Gambio\Admin\Modules\Customer\Model\ValueObjects\CustomerGender;

/** @var $filterService \Gambio\Admin\Modules\Customer\Services\CustomerFilterService **/

$filters = [
    'gender' => CustomerGender::GENDER_DIVERSE, // Customers with diverse gender
];
$sorting = '-id'; // In descending order of customer id

$filteredCustomers             = $filterService->filterCustomers(
    $filters, $sorting, $limit = 25, $offset = 0
);
$totalCountOfFilteredCustomers = $filterService->getCustomersTotalCount($filters);
```

##### Filtering


The filter array that is given to the filter service maps the attributes of the customer and the filtering term. The
assigned string (e.g. `get|2022-01-01`) always contains the comparison value, but it also may contain an operation
(e.g. `gte` for greater than or equals to). Leaving the operation (e.g. `2022-01-01`) will be the same as using *equals
to* (`eq`).

The following table shows all attributes and the operations that can be used on them.

|                                      | like (`*`) | equals to (`eq`) | lower than (`lt`) | lower than or equals to (`lte`) | greater than (`gt`) | greater than or equals to (`gte`) |
|--------------------------------------|:----------:|:----------------:|:-----------------:|:-------------------------------:|:-------------------:|:---------------------------------:|
| `id`                                 |            |        X         |         X         |                X                |          X          |                 X                 |
| `customerGroup`                      |            |        X         |         X         |                X                |          X          |                 X                 |
| `isGuestAccount`                     |            |        X         |                   |                                 |                     |                                   |
| `isFavorite`                         |            |        X         |                   |                                 |                     |                                   |
| `personalInformation.gender`         |     X      |        X         |                   |                                 |                     |                                   |
| `personalInformation.firstName`      |     X      |        X         |                   |                                 |                     |                                   |
| `personalInformation.lastName`       |     X      |        X         |                   |                                 |                     |                                   |
| `personalInformation.dateOfBirth`    |     X      |        X         |                   |                                 |                     |                                   |
| `personalInformation.customerNumber` |     X      |        X         |                   |                                 |                     |                                   |
| `contactInformation.email`           |     X      |        X         |                   |                                 |                     |                                   |
| `contactInformation.phoneNumber`     |     X      |        X         |                   |                                 |                     |                                   |
| `contactInformation.faxNumber`       |     X      |        X         |                   |                                 |                     |                                   |
| `businessInformation.companyName`    |     X      |        X         |                   |                                 |                     |                                   |
| `businessInformation.vatId`          |     X      |        X         |                   |                                 |                     |                                   |
| `businessInformation.isMerchant`     |            |        X         |                   |                                 |                     |                                   |
| `credit`                             |            |        X         |         X         |                X                |          X          |                 X                 |

##### Sorting


To change the sorting, you can provide a string that describes the sorting order. The string must contain the attributes
used for sorting. If there is a minus (`-`) in front of the attribute, it will be sorted in descending order. You can
use multiple attributes to change the sorting order by linking them with a comma (`,`).

### Use cases using search service

#### Search existing customers including sorting and pagination

```php
use Gambio\Admin\Modules\Customer\Model\ValueObjects\CustomerGender;

/** @var $searchService \Gambio\Admin\Modules\Customer\Services\CustomerSearchService **/

$searchTerm = 'Jon'
$sorting    = '-id'; // In descending order of customer id
$customers  = $filterService->searchCustomers($searchTerm, $sorting, $limit = 25, $offset = 0);

$totalCountOfSearchedCustomers = $filterService->getSearchedCustomerTotalCount($searchTerm);
```

## Business rules

- Customers can be guests. A guest account can only be used as long as the customer has an active (browser) session,
  therefore, these customers don’t have credentials. The same guests can be identified by the email address so that a
  new customer can replace an existing guest account when using the same email address.
- Guest account can only be deleted, if the configuration `DELETE_GUEST_ACCOUNT` is enabled and these users aren't
  online (which means, there is no entry in the `whos_online` DB table).
- The main admin (customer ID `1`) can't be deleted.
- An email address must be unique for registered accounts and can only be assigned to one single customer. This rule
  does not apply to guest accounts.
- A customer can be identified as a merchant if:
    - the `isMerchant` state is `true`.
    - the customer is part of a merchant customer group. In this case, the customer-specific `isMerchant` state is
      always `true` and can't be set to `false`.
- Minimal length of attributes (first name, street, etc.) is determined by the general shop configurations:
    - `ENTRY_CITY_MIN_LENGTH`
    - `ENTRY_COMPANY_MIN_LENGTH`
    - `ENTRY_DOB_MIN_LENGTH`
    - `ENTRY_EMAIL_ADDRESS_MIN_LENGTH`
    - `ENTRY_FIRST_NAME_MIN_LENGTH`
    - `ENTRY_HOUSENUMBER_MIN_LENGTH`
    - `ENTRY_LAST_NAME_MIN_LENGTH`
    - `ENTRY_PASSWORD_MIN_LENGTH`
    - `ENTRY_POSTCODE_MIN_LENGTH`
    - `ENTRY_STATE_MIN_LENGTH`
    - `ENTRY_STREET_ADDRESS_MIN_LENGTH`
    - `ENTRY_TELEPHONE_MIN_LENGTH`
  > __Note:__ This rule only apply for the registration process in the Gambio Shop so that these validations are not
  > part of the repository logic. We will enforce these rule in the Gambio Shop frontend and its corresponding backend.
- The attribute merchant can only be used, if the configuration `ACCOUNT_B2B_STATUS` is enabled.
- The attribute company name can only be used, if the configuration `ACCOUNT_COMPANY` is enabled.
- The attribute day of birth can only be used, if the configuration `ACCOUNT_DOB` is enabled.
- The attribute fax can only be used, if the configuration `ACCOUNT_FAX` is enabled.
- The attribute phone can only be used, if the configuration `ACCOUNT_TELEPHONE` is enabled.
- The attribute gender can only be used, if the configuration `ACCOUNT_GENDER` is enabled.
- The attribute gender is mandatory, if the configuration `GENDER_MANDATORY` is enabled.
- The attributes first name and last name are optional, if the configuration `ACCOUNT_NAMES_OPTIONAL` is enabled and a
  company name provided.

> __Note:__ This isn't a business rule of this domain, but if the configuration `ACCOUNT_DEFAULT_B2B_STATUS` is enabled
> the default value of the `isMerchant` state is `true`. When creating a customer and a VAT-ID is provided, it's
> possible to set/determine the `isMerchant` state based on the result of the validation of the VAT-ID.


## Domain events

| Event                                                                            | Description                                                            |
|----------------------------------------------------------------------------------|------------------------------------------------------------------------|
| `Gambio\Admin\Modules\Customer\Model\Events\CustomerCreated`                     | Will be raised if a customer has been created.                         |
| `Gambio\Admin\Modules\Customer\Model\Events\CustomerDeleted`                     | Will be raised if a customer has been removed.                         |
| `Gambio\Admin\Modules\Customer\Model\Events\CustomersPersonalInformationUpdated` | Will be raised if the customers personal information has been updated. |
| `Gambio\Admin\Modules\Customer\Model\Events\CustomersBusinessInformationUpdated` | Will be raised if the customers business information has been updated. |
| `Gambio\Admin\Modules\Customer\Model\Events\CustomersContactInformationUpdated`  | Will be raised if the customers contact information has been updated.  |
| `Gambio\Admin\Modules\Customer\Model\Events\CustomersCreditUpdated`              | Will be raised if the customers credit has been updated.               |
| `Gambio\Admin\Modules\Customer\Model\Events\CustomersFavoriteStateUpdated`       | Will be raised if the customers favoritization state has been updated. |

![Events of the customer's](diagrams/customer/events.png "Events of the customer's"){.enlargeable .fullWidth}

[Customer Memo]: ./customer-memo.md

[Customer Addon Value]: ./customer-addon-value.md

[Customer Credential]: ./customer-credentials.md