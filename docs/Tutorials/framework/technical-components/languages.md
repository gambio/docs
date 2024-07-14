# Languages

To determine the available languages in the shop software, we provide the `Gambio\Core\Language\Services\LanguageService`
service. It can be used to fetch all available languages for the store and admin area, as well as languages based
on a specific ID or the two-digit ISO code.

The following example shows how to use this service:

```php
use Gambio\Admin\Modules\Language\Model\Exceptions\LanguageNotFoundException;
use Gambio\Core\Language\Services\LanguageService;

/**
 * Class SampleClass
 */
class SampleClass
{
    /**
     * @var LanguageService
     */
    private $languageService;
    
    
    /**
     * SampleClass constructor.
     *
     * @param LanguageService $languageService
     */
    public function __construct(LanguageService $languageService)
    {
        $this->languageService = $languageService;
    }
    
    
    /**
     * @param int $id
     *
     * @return array|null Return null if language does not exist or available
     *                    information of the requested language as array.
     */
    public function getLanguageInformationById(int $id): ?array
    {
        try {
            $language = $this->languageService->getLanguageById($id);
            
            return [
                'id'        => $language->id(),        # as int
                'code'      => $language->code(),      # as string
                'name'      => $language->name(),      # as string
                'charset'   => $language->charset(),   # as string
                'directory' => $language->directory(), # as string
            ];
        } catch (LanguageNotFoundException $e) {
            return null;
        }
    }
    
    
    /**
     * @param string $code
     *
     * @return array|null Return null if language does not exist or available
     *                    information of the requested language as array.
     */
    public function getLanguageInformationByCode(string $code): ?array
    {
        try {
            $language = $this->languageService->getLanguageByCode($code);
            
            return [
                'id'        => $language->id(),        # as int
                'code'      => $language->code(),      # as string
                'name'      => $language->name(),      # as string
                'charset'   => $language->charset(),   # as string
                'directory' => $language->directory(), # as string
            ];
        } catch (LanguageNotFoundException $e) {
            return null;
        }
    }
    
    
    /**
     * @return array Return the information of all language as array.
     */
    public function getLanguageInformationOfAllLanguages(): ?array
    {
        $return    = [];
        $languages = $this->languageService->getAvailableLanguages();
        foreach($languages as $language){
            $return[] = [
                'id'        => $language->id(),        # as int
                'code'      => $language->code(),      # as string
                'name'      => $language->name(),      # as string
                'charset'   => $language->charset(),   # as string
                'directory' => $language->directory(), # as string
            ];
        }

        return $return;
    }
    
    
    /**
     * @return array Return the information of all admin language as array.
     */
    public function getLanguageInformationOfAllAdminLanguages(): ?array
    {
        $return    = [];
        $languages = $this->languageService->getAvailableAdminLanguages();
        foreach($languages as $language){
            $return[] = [
                'id'        => $language->id(),        # as int
                'code'      => $language->code(),      # as string
                'name'      => $language->name(),      # as string
                'charset'   => $language->charset(),   # as string
                'directory' => $language->directory(), # as string
            ];
        }

        return $return;
    }
}
```

!!! Notice "Notice"
    This example expects you to use the [Service Provider] to register your classes to the [Application Core].
    If your are using the legacy architecture, you need to fetch this service using the [Legacy DI Container].



[Application Core]: ./../application-core.md
[Service Provider]: ./../details/service-provider.md
[Legacy DI Container]: ./../details/di-container.md#legacy-di-container
[aggregation]: http://docs.php.net/manual/de/class.iteratoraggregate.php