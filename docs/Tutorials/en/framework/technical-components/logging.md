# Logging

Since logging is of course also an important core component of an application, an implementation of the
[PSR-3]{target=_blank} `Psr\Log\LoggerInterface` can be created using the `Gambio\Core\Logging\LoggerBuilder`. This
builder provides methods to set a specific namespace for your logs as well as methods to add or omit request data to
your logs.

According to the *PSR* different log levels can be used and additional context data can be logged. All logs can be
viewed in the Gambio Admin under *Toolbox > Show Logs* and are stored in both text and JSON form in the `logfiles`
folder (in the main directory of the shop).

### Logging with utility function

The easiest way to get an instance of the logger is by using
the `Gambio\Core\Logging\logger(string $namespace = 'general', bool $addRequestData = false): LoggerInterface` utility
function.  
The following example demonstrate how to log information in case of an exception.

```php
use function Gambio\Core\Logging\logger;

// ...

/**
 * Class MyClass
 */
class MyClass
{
    /**
     * Performing an operation that might fail
     * and logs in case of an exception. 
     */
    public function doSomethingThatMightFail(): void
    {
        try {
            $this->performSomething();
        } catch (\UnexpectedValueException $e) {
            $logger = logger(
                // default args, can be omitted 
                $namespace = 'general',
                $addRequestData = false
            );
            
            $logger->error('error message describing the problem', [
                // any additional data can be logged in the context array
                'foo' => 'bar'
            ]);
        }
    }
    
    
    /**
     * This method throws an exception randomly on usage.
     * 
     * @throws Exception
     */
    private function performSomething(): void
    {
        if (\random_int(1, 2) === 1) {
            throw new \UnexpectedValueException('operation failed');
        }
    }
}
```

### Logging with Service Provider injection

The following example shows you how to create a logger with help of a service provider and how to use it:

```php
use Gambio\Core\Application\DependencyInjection\AbstractServiceProvider;
use Gambio\Core\Logging\LoggerBuilder;

/**
 * Class MyServiceProvider
 */
class MyServiceProvider extends AbstractServiceProvider
{
    /**
     * @inheritDoc
     */
    public function provides(): array
    {
        return [MyClass::class];
    }
    
    
    /**
     * @inheritDoc
     */
    public function register(): void
    {
        // Add LoggerBuilder as a dependency, so you can create your logger inside the
        // constructor method of your class.
        $this->application->registerShared(MyClass::class)->addArgument(LoggerBuilder::class);
        
        // Alternatively you could create the logger before adding it as a dependency
        // for your class.
        $this->application->registerShared(MyClass::class, function(){
            /** @var LoggerBuilder $builder */
            $builder = $this->application->get(LoggerBuilder::class);
            $logger  = $builder->changeNamespace('some-namespace')
                               ->omitRequestData()
                               ->build();
            
            return MyClass($logger);
        });
    }
}
```

```php
use Gambio\Core\Logging\LoggerBuilder;
use Psr\Log\LoggerInterface;

/**
 * Class MyClass
 */
class MyClass
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    
    
    /**
     * SampleClass constructor.
     *
     * @param LoggerBuilder $loggerBuilder
     */
    public function __construct(LoggerBuilder $loggerBuilder)
    {
        $this->logger = $loggerBuilder->changeNamespace('sample-class')
                                      ->addRequestData()
                                      ->build();
    }
    
    
    /**
     * @param string $message
     * @param array  $extraData
     */
    public function logSomething(string $message, array $extraData = []): void
    {
        $this->logger->notice($message, $extraData);
    }
}
```

!!! Notice "Notice"
    This example expects you to use the [Service Provider] to register your classes to the [Application Core]. If your are
    using the legacy architecture, you need to fetch this service using the [Legacy DI Container].


[Application Core]: ./../application-core.md
[Service Provider]: ./../details/service-provider.md
[Legacy DI Container]: ./../details/di-container.md#legacy-di-container
[PSR-3]: https://www.php-fig.org/psr/psr-3/
