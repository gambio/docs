# Text Phrases

Text phrases can easily be queried via the `Gambio\Core\Language\TextManager`. Either a single text phrase or all text
phrases of a section can be queried via the `TextManager`. The current language of the HTTP client will be assumed
by default or replaced with German if the language of the client does not exist or could not be determined. However,
it is also possible to query text phrases in a specific language.

The following gives an example of how to use it:

```php
use Gambio\Core\Language\TextManager;

/**
 * Class SampleClass
 */
class SampleClass
{
    /**
     * @var TextManager
     */
    private $textManager;
    
    
    /**
     * SampleClass constructor.
     *
     * @param TextManager $textManager
     */
    public function __construct(TextManager $textManager)
    {
        $this->textManager = $textManager;
    }
    
    
    /**
     * @param int|null $languageId
     *
     * @return string
     */
    public function getWelcomeText(int $languageId = null): string
    {
        if ($languageId !== null) {
            return $this->textManager->getPhraseText('welcome', 'my-section', $languageId);
        }
        
        return $this->textManager->getPhraseText('welcome', 'my-section');
    }
    
    
    /**
     * @param int|null $languageId
     *
     * @return string[]
     */
    public function getAllOfMyPhrases(int $languageId = null): array
    {
        if ($languageId !== null) {
            return $this->textManager->getSectionPhrases('my-section', $languageId);
        }
        
        return $this->textManager->getSectionPhrases('my-section');
    }
}
```

!!! Notice "Notice"
    This example expects you to use the [Service Provider] to register your classes to the [Application Core].
    If your are using the legacy architecture, you need to fetch this service using the [Legacy DI Container].



[Application Core]: ./../application-core.md
[Service Provider]: ./../details/service-provider.md
[Legacy DI Container]: ./../details/di-container.md#legacy-di-container
