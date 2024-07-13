# Cache

Caching is an important thing in software development. Therefore, we provide several services that provide all needed
functionalities around this topic.


## Creating and using a cache

To cache data for a certain time, we provide the `Gambio\Core\Cache\CacheFactory`. This factory can be used to create
a file-based data cache that is based on [PSR-16]{target=_blank} (`Psr\SimpleCache\CacheInterface`) or a simpler
one that catches and handles the `InvalidArgumentException` exceptions of the PSR.

The file-based data cache provides the querying, adding and deleting of single and multiple caches. In addition,
a so-called *time-to-life* can be defined for a cache, after which the cache automatically expires. The cached
data is stored in the `cache` folder of the main directory, where the chosen namespace serves as prefix for the
cache files.

The following example shows how you could use the factory to create these both caches:

```php
namespace GXModules\<Vendor>\<Module>;

use Gambio\Core\Cache\Services\CacheFactory;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * Class SampleClass
 * @package GXModules\<Vendor>\<Module>
 */
class SampleClass
{
    /**
     * @var CacheInterface
     */
    private $safeCache;

    /**
     * @var CacheInterface
     */
    private $psrCache;
    
    
    /**
     * SampleClass constructor.
     *
     * @param CacheFactory $cacheFactory
     */
    public function __construct(CacheFactory $cacheFactory)
    {
        $this->safeCache = $cacheFactory->createCacheFor('sample-cache-namespace');
        $this->psrCache  = $cacheFactory->createPsrCacheFor('another-sample-cache-namespace');
    }
    
    
    /**
     * @return mixed
     */
    public function getMyCache()
    {
        return $this->safeCache->get('my-cache', 'some-default-value');
    }
    
    
    /**
     * @return mixed
     */
    public function getMyCacheWithPsr()
    {
        try {
            return $this->psrCache->get('my-cache', 'some-default-value');
        } catch (InvalidArgumentException $e) {
            return 'some-default-value';
        }
    }
    
    
    /**
     * @return array
     */
    public function getMultipleCaches(): array
    {
        return $this->safeCache->getMultiple(['my-cache', 'my-second-cache'], 'some-default-value');
    }
    
    
    /**
     * @return array
     */
    public function getMultipleCachesWithPsr(): array
    {
        try {
            return $this->psrCache->getMultiple(['my-cache', 'my-second-cache'], 'some-default-value');
        } catch (InvalidArgumentException $e) {
            return [];
        }
    }
    
    
    /**
     * @return bool
     */
    public function setMyCache(): bool
    {
        return $this->safeCache->set('my-cache', 'some-value', 60 * 60 * 24);
    }
    
    
    /**
     * @return bool
     */
    public function setMyCacheWithPsr(): bool
    {
        try {
            return $this->psrCache->set('my-cache', 'some-value', 60 * 60 * 24);
        } catch (InvalidArgumentException $e) {
            return false;
        }
    }
    
    
    /**
     * @return bool
     */
    public function setMultipleCaches(): bool
    {
        return $this->safeCache->setMultiple([
                                      'my-cache'        => 'some-value',
                                      'my-second-cache' => 'some-other-value'
                                  ],
                                  60 * 60 * 24);
    }
    
    
    /**
     * @return bool
     */
    public function setMultipleCachesWithPsr(): bool
    {
        try {
            return $this->psrCache->setMultiple([
                                          'my-cache'        => 'some-value',
                                          'my-second-cache' => 'some-other-value'
                                      ],
                                      60 * 60 * 24);
        } catch (InvalidArgumentException $e) {
            return false;
        }
    }
    
    
    /**
     * @return bool
     */
    public function deleteMyCache(): bool
    {
        return $this->safeCache->delete('my-cache');
    }
    
    
    /**
     * @return bool
     */
    public function deleteMyCachePsr(): bool
    {
        try {
            return $this->psrCache->delete('my-cache');
        } catch (InvalidArgumentException $e) {
            return false;
        }
    }
    
    
    /**
     * @return array
     */
    public function deleteMultipleCaches(): bool
    {
        return $this->safeCache->deleteMultiple(['my-cache', 'my-second-cache']);
    }
    
    
    /**
     * @return array
     */
    public function deleteMultipleCachesPsr(): bool
    {
        try {
            return $this->psrCache->deleteMultiple(['my-cache', 'my-second-cache']);
        } catch (InvalidArgumentException $e) {
            return false;
        }
    }
}
```

