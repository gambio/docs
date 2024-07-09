# Database

To communicate with the database, we use [Doctrine DBAL]. We provide an active database connection via the
[DI Container].

!!! note "Note"
    Please have in mind that the version of this dependency we ship with our shop software might vary. From time to
    time we will update this dependency (not only for compatibility reasons, but also for security ones), which could
    lead to breaking changes when you as a third-party developer are using this dependency. Please be aware of this
    circumstances.

For simple queries you can use auxiliary methods provided by the `Doctrine\DBAL\Connection` class:

- `insert(string $table, array $data)`  
  Creates a new table entry.
- `update(string $table, array $data, array $identifier)`  
  Updates an existing table entry.
- `delete(string $table, array $identifier)`  
  Deletes all entries from the table that are found using the `$identifier`.

If you want to use a value as a column name that also matches a MySQL internal keyword, the column name must be masked.
For example, if you want the column of a table to have the name `key`, the query must contain ``` `key` ```. For this
purpose the method `quoteIdentifier(string $identifier)` is available in the `Doctrine\DBAL\Connection` class.

Complex queries can be mapped using the [Query Builder]. To create a query builder, you need to call the
`createQueryBuilder` method, which is available in the `Doctrine\DBAL\Connection` class. Note that the query builder
does not reset its internal state after it has been executed. This means that in most cases it makes sense to create a
new instance of the query builder for each query.

The following example shows how to add the Doctrine DBAL connection to your class using a Service Provider:

```php
namespace GXModules\<Vendor>\<Module>;

use Doctrine\DBAL\Connection;
use Gambio\Core\Application\DependencyInjection\AbstractModuleServiceProvider;
use GXModules\<Vendor>\<Module>\SampleClass;

/**
 * Class MyServiceProvider
 * @package GXModules\<Vendor>\<Module>
 */
class MyServiceProvider extends AbstractModuleServiceProvider
{
    /**
     * @inheritDoc
     */
    public function provides(): array
    {
        return [
            SampleClass::class,
        ];
    }

    /**
     * @inheritDoc
     */
    public function register(): void
    {
        $this->application->registerShared(SampleClass::class)
             ->addArgument(Connection::class);
    }
}
```

[DI Container]: ./../details/di-container.md

[Doctrine DBAL]: https://www.doctrine-project.org/projects/dbal.html

[Query Builder]: https://www.doctrine-project.org/projects/doctrine-orm/en/2.7/reference/query-builder.html#working-with-querybuilder