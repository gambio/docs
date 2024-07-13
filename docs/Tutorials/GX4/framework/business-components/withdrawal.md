# Withdrawal

Withdrawals are created corresponding to a purchase order and must fulfill some legal terms. The shop software
provides multiple ways of creating a withdrawal. For instance, the creation can be done by a customer itself
or an admin and it can be created using the Web interface or the REST API.

The following sections describe the domain, model, use cases and business rules.


## Withdrawal domain

The withdrawal domain provides management functionality (create, read, update and delete), as well as the
possibility to filter all existing withdrawals. The most important thing to know about this domain is that
because of legal terms a customer only needs to provide an email address to revoke a purchase order.


### Aggregate root and domain model

The aggregate root `Gambio\Admin\Modules\Withdrawal\Model\Withdrawal` encapsulates details regarding the 
corresponding order and customer as well as a withdrawal date, content and a flag about who created the
withdrawal. After creation, the aggregate root only provides the possibility to change the order ID.


### Use cases using read service


#### Fetching all or a specific withdrawal

```
/** @var $readService \Gambio\Admin\Modules\Withdrawal\Services\WithdrawalReadService **/

$allWithdrawals     = $readService->getWithdrawals();
$specificWithdrawal = $readService->getWithdrawalById(1);
```


### Use cases using write service


#### Updating the order ID

```
/** @var $readService \Gambio\Admin\Modules\Withdrawal\Services\WithdrawalReadService **/
/** @var $writeService \Gambio\Admin\Modules\Withdrawal\Services\WithdrawalWriteService **/
/** @var $factory \Gambio\Admin\Modules\Withdrawal\Services\WithdrawalFactory **/

$withdrawal = $readService->getWithdrawalById(1);
$newOrderId = $factory->createOrderId(2);

$withdrawal->changeOrderId($newOrderId);

$writeService->storeWithdrawals($withdrawal);
```


#### Creating a new withdrawal

__Full example:__

```
/** @var $writeService \Gambio\Admin\Modules\Withdrawal\Services\WithdrawalWriteService **/
/** @var $factory \Gambio\Admin\Modules\Withdrawal\Services\WithdrawalFactory **/

$orderId      = 1;
$creationDate = '2020-01-01';
$deliveryDate = '2020-01-01';

$customerStreet   = 'Example street';
$customerPostcode = '12345';
$customerCity     = 'Example city';
$customerCountry  = 'Example country';

$email     = 'john-doe@example.com';
$address   = $factory->createCustomerAddress($customerStreet, $customerPostcode, $customerCity, $customerCountry);
$id        = 2;
$gender    ='m';
$firstname = 'John';
$lastname  = 'Doe';

$order          = $factory->createOrderDetails($orderId, $creationDate, $deliveryDate);
$customer       = $factory->createCustomerDetails($email, $address, $id, $gender, $firstname, $lastname);
$withdrawalDate = '2020-01-01';
$content        = 'Example content';
$createdByAdmin = false;

$id = $writeService->createWithdrawal($order, $customer, $withdrawalDate, $content, $createdByAdmin);
```

__Minimal example with default values:__

```
/** @var $writeService \Gambio\Admin\Modules\Withdrawal\Services\WithdrawalWriteService **/
/** @var $factory \Gambio\Admin\Modules\Withdrawal\Services\WithdrawalFactory **/

$email   = 'john-doe@example.com';
$address = $factory->createCustomerAddress();

$order    = $factory->createOrderDetails();
$customer = $factory->createCustomerDetails($email, $address);

$id = $writeService->createWithdrawal($order, $customer);
```


#### Creating multiple withdrawals at once

You can create multiple withdrawals at once if you provide all needed information as an array.

```
/** @var $writeService \Gambio\Admin\Modules\Withdrawal\Services\WithdrawalWriteService **/
/** @var $factory \Gambio\Admin\Modules\Withdrawal\Services\WithdrawalFactory **/

$email1  = 'john-doe-1@example.com';
$email2  = 'john-doe-2@example.com';
$email3  = 'john-doe-3@example.com';
$address = $factory->createCustomerAddress();

$order1          = $factory->createOrderDetails();
$order2          = $factory->createOrderDetails();
$order3          = $factory->createOrderDetails();
$customer1       = $factory->createCustomerDetails($email1, $address);
$customer2       = $factory->createCustomerDetails($email2, $address);
$customer3       = $factory->createCustomerDetails($email3, $address);
$withdrawalDates = ['2020-01-01', '2020-01-02', '2020-01-03'];

$ids = $writeService->createMultipleWithdrawals(
           [$order1, $customer1, $withdrawalDates[0]],
           [$order2, $customer2, $withdrawalDates[1]],
           [$order3, $customer3, $withdrawalDates[2]]
       );
```


