# Work in progress - Should not be released, as long as the model is incomplete.


# Language

Languages can be managed in the Gambio Admin and are essential for the text phrase system and language-dependent
informationen that can be added to products, categories, etc. 

The following sections describe the domain, model, use cases and business rules.


## Language domain

Currently, the language domain provides only reading and filter functionality. In general this domain is very basic 
and there aren't any specific business rules or constrains.


### Aggregate root and domain model

The aggregate root `Gambio\Admin\Modules\Language\Model\Language` encapsulates details like language ID, code,
a name, charset and its corresponding directory on the filesystem. 


### Use cases using read service


#### Fetching all or a specific language

```
/** $readService \Gambio\Admin\Modules\Language\Services\LanguageReadService **/

$allLanguages      = $readService->getLanguages();
$specificLanguage1 = $readService->getLanguageById(1);
$specificLanguage2 = $readService->getLanguageByCode('de');
```


### Use cases using filter service


#### Filter all existing languages including sorting and pagination

```
/** $filterService \Gambio\Admin\Modules\Language\Services\LanguageFilterService **/

$filters = [
    'charset' => 'utf-8', // Parcel service charset is "utf-8"
];
$sorting = '-name'; // In descending order of name
$limit   = 25;
$offset  = 0;

$filteredLanguages             = $filterService->filterLanguages($filters, $sorting, $limit, $offset);
$totalCountOfFilteredLanguages = $filterService->getLanguagesTotalCount($filters);
```


##### Filtering

The filter array that is given to the filter service maps the attributes of the language and the filtering term.
The assigned string (e.g. `get|2020-01-01`) always contains the comparison value, but it also may contain an
operation (e.g. `gte` for greater than or equals to). Leaving the operation (e.g. `2020-01-01`) will be the same
as using *equals to* (`eq`).

The following table shows all attributes and the operations that can be used on them.


|   | like (`*`) | equals to (`eq`) | lower than (`lt`) | lower than or equals to (`lte`) | greater than (`gt`) | greater than or equals to (`gte`) |
|---|:---:|:---:|:---:|:---:|:---:|:---:|
| `id`        |   | X | X | X | X | X |
| `code`      | X | X |   |   |   |   |
| `name`      | X | X |   |   |   |   |
| `charset`   | X | X |   |   |   |   |
| `directory` | X | X |   |   |   |   |


##### Sorting

To change the sorting, you can provide a string that describes the sorting order. The string must contain the
attributes used for sorting. If there is a minus (`-`) in front of the attribute, it will be sorted in descending
order. You can use multiple attributes to change the sorting order by linking them with a comma (`,`).


### Business rules

There are no specific business rules.


### Domain events

| Event | Description |
| ----- | ----------- |