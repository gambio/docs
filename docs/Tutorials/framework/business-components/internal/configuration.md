# Internal use only - Should not be released


# Configuration page

Managing configurations is an essential mechanic of the Gambio Admin, which is done mainly using the configuration page.
The configuration page consists of various categories, which are further divided into groups. The groups are assigned
configurations which are then displayed within these groups. Tags can be assigned to the individual configurations.

There are two ways to filter the displayed configurations. You can use the search function to filter by a term. Only
configurations will be displayed if there was a match in the label of the configuration, the name of its group or the
name of the category. Independently of this, you can also use the tags to filter thematically. If a tag is selected,
all linked configurations are displayed.

Because everything is managed by using JSON files, there is no need for a complex domain, which is why there are only
internal components and no public interface for extension.

Nevertheless, the following sections explain the inner structure and functionality of the configuration page and
internal components.


## Definition files

The `src/GambioAdmin/Modules/Configuration/App/Data/definitions` directory contains the data that is used to generate
the configuration page. 

For the customizing, additional JSON files with the prefix `custom.` can be created (e.g. `custom.categories.json`).
These additional files are read and processed after the main files. This means that not only additional categories,
groups, configurations, tags or types can be added, but also existing ones can be overwritten.

The scheme of the JSON files should be self-explanatory. In general:

* For the attributes `label` a section and phrase of a language file must always be specified.
* The attribute `id` is always a string and is used for referencing, e.g. to assign a category to a group.
* The attribute `key` in the `configuration.json` always refers to a configuration key from the `gx_configuration`
  database table.
* Each type must be assigned a factory via `src/GambioAdmin/Modules/Configuration/ConfigurationServiceProvider.php`
  (see line 141 and below).


## Adding a new type factory

To add a new type a new entry in the `types.json` (or `custom.types.json`) must be added, as well as a factory
must be implemented. Already existing Factories can be found in the
`src/GambioAdmin/Modules/Configuration/Services/TypeFactories` folder. It is important that a new factory implements
the `Gambio\Admin\Modules\Configuration\Services\TypeFactories\TypeFactory` interface. The array, which is passed to
the method, is a summary of the standard parameters (from the `types.json` or `custom.types.json`) and the parameters
of the configuration (from the `configurations.json` or `custom.configurations.json`).