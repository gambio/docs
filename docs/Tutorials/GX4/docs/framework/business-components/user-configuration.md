# User Configuration

User configurations are similar to normal shop wide configurations, but for a specific user. An example for data that is
stored as a user configuration is the state of the admin navigation (expand, expand all, collapse).

The following sections describe the domain, model, use cases and business rules.


## User configuration domain

The user configuration domain provides a very minimalistic feature-set of accessing and storing user configurations. A
user configuration always belongs to one specific user, while a user can be a normal customer or an admin of the shop
software.

### Aggregate root and domain model

The aggregate root `Gambio\Core\UserConfiguration\Model\UserConfiguration` provides the user ID, as well as the
configuration key and value. It's also possible to change to value of a user configuration. The configuration key and
value can only be strings.

### Use cases using the current user configuration service

The `Gambio\Core\UserConfiguration\Services\CurrentUserConfigurationService` service always provides and stores
configuration values for the current logged-in user. That way, you don't need to fetch the user ID of the current user
from the session or somewhere else.

#### Fetching a specific user configuration value

```
/** $readService \Gambio\Core\UserConfiguration\Services\CurrentUserConfigurationService **/

$defaultValue = 'my-default-value'; // Otherwise, the service would return `null`

$specificUserConfigurationValue = $readService->getValue('my-config-key', $defaultValue);
```


#### Storing a specific user configuration value

```
/** $readService \Gambio\Core\UserConfiguration\Services\CurrentUserConfigurationService **/

$configKey   = 'my-key';
$configValue = 'my-value';

$readService->storeConfiguration($configKey, $configValue);
```


### Business rules

There are no specific business rules.


### Domain events

| Event | Description |
| ----- | ----------- |
| `Gambio\Core\UserConfiguration\Model\Events\UserConfigurationCreated`      | Will be raised if a user configuration has been created. |
| `Gambio\Core\UserConfiguration\Model\Events\UserConfigurationValueUpdated` | Will be raised if a user configuration has been updated. |