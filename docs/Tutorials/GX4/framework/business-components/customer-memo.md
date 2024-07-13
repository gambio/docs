# Customer Memo


An admin can create and add memos to customers, which are visible to other admins. These memos can be used to store and
provide information about a specific customer to other admins.

The following sections describe the domain, model, use cases, business rules, and events.


## Customer memo domain


The customer memos domain provides management functionality (create, read, update and delete), as well as the
possibility to filter all existing memos.

This domain is part of the general customer management domain and is tightly linked to the [Customer] domain.


### Aggregate root and domain model


The aggregate root `Gambio\Admin\Modules\Customer\Submodules\Memos\Model\CustomerMemo` references one specific customer memo.

A customer memo encapsulates information like the author/creator, a memo content, and timestamps for creation and the
last update. Beside creation and deletion, it's only possible to update the content of a memo.

![Aggregate root and domain model](diagrams/customer-memo/model.png "Aggregate root and domain model"){.enlargeable .fullWidth}


## Read and write services

![Read and write service of the customer memo's](diagrams/customer-memo/services.png ""){.enlargeable .fullWidth}


### Use cases using read service


#### Fetching all or a specific customer memo

```php
/** @var $readService \Gambio\Admin\Modules\Customer\Submodules\Memos\Services\CustomerMemoReadService **/

$allCustomerMemos     = $readService->getCustomerMemos($customerId = 1);
$specificCustomerMemo = $readService->getCustomerMemoById($memoId = 1);
```


### Use cases using write service


#### Creating a new customer memo

```php
/** @var $writeService \Gambio\Admin\Modules\Customer\Submodules\Memos\Services\CustomerMemoWriteService **/

$memoId = $writeService->createCustomerMemo(
    $customerId = 1, $creatorId = 2, $content = 'important note about a customer'
);
```


#### Creating multiple customer memos at once

```php
/** @var $writeService \Gambio\Admin\Modules\Customer\Submodules\Memos\Services\CustomerMemoWriteService **/

$creationArguments = [
    [
        $customerId = 1, 
        $creatorId = 2, 
        $content = 'important note about a customer'    
    ],
    [
        $customerId = 1, 
        $creatorId = 2, 
        $content = 'a second important note about a customer'    
    ],
];

$memoId = $writeService->createMultipleCustomerMemos(...$creationArguments);
```

#### Updating the customer memos content

```php
/** @var $writeService \Gambio\Admin\Modules\Customer\Submodules\Memos\Services\CustomerMemoWriteService **/
/** @var $readService \Gambio\Admin\Modules\Customer\Submodules\Memos\Services\CustomerMemoReadService **/

$memo = $readService->getCustomerMemoById($memoId = 1);
$memo->changeContent($content = 'updated memo text');

$writeService->storeCustomerMemos($memo);
```


#### Deleting a customer memo

```php
/** @var $writeService \Gambio\Admin\Modules\Customer\Submodules\Memos\Services\CustomerMemoWriteService **/

$memoIds = [1, 2];

$writeService->deleteCustomerMemosByMemoIds(...$memoIds);
```

```php
/** @var $writeService \Gambio\Admin\Modules\Customer\Submodules\Memos\Services\CustomerMemoWriteService **/

$customerIds = [1, 2];

$writeService->deleteCustomerMemosByCustomerIds(...$customerIds);
```


### Use cases using filter service


#### Filter all existing customer memos including sorting and pagination

```php
/** @var $filterService \Gambio\Admin\Modules\Customer\Submodules\Memos\Services\CustomerMemoFilterService **/

$customerId    = 1;
$filters       = ['creatorId' => 1]; // Only show memos created by admin with ID 1
$sorting       = '+creationTime';    // in ascending order of the creation date
$filteredMemos = $filterService->filterCustomerMemos($customerId, $filters, $sorting);     
```


##### Filtering


The filter array that is given to the filter service maps the attributes of the customer memo and the filtering term.
The assigned string (e.g. `get|2022-01-01`) always contains the comparison value, but it also may contain an operation
(e.g. `gte` for greater than or equals to). Leaving the operation (e.g. `2022-01-01`) will be the same as using *equals
to* (`eq`).

The following table shows all attributes and the operations that can be used on them.


|                 | like (`*`) | equals to (`eq`) | lower than (`lt`) | lower than or equals to (`lte`) | greater than (`gt`) | greater than or equals to (`gte`) |
|-----------------|:----------:|:----------------:|:-----------------:|:-------------------------------:|:-------------------:|:---------------------------------:|
| `id`            |            |        X         |         X         |                X                |          X          |                 X                 |
| `creatorId`     |            |        X         |         X         |                X                |          X          |                 X                 |
| `content`       |     X      |        X         |                   |                                 |                     |                                   |
| `creationTime`  |            |        X         |         X         |                X                |          X          |                 X                 |
| `updatedAtTime` |            |        X         |         X         |                X                |          X          |                 X                 |

##### Sorting


To change the sorting, you can provide a string that describes the sorting order. The string must contain the attributes
used for sorting. If there is a minus (`-`) in front of the attribute, it will be sorted in descending order. You can
use multiple attributes to change the sorting order by linking them with a comma (`,`).


## Business rules

- If a customer has been deleted the corresponding memos need to be deleted as well.
- The content can't be whitespace only.


## Domain events

| Event                                                                        | Description                                                        |
|------------------------------------------------------------------------------|--------------------------------------------------------------------|
| `Gambio\Admin\Modules\Customer\Submodules\Memos\Model\Events\CustomerMemoCreated`         | Will be raised if a customer memo has been created.                |
| `Gambio\Admin\Modules\Customer\Submodules\Memos\Model\Events\CustomerMemoDeleted`         | Will be raised if a customer memo has been removed.                |
| `Gambio\Admin\Modules\Customer\Submodules\Memos\Model\Events\CustomerMemosContentUpdated` | Will be raised if the content of a customer memo has been updated. |

![Events of the customer memo's](diagrams/customer-memo/events.png "Events of the customer memo's"){.enlargeable .fullWidth}

[Customer]: ./customer.md