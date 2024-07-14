# Environment Variables

Working with the shop software sometimes requires the usage of some environment variables like paths on the webserver,
the base URL of the shop or the language the client is using. To give you all this information we added some
services (more or less value objects) that provide it for you.

The following examples show you which services are available and what information is provided.


## Environment

```php
namespace GXModules\<Vendor>\<Module>;

use Gambio\Core\Application\ValueObjects\Environment;

/**
 * Class SampleClass
 * @package GXModules\<Vendor>\<Module>
 */
class SampleClass
{
    /**
     * @var Environment
     */
    private $environment;
    
    
    /**
     * SampleClass constructor.
     *
     * @param Environment $environment
     */
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }
    
    
    /**
     * @return bool
     */
    public function isShopInDevEnvironment(): bool
    {
        return $this->environment->isDev();
    }
}
```

!!! Notice "Notice"
    This example expects you to use the [Service Provider] to register your classes to the [Application Core].
    It's **not possible** to fetch these value objects using the [Legacy DI Container]!


## Path

```php
namespace GXModules\<Vendor>\<Module>;

use Gambio\Core\Application\ValueObjects\Path;

/**
 * Class SampleClass
 * @package GXModules\<Vendor>\<Module>
 */
class SampleClass
{
    /**
     * @var Path
     */
    private $path;
    
    
    /**
     * SampleClass constructor.
     *
     * @param Path $path
     */
    public function __construct(Path $path)
    {
        $this->path = $path;
    }
    
    
    /**
     * @return string
     */
    public function getAbsoluteBasePathOfShop(): string
    {
        return $this->path->base();
    }
    
    
    /**
     * @return string
     */
    public function getAbsoluteBasePathOfAdmin(): string
    {
        return $this->path->admin();
    }
}
```

!!! Notice "Notice"
    This example expects you to use the [Service Provider] to register your classes to the [Application Core].
    It's **not possible** to fetch these value objects using the [Legacy DI Container]!


## Server

```php
namespace GXModules\<Vendor>\<Module>;

use Gambio\Core\Application\ValueObjects\Server;

/**
 * Class SampleClass
 * @package GXModules\<Vendor>\<Module>
 */
class SampleClass
{
    /**
     * @var Server
     */
    private $server;
    
    
    /**
     * SampleClass constructor.
     *
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }
    
    
    /**
     * @return bool
     */
    public function isSslEnabled(): bool
    {
        return $this->server->sslEnabled();
    }
    
    
    /**
     * @return string
     */
    public function getRequestUri(): string
    {
        return $this->server->requestUri();
    }
}
```

!!! Notice "Notice"
    This example expects you to use the [Service Provider] to register your classes to the [Application Core].
    It's **not possible** to fetch these value objects using the [Legacy DI Container]!


## ServerInformation

```php
namespace GXModules\<Vendor>\<Module>;

use Gambio\Core\Application\ValueObjects\ServerInformation;

/**
 * Class SampleClass
 * @package GXModules\<Vendor>\<Module>
 */
class SampleClass
{
    /**
     * @var ServerInformation
     */
    private $serverInformation;
    
    
    /**
     * SampleClass constructor.
     *
     * @param ServerInformation $serverInformation
     */
    public function __construct(ServerInformation $serverInformation)
    {
        $this->serverInformation = $serverInformation;
    }
    
    
    /**
     * @return bool
     */
    public function isModRewriteAvailable(): bool
    {
        return $this->serverInformation->modRewriteAvailable();
    }
    
    
    /**
     * @return bool
     */
    public function isModRewriteWorking(): bool
    {
        return $this->serverInformation->modRewriteWorking();
    }
    
    
    /**
     * @return bool
     */
    public function isHtaccessVersionAvailable(): bool
    {
        return $this->serverInformation->htaccessVersionAvailable();
    }
    
    
    /**
     * @return bool
     */
    public function isAvailableHtaccessVersionGreaterThan(string $version): bool
    {
        return $this->serverInformation->htaccessVersionGreaterEquals($version);
    }
}
```

!!! Notice "Notice"
    This example expects you to use the [Service Provider] to register your classes to the [Application Core].
    It's **not possible** to fetch these value objects using the [Legacy DI Container]!


## Url

```php
namespace GXModules\<Vendor>\<Module>;

use Gambio\Core\Application\ValueObjects\Url;

/**
 * Class SampleClass
 * @package GXModules\<Vendor>\<Module>
 */
class SampleClass
{
    /**
     * @var Url
     */
    private $url;
    
    
    /**
     * SampleClass constructor.
     *
     * @param Url $url
     */
    public function __construct(Url $url)
    {
        $this->url = $url;
    }
    
    
    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->url->host();
    }
    
    
    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->url->path();
    }
    
    
    /**
     * @return string
     */
    public function getBaseUrlToShop(): string
    {
        return $this->url->base();
    }
    
    
    /**
     * @return string
     */
    public function getBaseUrlToAdmin(): string
    {
        return $this->url->admin();
    }
}
```

!!! Notice "Notice"
    This example expects you to use the [Service Provider] to register your classes to the [Application Core].
    It's **not possible** to fetch these value objects using the [Legacy DI Container]!


## UserPreferences

```php
namespace GXModules\<Vendor>\<Module>;

use Gambio\Core\Application\ValueObjects\UserPreferences;

/**
 * Class SampleClass
 * @package GXModules\<Vendor>\<Module>
 */
class SampleClass
{
    /**
     * @var UserPreferences
     */
    private $userPreferences;
    
    
    /**
     * SampleClass constructor.
     *
     * @param UserPreferences $userPreferences
     */
    public function __construct(UserPreferences $userPreferences)
    {
        $this->userPreferences = $userPreferences;
    }
    
    
    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userPreferences->userId();
    }
    
    
    /**
     * @return bool
     */
    public function isUserAuthenticated(): bool
    {
        return $this->userPreferences->isAuthenticated();
    }
    
    
    /**
     * @return int
     */
    public function getLanguageId(): int
    {
        return $this->userPreferences->languageId();
    }
}
```

!!! Notice "Notice"
    This example expects you to use the [Service Provider] to register your classes to the [Application Core].
    It's **not possible** to fetch these value objects using the [Legacy DI Container]!



[Application Core]: ./../application-core.md
[Service Provider]: ./../details/service-provider.md
[Legacy DI Container]: ./../details/di-container.md#legacy-di-container
