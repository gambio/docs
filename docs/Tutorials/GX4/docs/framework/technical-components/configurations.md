# Configurations

In the past it was difficult to understand how the Gambio shop system worked with configuration values. There were
different database tables and functions to read and edit the settings.

With GX v4 the configuration tables have been migrated to new database tables and a new `ConfigurationService` has been
implemented. This service can be used to retrieve, create, update and delete configurations.

If modules require shop settings and/or want to provide their configuration values, the `ConfigurationService`
should be used. This abstraction layer allows us to make further changes to the underlying data structure in the future
without jeopardizing the compatibility of external modules.

> All the Gambio core configurations are namespaced, depending on their location before the Shop-Version GX v4.1.x.
> E.g. all configurations which were previously located in the `gm_configuration` table has a prefix with `gm_configuration/`

## Read configurations

The configuration service provides the `find` and `findLanguageDependent` methods to read shop configurations. Both
methods may return null if no configuration was found with the given key. You can use `has` or `hasLanguageDependent`
first to ensure that these find methods returns a configuration object.

- `Gambio\Core\Configuration\Services\ConfigurationService`
    - `find(string $key): ?Gambio\Core\Configuration\Model\Interfaces\Configuration`
    - `findLanguageDependent(string $key, string $languageCode): ?Gambio\Core\Configuration\Model\Interfaces\LanguageDependentConfiguration`
    - `has(string $key): bool`
    - `hasLanguageDependent(string $key, string $languageCode): bool`

The method `find` returns a configuration object instance:

- `Gambio\Core\Configuration\Model\Interfaces\Configuration`
    - `key(): string`
    - `value(): ?string`
    - `sortOrder(): ?int`

Using the method `findLanguageDependent` returns a slightly more sophisticated configuration object instance:

- `Gambio\Core\Configuration\Model\Interfaces\LanguageDependentConfiguration`
    - `key(): string`
    - `value(): ?string`
    - `sortOrder(): ?int`
    - `languageCode(): string`

Once you have a configuration object, you can use the `value(): ?string` method to retrieve the value.
> The database schema allows configuration values to be `null`, so the method can also return `null`. Otherwise, the current value of the configuration is returned as a *string* type.

__Example:__

```php
namespace GXModules\<Vendor>\<Module>;

use Gambio\Core\Configuration\Services\ConfigurationService;

/**
 * Class SampleClass
 * @package GXModules\<Vendor>\<Module>
 */
class SampleClass
{
    /**
     * @var ConfigurationService
     */
    private $service;

    /**
     * SampleClass constructor.
     *
     * @param ConfigurationService $service
     */
    public function __construct(ConfigurationService $service)
    { 
        $this->service = $service;
    }


    public function example(): void
    {
        $configOrNull = $this->service->find('namespace/config-key');
        if ($this->service->has('namespace/config-key')) {
            $config = $this->service->find('namespace/config-key');
        }
        
        $langConfigOrNull = $this->service->findLanguageDependent('namespace/config-key', 'en');
        if ($this->service->hasLanguageDependent('namespace/config-key', 'en')) {
            $langConfig = $this->service->hasLanguageDependent('namespace/config-key', 'en');
        }
        
        // ...
    }
}
```

### Simpler abstraction for reading configuration values

Besides the configuration service, we also implemented a
simpler `Gambio\Core\Configuration\Services\ConfigurationFinder`
service, which can be used to fetch configuration values.

The following example shows you how to use it:

```php
namespace GXModules\<Vendor>\<Module>;

use Gambio\Core\Configuration\Services\ConfigurationFinder;

/**
 * Class SampleClass
 * @package GXModules\<Vendor>\<Module>
 */
class SampleClass
{
    /**
     * @var ConfigurationFinder
     */
    private $configurationFinder;

    /**
     * SampleClass constructor.
     *
     * @param ConfigurationFinder $configurationFinder
     */
    public function __construct(ConfigurationFinder $configurationFinder)
    { 
        $this->configurationFinder = $configurationFinder;
    }


    /**
     * @return string Returns a specific configuration value.
     */
    public function getSomeConfiguration(): string
    {
        $defaultValue = null;
        
        return $this->configurationFinder->get('namespace/my-configuration-key', $defaultValue);
    }
}
```

## Saving configurations

Configuration values can be saved using the `save`, `saveBulk`, `saveLanguageDependent` and `saveLanguageDependentBulk`
methods, depending on whether you want to store multiple values at the same time and whether you work with
language-dependent configurations.

- `Gambio\Core\Configuration\Services\ConfigurationService`
    - `save(string $key, ?string $value): void`
    - `saveBulk(array $configurations): void`
    - `saveLanguageDependent(string $key, string $languageCode, ?string $value): void`
    - `saveLanguageDependentBulk(array $configurations): void`

> New configurations are created using a unique key and existing will be updated by assigning an existing key.

__Example:__

```php
namespace GXModules\<Vendor>\<Module>;

use Gambio\Core\Configuration\Services\ConfigurationService;

/**
 * Class SampleClass
 * @package GXModules\<Vendor>\<Module>
 */
class SampleClass
{
    /**
     * @var ConfigurationService
     */
    private $service;

    /**
     * SampleClass constructor.
     *
     * @param ConfigurationService $service
     */
    public function __construct(ConfigurationService $service)
    { 
        $this->service = $service;
    }


    public function example(): void
    {
        $this->service->save('namespace/config-key', 'config-value');
        $this->service->saveBulk([
            'namespace/key'       => 'value',
            'namespace/other-key' => 'other-value'
        ]);
        
        $this->service->saveLanguageDependent('namespace/config-key', 'en', 'config-value');
        $this->service->saveLanguageDependentBulk([
            [
                'key'          => 'namespace/key',
                'value'        => 'value',
                'languageCode' => 'en',
            ],
            [
                'key'          => 'namespace/other-key',
                'value'        => 'other-value',
                'languageCode' => 'en',
            ]
        ]);
    }
}
```

## Delete configurations

For deleting configurations, the service provides the `delete(string ...$keys)` method. An unlimited number of
configuration keys can be passed to it and all associated values will be deleted. If one of the given values does not
exist, the entry will be skipped.

__Example:__

```php
namespace GXModules\<Vendor>\<Module>;

use Gambio\Admin\Configuration\ConfigurationService;

/**
 * Class SampleClass
 * @package GXModules\<Vendor>\<Module>
 */
class SampleClass
{
    /**
     * @var ConfigurationService
     */
    private $service;


    /**
     * SampleClass constructor.
     *
     * @param ConfigurationService $service
     */
    public function __construct(ConfigurationService $service)
    {
        $this->service = $service;
    }


    public function example(): void
    {
        $this->service->delete('namespace/foo', 'namespace/bar', 'namespace/baz');
    
        // or

        $keys = ['namespace/foo', 'namespace/bar', 'namespace/baz'];
        $this->service->delete(...$keys);
    }
}
```

!!! Notice "Notice"
    This example expects you to use the [Service Provider] to register your classes to the [Application Core].
    If you are using the legacy architecture, you need to fetch this service using the [Legacy DI Container].


[Application Core]: ./../application-core.md

[Service Provider]: ./../details/service-provider.md

[Legacy DI Container]: ./../details/di-container.md#legacy-di-container
