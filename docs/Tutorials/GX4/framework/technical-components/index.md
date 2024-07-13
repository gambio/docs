# All available technical-related components 

Using the [DI Container], it's possible to request and use several services and components. The following
list shows all the available technical ones and their interfaces, which can be requested through the [DI Container]
or [Legacy DI Container].

!!! note "Notice"
    Please have in mind, that you can find the public API (public methods etc.) of a service following the namespace
    of this service and opening the corresponding PHP file.

__Available components:__

- `Doctrine\DBAL\Connection`:  
  [Doctrine DBAL]{target=_blank} class for database interactions.

- `Gambio\Core\Application\ValueObjects\Environment`:  
  Provides information about the environment mode of the shop.

- `Gambio\Core\Application\ValueObjects\Path`:  
  Provides information about the file server paths of the shop.

- `Gambio\Core\Application\ValueObjects\Server`:  
  Provides information about the server of the shop.

- `Gambio\Core\Application\ValueObjects\ServerInformation`:  
  Provides information about the server of the shop.

- `Gambio\Core\Application\ValueObjects\Url`:  
  Provides information about the URLs of the shop.

- `Gambio\Core\Application\ValueObjects\UserPreferences`:  
  Provides information about the user of the shop.

- `Gambio\Core\Auth\JsonWebTokenAuthenticator`:  
  Authenticates an admin based on a given JSON web token.

- `Gambio\Core\Auth\UserAuthenticator`:  
  Authenticates an admin based on a given user email address and password.

- `Gambio\Core\Cache\CacheFactory`:  
  Factory to create a file based data cache.

- `Gambio\Core\Command\Interfaces\CommandDispatcher`:  
  Dispatches any given command to the handlers, that had been registered for this command.

- `Gambio\Core\Configuration\ConfigurationFinder`:  
  Simple service class to fetch configuration values based on a configuration key.

- `Gambio\Core\Configuration\ConfigurationService`:  
  A more complex and powerful service class to for shop configurations.

- `Gambio\Core\Language\LanguageService`:  
  Provides available or specific languages of the shop.

- `Gambio\Core\Language\TextManager`:  
  Provides available or specific text phrases of the shop.

- `Gambio\Core\Logging\LoggerBuilder`:  
  Factory to create a logger.

- `Psr\EventDispatcher\EventDispatcherInterface`:  
  Dispatches any given event to the handlers, that had been registered for this event.



[DI Container]: ./../details/di-container.md
[Legacy DI Container]: ./../details/di-container.md#legacy-di-container
[Doctrine DBAL]: https://www.doctrine-project.org/projects/dbal.html
