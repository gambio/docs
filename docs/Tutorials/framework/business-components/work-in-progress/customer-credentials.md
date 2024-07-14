# Customer Credentials


The customers' credentials make the difference between a guest and a registered account. Without the corresponding
credentials a customer can't reactivate a session and therefore is determined as a guest account.

The current concept of the customer credentials only contain a proceeding that is based on a login (currently the email
address) and a password. Additional, only one combination of login and password can be set for each customer. To allow
more flexibility in the future, the new system can handle multiple types of credentials and allow their usage at the
same time, even if we keep the current limitation (mostly because of compatibility reasons and the lack of currently related features).

The following sections describe the domain, model, use cases, business rules, and events.


## Customer credentials domain


The customer credentials domain provides management functionality (create, read, update and delete).

This domain is part of the general customer management domain and is tightly linked to the [Customer] domain.


### Aggregate root and domain model


The aggregate root `Gambio\Admin\Modules\Customer\Submodules\Credential\Model\CustomerCredential` references one specific customer
credential. For the reason that this is an interface, there can be multiple implementation of customer credentials, each
with their own characteristics.

At the moment we have the following typs of customers' credentials:

- `CustomerBasicAuthCredential`:  
  This type uses the mostly known combination of a login and password. This combination ist often used to identify and
  authenticate a customer, e.g. in the Gambio Shop or the REST API.

![Aggregate root and domain model](diagrams/customer-address/model.png "Aggregate root and domain model"){.enlargeable .fullWidth}

## Read and write services

![Read and write service of the customer addresses](diagrams/customer-address/services.png ""){.enlargeable .fullWidth}

### Use cases using read service


#### Fetching all or a specific customer memo


// TODO: After we implemented the services.


### Use cases using write service


// TODO: After we implemented the services.


#### Creating a new customer memo


// TODO: After we implemented the services.


#### Creating multiple customer memos at once


// TODO: After we implemented the services.


#### Updating the customer memos content


// TODO: After we implemented the services.


#### Deleting a customer memo


// TODO: After we implemented the services.


## Business rules

- If a customer has been deleted the corresponding credentials need to be deleted as well.

## Domain events

| Event                                                                                                          | Description                                                                          |
|----------------------------------------------------------------------------------------------------------------|--------------------------------------------------------------------------------------|
| `Gambio\Admin\Modules\Customer\Submodules\Credential\Model\Events\CustomerBasicAuthCredentialCreated`          | Will be raised if a customer basic auth credential has been created.                 |
| `Gambio\Admin\Modules\Customer\Submodules\Credential\Model\Events\CustomerBasicAuthCredentialDeleted`          | Will be raised if a customer basic auth credential has been removed.                 |
| `Gambio\Admin\Modules\Customer\Submodules\Credential\Model\Events\CustomerBasicAuthCredentialsLoginUpdated`    | Will be raised if the login of a customer basic auth credential has been updated.    |
| `Gambio\Admin\Modules\Customer\Submodules\Credential\Model\Events\CustomerBasicAuthCredentialsPasswordUpdated` | Will be raised if the password of a customer basic auth credential has been updated. |

![Events of the customer addresses](diagrams/customer-address/events.png "Events of the customer addresses"){.enlargeable .fullWidth}

[Customer]: ./customer.md