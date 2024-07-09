# Support for submodules in the GambioAdmin

**Created:** 2022-07-26 by Tobias Schindler | Marvin Muxfeld

**Status:** draft

**Decision makers:** to be completed

## Context

For the version Gambio GX4 we have developed a new application core, which has since been used for the development of
new shop components. For this, we have set up rules in ADR 004 and ADR 005. Over time the new
directory `GambioAdmin/Modules` has grown more and more, and we noticed that often several modules are created to map
the function of a domain.

To solve both problems we thought about supporting so-called "Submodules" in GambioAdmin. With submodules, it should be
possible to go one level deeper within a module to better group the functions.

For example, currently (07/26/2022) there are three product-related modules in GambioAdmin: `ProductOption`
, `ProductVariant`, and `ProductDownload`.

## Decision

After applying the new rules for submodules, inside the `GambioAdmin/Modules` directory, there would be a new directory 
called `Product`, which is the main module for products. Three more directories named `Option`, `Variant`, and `Download`
would be stored inside a directory called `Submodules`, which is created on the top level of the main module.

Submodules need to follow the same structure and rules as the main module (**ADR 004** and **ADR 005**). Only difference 
between a main module and a submodule is that it can't contain additional submodule's

```
Before ADR 008
- GambioAdmin/
    - Modules/
        - ProductOption/
        - ProductVariant/
        - ProductDownload/

After ADR 008
- GambioAdmin/
    - Modules/
        - Product/
            - Submodules/
                - Option/
                - Variant/
                - Download/
```

### Service provider and routes

Submodules can have their service provider and routes.php files. A bootstrapper is responsible for loading the files.
Thus, it is possible to implement a whole section of a certain domain within a submodule.

### Boundaries

Software modularity is ensured by high cohesion and low coupling. To ensure low coupling, it is important to define
boundaries for modules and submodules.

We have the rule that modules communicate with each other only via application services. The rule remains as it is. It
is not allowed to use the application services of a submodule outside the respective module. If functions implemented
within a submodule are required in another module, an application service must be implemented in the main module to
provide the required function.

## Consequences

The structure of the `GambioAdmin/Modules` directory should become much clearer by using submodules. This makes it
possible to group the modules better and to maintain the system. However, it must be ensured using code reviews that the
rules concerning the module boundaries are adhered to.
