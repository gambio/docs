# Statistics Overview

The statistics overview is a collection of widgets containing several KPIs and other useful statistics that can be
looked at from within the *Gambio Admin*.
The shop operator is able to adjust these to their liking, hence it's only displaying the information, that is of good
use
for the individual.

The statistics overview aims to functionally replace and improve the previous statistics, while also providing new
information that wasn't accessible before, with the ability to be easily extended upon.

## Statistics Overview domain

The statistics overview domain provides management functionality for registering, filtering and configuring different
statistics, as well as the possibility to be extended with new widgets displaying individually crafted
statistics.

### Aggregate root and domain model

The aggregate root `Gambio\Admin\Modules\StatisticsOverview\Model\OverviewWidget` contains the information of an
individual widget that is displayed on the dashboard.

### Use cases

#### Fetching widgets by category

```php
/** $statisticsOverviewService GambioAdmin\Modules\StatisticsOverview\App\StatisticsOverviewService **/

use Gambio\Admin\Modules\StatisticsOverview\Model\ValueObjects\WidgetCategory;

$customerRelatedWidgets = $statisticsOverviewService->getWidgetsByCategory(WidgetCategory::CUSTOMERS);
$orderRelatedWidgets    = $statisticsOverviewService->getWidgetsByCategory(WidgetCategory::ORDERS);
$systemRelatedWidgets   = $statisticsOverviewService->getWidgetsByCategory(WidgetCategory::SYSTEM);

```

#### Updating options of a widget

```php
/** $statisticsOverviewService GambioAdmin\Modules\StatisticsOverview\App\StatisticsOverviewService **/

$statisticsOverviewService->configureWidget('GambioConversionRateCount', [
    'sortOrder' => 2,
    'visibility' => true
]);

```

#### Adding a custom widget

Create a new class that extends `GambioAdmin\Modules\StatisticsOverview\Model\Entities\WidgetDefinition`
in `GambioAdmin\Modules\StatisticsOverview\Model\Entities\WidgetDefinition`.

