# Customer Addon Value


External modules often need to add their own information about a specific customer. The addon values represent this
functionality and allows module developers to store additional data for specific customers, which can be stored,
updated, and deleted.

The following sections describe the domain, model, use cases, business rules, and events.


## Customer addon value domain


The customer addon values domain provides management functionality (create, read, update and delete), as well as the
possibility to filter all existing values.

This domain is part of the general customer management domain and is tightly linked to the [Customer] domain.


### Aggregate root and domain model


The aggregate root `Gambio\Admin\Modules\Customer\Submodules\AddonValues\Model\CustomerAddonValue` provides additional information
for a specific customer. Addon values have an uniq key to identify them and can store data as a string.

![Aggregate root and domain model](diagrams/customer-addon-value/model.png "Aggregate root and domain model"){.enlargeable .fullWidth}


## Read and write services


![Read and write service of the customer addon value's](diagrams/customer-addon-value/services.png ""){.enlargeable .fullWidth}


### Use cases using read service


#### Fetching all or a specific customer addon value

```php
/** @var $readService \Gambio\Admin\Modules\Customer\Submodules\AddonValues\Services\CustomerAddonValueReadService **/

$allCustomerAddonValues     = $readService->getCustomerAddonValues($customerId = 1);
$specificCustomerAddonValue = $readService->getCustomerAddonValue($customerId = 1, $key = 'key');
```

### Use cases using write service


#### Creating a new customer addon value

```php
/** @var $writeService \Gambio\Admin\Modules\Customer\Submodules\AddonValues\Services\CustomerAddonValueWriteService **/

$addonValueId = $writeService->createCustomerAddonValue($customerId = 1, $key = 'key', $value = 'value');
```

#### Creating multiple customer addon values at once

```php
/** @var $writeService \Gambio\Admin\Modules\Customer\Submodules\AddonValues\Services\CustomerAddonValueWriteService * */

$creationArguments = [
    [$customerId = 1, $key = 'key', $value = 'value'],
    [$customerId = 1, $key = 'key2', $value = 'value2'],
];

$addonValueId = $writeService->createMultipleCustomerAddonValues(...$creationArguments);
```

#### Updating an existing customer addon value

```php
/** @var $writeService \Gambio\Admin\Modules\Customer\Submodules\AddonValues\Services\CustomerAddonValueWriteService * */
/** @var $readService \Gambio\Admin\Modules\Customer\Submodules\AddonValues\Services\CustomerAddonValueReadService * */

$addonValue = $readService->getCustomerAddonValue($customerId = 1, $key = 'key');
$addonValue->changeValue($newValue = 'new-value');

$writeService->storeCustomerAddonValues($addonValue);
```

#### Deleting a customer addon value by customer addon value ID

```php
/** @var $writeService \Gambio\Admin\Modules\Customer\Submodules\AddonValues\Services\CustomerAddonValueWriteService **/

$addonValueIds = [
    ['customerId' = 1, 'key' = 'key'],
    ['customerId' = 1, 'key' = 'key2'],
];

$writeService->deleteCustomerAddonValuesByIds(...$addonValueIds);
```

#### Deleting a customer addon value by customers

```php
/** @var $writeService \Gambio\Admin\Modules\Customer\Submodules\AddonValues\Services\CustomerAddonValueWriteService **/

$customerIds = [1, 2];

$writeService->deleteCustomerAddonValuesByCustomerIds(...$customerIds);
```

#### Deleting a customer addon value by keys

```php
/** @var $writeService \Gambio\Admin\Modules\Customer\Submodules\AddonValues\Services\CustomerAddonValueWriteService **/

$keys = ['key1', 'key2'];

$writeService->deleteCustomerAddonValuesByKeys(...$keys);
```

### Safe and easy service to set and get customer addon values


#### Set a customer addon value

```php
/** @var $storage \Gambio\Admin\Modules\Customer\Submodules\AddonValues\Services\CustomerAddonValueStorage **/

$storage->setValue($customerId = 1, $key = 'my-key', $value = 'my-value');
```

#### Get a customer addon value

```php
/** @var $storage \Gambio\Admin\Modules\Customer\Submodules\AddonValues\Services\CustomerAddonValueStorage **/

$storage->getValue($customerId = 1, $key = 'my-key', $defaultValue = 'default-value');
```


#### Filter all existing customer addon values including sorting and pagination

```php
/** @var $filterService \Gambio\Admin\Modules\Customer\Submodules\AddonValues\Services\CustomerAddonValueFilterService **/

$customerId    = 1;
$filters       = ['value' => 'prefix*']; // Only show addon values their values start with "prefix"
$sorting       = '+key';    // in ascending order of the key
$filteredAddonValues = $filterService->filterCustomerAddonValues($customerId, $filters, $sorting);
```

##### Filtering


The filter array that is given to the filter service maps the attributes of the customer addon value and the filtering
term. The assigned string (e.g. `get|2022-01-01`) always contains the comparison value, but it also may contain an
operation (e.g. `gte` for greater than or equals to). Leaving the operation (e.g. `2022-01-01`)
will be the same as using *equals to* (`eq`).

The following table shows all attributes and the operations that can be used on them.

|              | like (`*`) | equals to (`eq`) | lower than (`lt`) | lower than or equals to (`lte`) | greater than (`gt`) | greater than or equals to (`gte`) |
|--------------|:----------:|:----------------:|:-----------------:|:-------------------------------:|:-------------------:|:---------------------------------:|
| `key`        |     X      |        X         |                   |                                 |                     |                                   |
| `value`      |     X      |        X         |                   |                                 |                     |                                   |

##### Sorting


To change the sorting, you can provide a string that describes the sorting order. The string must contain the attributes
used for sorting. If there is a minus (`-`) in front of the attribute, it will be sorted in descending order. You can
use multiple attributes to change the sorting order by linking them with a comma (`,`).


## Business rules

- If a customer has been deleted the corresponding addon values need to be deleted as well.
- The identifier is to be unique for each customer.

## Domain events

| Event                                                                                                  | Description                                                             |
|--------------------------------------------------------------------------------------------------------|-------------------------------------------------------------------------|
| `Gambio\Admin\Modules\Customer\Submodules\AddonValues\Model\Events\CustomerAddonValueCreated`          | Will be raised if a customer addon value has been created.              |
| `Gambio\Admin\Modules\Customer\Submodules\AddonValues\Model\Events\CustomerAddonValueDeleted`          | Will be raised if a customer addon value has been removed.              |
| `Gambio\Admin\Modules\Customer\Submodules\AddonValues\Model\Events\CustomerAddonValuesContentUpdated`  | Will be raised if the value of a customer addon value has been updated. |

![Events of the customer addon value's](diagrams/customer-addon-value/events.png "Events of the customer addon value's"){.enlargeable .fullWidth}

[Customer]: ./customer.md