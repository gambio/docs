# User Configuration

The UserConfiguration service provides an api to fetch and save user configurations. Beside the service itself, which is
a class, there are utility methods providing the same functionality, but are easier to use.  
On the other hand, the class is easy to test and therefore defined as default export.

## Importing the UserConfiguration service

You can choose between importing the modules `UserConfigurationService` class or the utility methods.

```ts
import UserConfigurationService from 'core/UserConfigurationService';
// or
import {get, set} from 'core/UserConfigurationService';
```

## Using the UserConfiguration service

If you have chosen to import the modules class, you have to create an instance. The `UserConfiguration` instance
provides the same API as the `get` and `set` utility functions.

#### Example: Imported module class

```ts
const service = new UserConfigurationService();

const someConfig = await service.get('some-config');
await service.set('some-config', 'some-value');
```

#### Example: Imported utility functions
```ts
const someConfig = await get('some-config');
await set('some-config', 'some-value');
```