```php
/**  GambioAdmin\Modules\StatisticsOverview\Model\Entities\WidgetDefinition\NewWidget.php **/

declare(strict_types=1);

namespace Gambio\Admin\Modules\StatisticsOverview\Model\Entities\WidgetDefinition;

use Doctrine\DBAL\Connection;
use Gambio\Admin\Modules\StatisticsOverview\Model\Collections\WidgetOptions;
use Gambio\Admin\Modules\StatisticsOverview\Model\Entities\WidgetDefinition;
use Gambio\Admin\Modules\StatisticsOverview\Model\ValueObjects\WidgetData;
use Gambio\Admin\Modules\StatisticsOverview\Services\StatisticsOverviewFactory;
use Gambio\Admin\Modules\StatisticsOverview\Services\StatisticsOverviewFactory\WidgetOptionFactory\PredefinedOptionFactory\TimespanOptionFactory;
use NumberFormatter;

class NewWidget extends WidgetDefinition
{
    // The ID is for internal reference and has to be unique.
    private const ID = 'NewWidget';

    // The widget name holds the name of the widget that will be displayed in its respective language. 
    private const WIDGET_NAME = [
        self::LANGUAGE_CODE_GERMAN  => 'Neues Widget',
        self::LANGUAGE_CODE_ENGLISH => 'New Widget',
    ];
    
    private $factory;

    private $connection;

    // The $numberFormatter is optional and in this case later used to format a number
    // that is to be displayed as text within the return statement of the data() method.
    private $numberFormatter;

    public function __construct(
        StatisticsOverviewFactory $factory,
        Connection $connection,
        NumberFormatter $numberFormatter
    ) {
        $this->factory         = $factory;
        $this->connection      = $connection;
        $this->numberFormatter = $numberFormatter;

        // Assign the ID, the names in german and english and also the category, 
        // the visualization type as well as the options within the parameters of the parents' constructor.
        // In this case the visualization is plain text, the category is orders 
        // and for the options we wanted the possibility to select a timespan including "Today".
        // The predefined options for the sort order and the visibility checkbox are required.
        parent::__construct($factory->createId(self::ID),
                            $factory->createNames($factory->createName($factory->createLanguageCode(self::LANGUAGE_CODE_GERMAN),
                                                                       self::WIDGET_NAME[self::LANGUAGE_CODE_GERMAN]),
                                                  $factory->createName($factory->createLanguageCode(self::LANGUAGE_CODE_ENGLISH),
                                                                       self::WIDGET_NAME[self::LANGUAGE_CODE_ENGLISH])),
                            $factory->useCategories()->createForOrders(),
                            $factory->useVisualizations()->createText(),
                            $factory->useOptions()->createOptions($factory->useOptions()
                                                                      ->usePredefined()
                                                                      ->createTimespanDropdownIncludingToday($factory),
                                                                  $factory->useOptions()
                                                                      ->usePredefined()
                                                                      ->createSortOrderNumber($factory),
                                                                  $factory->useOptions()
                                                                      ->usePredefined()
                                                                      ->createVisibilityCheckbox($factory)));
    }
    

    public function data(WidgetOptions $options): WidgetData
    {
        // Since the use of a timespan as an option is wanted, 
        // we have to create the Timespan value-object through the TimespanFactory.
        $timespan = $this->factory->useData()
            ->useTimespan()
            ->createFromTerm($options->getById(TimespanOptionFactory::ID)->value());
            
        // Now it is time to fetch the data we want to display in our new widget. 
        // Therefore, we create a new QueryBuilder and configure it appropriately, execute it and fetch the result.
        // In this specific widget, our goal is to display the number of orders within a given timespan.
        $orders = $this->connection->createQueryBuilder()
                    ->select('COUNT(date_purchased) AS orders')
                    ->from('orders')
                    ->where('date_purchased BETWEEN :startDate AND :endDate')
                    ->setParameters([
                                        'startDate'        => $timespan->startDate()
                                            ->format(self::DATA_QUERY_TIMESPAN_FORMAT_START),
                                        'endDate'          => $timespan->endDate()
                                            ->format(self::DATA_QUERY_TIMESPAN_FORMAT_END),
                                    ])
                    ->executeQuery()
                    ->fetchAllAssociative()[0];
                        
        // After fetching, our resulting array would look something along the lines of this:
        // $orders = ['orders' => 42]
        // 
        // Since we used text as our visualization method, we have to create the TextData we want to return.
        // Hence, we create the TextDataValue, that is required for the creation of the TextData, 
        // by providing the result of our request, formatted by the $numberFormatter.
        return $this->factory->useData()->useTextData()->createTextData($this->factory->useData()
                                                                            ->useTextData()
                                                                            ->createValue($this->numberFormatter->format((int)($orders['orders']
                                                                                                                               ??
                                                                                                                               0))));
    }
}
```

The widget that was just created now has to be registered within
the `GambioAdmin\Modules\StatisticsOverview\StatisticsOverviewServiceProvider`
to be visible from within the statistics overview in the *Gambio Admin*.

To do so, it is necessary to add two code snippets as follows.

```php
/** GambioAdmin\Modules\StatisticsOverview\StatisticsOverviewServiceProvider **/

// This already exists and is included for demonstration purposes.
private const WIDGET_DEFINITION_REGISTER_METHOD = 'register';

public function boot(): void
{
    // .....
    $this->application->inflect(StatisticsOverviewWidgetDefinitionProvider::class)
        ->invokeMethod(self::WIDGET_DEFINITION_REGISTER_METHOD, [NewWidget::class]);
    // .....
}

// Here it is necessary to also add the parameters required for the construction of the widget using ->addArgument().
public function register(): void
{
    // .....
    $this->application->registerShared(NewWidget::class)
        ->addArgument(StatisticsOverviewFactory::class)
        ->addArgument(Connection::class)
        ->addArgument($numberFormatter);
    // .....
}
```

## Business rules

- ID of a widget must be unique
- Category of a widget must be one of these:
    - `customers`
    - `orders`
    - `system`
- Visualization of a widget must be one of these:
    - `areaChart`
    - `barChart`
    - `pieChart`
    - `stackedColumnsChart`
    - `table`
    - `text`
    - `treemapChart`
    - `donutChart`
    - `radialBarChart`
    - `twoSidedBarChart`
- Data type of a widget must be one of these:
    - `map`
    - `number`
    - `serial`
    - `table`
    - `text`