!!! Notice "Notice"
    This example expects you to use the [Service Provider] to register your classes to the [Application Core].
    If your are using the legacy architecture, you need to fetch this service using the [Legacy DI Container].

!!! Notice "Recommendation"
    We recommend you to use the `createCacheFor` method and `SafeCache` class for a more straightforward use.


## Clearing caches

To always have an overview of all existing caches and grouping them can be pretty hard. So we implemented the
`Gambio\Core\Cache\Services\ClearCacheService` service, which allows clearing caches for specific usages.
Furthermore, it's possible to add your cache namespaces, so that they will also be cleared, if the group the
namespace was added to, will be removed.

We currently separate our caches into 5 groups:

1. **Module:** Contains caches that are relevant for the general usage of modules.
2. **Product:** Contains caches that handle product specific data.
3. **System:** Contains caches that are relevant for the general usage of the shop software.
4. **Template:** Contains caches that handle template and theme specific data.
5. **Text:** Contains caches that handle text phrases and language specific data.

The following example shows you how to add your cache namespace to one of the pre-defined groups:

```php
namespace GXModules\<Vendor>\<Module>;

use Gambio\Core\Application\DependencyInjection\AbstractModuleBootableServiceProvider;
use Gambio\Core\Cache\Services\ClearCacheService;
use GXModules\<Vendor>\<Module>\EventListeners\SomeEventListener;
use GXModules\<Vendor>\<Module>\Events\SampleEvent;

/**
 * Class MyBootableServiceProvider
 * @package GXModules\<Vendor>\<Module>
 */
class MyBootableServiceProvider extends AbstractModuleBootableServiceProvider
{
    //...

    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        $this->application->inflect(ClearCacheService::class)
                          ->invokeMethod('addNamespaceToModuleCaches', ['your_module_cache']);
        $this->application->inflect(ClearCacheService::class)
                          ->invokeMethod('addNamespaceToProductCaches', ['your_product_cache']);
        $this->application->inflect(ClearCacheService::class)
                          ->invokeMethod('addNamespaceToSystemCaches', ['your_system_cache']);
        $this->application->inflect(ClearCacheService::class)
                          ->invokeMethod('addNamespaceToTemplateCaches', ['your_template_cache']);
        $this->application->inflect(ClearCacheService::class)
                          ->invokeMethod('addNamespaceToTextCaches', ['your_text_cache']);
    }
}
```

The following example shows hwo to clear a specific group of caches using the service:

```php
namespace GXModules\<Vendor>\<Module>;

use Gambio\Core\Cache\Services\ClearCacheService;

/**
 * Class SampleClass
 * @package GXModules\<Vendor>\<Module>
 */
class SampleClass
{
    /**
     * @var ClearCacheService
     */
    private $clearCacheService;
    
    
    /**
     * SampleClass constructor.
     *
     * @param ClearCacheService $clearCacheService
     */
    public function __construct(ClearCacheService $clearCacheService)
    {
        $this->clearCacheService = $clearCacheService;
    }
    
    
    public function clearModuleCaches(): void
    {
        $this->clearCacheService->clearModuleCaches();
    }
    
    
    public function clearProductCaches(): void
    {
        $this->clearCacheService->clearProductCaches();
    }
    
    
    public function clearSystemCaches(): void
    {
        $this->clearCacheService->clearSystemCaches();
    }
    
    
    public function clearTemplateCaches(): void
    {
        $this->clearCacheService->clearTemplateCaches();
    }
    
    
    public function clearTextCaches(): void
    {
        $this->clearCacheService->clearTextCaches();
    }
}
```

!!! Notice "Notice"
    This example expects you to use the [Service Provider] to register your classes to the [Application Core].
    If your are using the legacy architecture, you need to fetch this service using the [Legacy DI Container].



[Application Core]: ./../application-core.md
[PSR-16]: https://www.php-fig.org/psr/psr-16/
[Service Provider]: ./../details/service-provider.md
[Legacy DI Container]: ./../details/di-container.md#legacy-di-container