#### Deleting withdrawals

```
/** @var $writeService \Gambio\Admin\Modules\Withdrawal\Services\WithdrawalWriteService **/

$id = 1;

$writeService->deleteWithdrawals($id);
// Method can handle multiple IDs like: $writeService->deleteWithdrawals($id1, $id2, $id3);
```


### Use cases using filter service


#### Filter all existing withdrawals including sorting and pagination

```
/** @var $filteredWithdrawals \Gambio\Admin\Modules\Withdrawal\Services\WithdrawalFilterService **/

$filters = [
    'createdByAdmin'    => '1',              // Withdrawal was created by an admin
    'customer.lastName' => '*Doe*',          // Customer last name contains "Doe"
    'createdOn'         => 'gte|2020-01-01', // Withdrawal was created after 2020-01-01
];
$sorting = '-customer.firstName,customer.lastName'; // In descending order of customers first name
                                                    // and ascending order of customers last name
$limit   = 25;
$offset  = 0;

$filteredWithdrawals             = $filterService->filterWithdrawals($filters, $sorting, $limit, $offset);
$totalCountOfFilteredWithdrawals = $filterService->getWithdrawalsTotalCount($filters);
```


##### Filtering

The filter array that is given to the filter service maps the attributes of the withdrawal and the filtering term.
The assigned string (e.g. `get|2020-01-01`) always contains the comparison value, but it also may contain an
operation (e.g. `gte` for greater than or equals to). Leaving the operation (e.g. `2020-01-01`) will be the same
as using *equals to* (`eq`).

The following table shows all attributes and the operations that can be used on them.


|                               | like (`*`) | equals to (`eq`) | lower than (`lt`) | lower than or equals to (`lte`) | greater than (`gt`) | greater than or equals to (`gte`) |
|-------------------------------|:----------:|:----------------:|:-----------------:|:-------------------------------:|:-------------------:|:---------------------------------:|
| `id`                          |            |        X         |         X         |                X                |          X          |                 X                 |
| `order.id`                    |            |        X         |         X         |                X                |          X          |                 X                 |
| `order.creationDate`          |            |        X         |         X         |                X                |          X          |                 X                 |
| `order.deliveryDate`          |            |        X         |         X         |                X                |          X          |                 X                 |
| `customer.id`                 |            |        X         |         X         |                X                |          X          |                 X                 |
| `customer.gender`             |     X      |        X         |                   |                                 |                     |                                   |
| `customer.firstName`          |     X      |        X         |                   |                                 |                     |                                   |
| `customer.lastName`           |     X      |        X         |                   |                                 |                     |                                   |
| `customer.address.street`     |     X      |        X         |                   |                                 |                     |                                   |
| `customer.address.postcode`   |     X      |        X         |                   |                                 |                     |                                   |
| `customer.address.city`       |     X      |        X         |                   |                                 |                     |                                   |
| `customer.address.country`    |     X      |        X         |                   |                                 |                     |                                   |
| `customer.email`              |     X      |        X         |                   |                                 |                     |                                   |
| `date`                        |            |        X         |         X         |                X                |          X          |                 X                 |
| `content`                     |     X      |        X         |                   |                                 |                     |                                   |
| `createdByAdmin`              |            |        X         |                   |                                 |                     |                                   |
| `createdOn`                   |            |        X         |        X          |               X                 |         X           |                X                  |


##### Sorting

To change the sorting, you can provide a string that describes the sorting order. The string must contain the
attributes used for sorting. If there is a minus (`-`) in front of the attribute, it will be sorted in descending
order. You can use multiple attributes to change the sorting order by linking them with a comma (`,`).


### Business rules

There are no specific business rules.


### Domain events

| Event | Description |
| ----- | ----------- |
| `Gambio\Admin\Modules\Withdrawal\Model\Events\WithdrawalCreated`         | Will be raised if a withdrawal has been created. |
| `Gambio\Admin\Modules\Withdrawal\Model\Events\WithdrawalDeleted`         | Will be raised if a withdrawal has been removed. |
| `Gambio\Admin\Modules\Withdrawal\Model\Events\WithdrawalsOrderIdUpdated` | Will be raised if an order ID has been updated. |
