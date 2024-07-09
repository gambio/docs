# Rules and coding standards for clean, less verbose and concise code

**Created:** 2020-03-12 by Mirko

**Status:** accepted

**Decision makers:** Moritz, Daniel W., Tobias S., Mirko

**Last updated:** 2021-04-01 by Mirko

## Context

With the usage of the new architecture in GX 4, we noticed that there are different ways how we name and use classes,
interfaces, and namespaces in general. To make sure the new refactored systems follow some consistent rules, we
discussed some naming conventions. To go even further, we also want to define some general and already known coding
standards, that had been used over the last years.

The starting point for this was the previous [pool in Bitrix] about the interface suffix as well as the following
articles we read:

- https://verraes.net/2013/09/sensible-interfaces/
- https://medium.com/@Claromentis/naming-classes-interfaces-and-namespaces-361c63474e6c
- https://www.nikolaposa.in.rs/blog/2019/01/06/better-naming-convention/

## Decision

While working inside the shop project, we follow the following rules and standards.

### Rules

- We always use strict comparisons.
- We always add `declare(strict_types=1)` at the beginning of a file.
- We use parentheses when creating new instances, even if they do not require arguments (`$foo = new Foo();`).
- All developers using [this coding style] to reformat before committing their source code into the version control
  system. Old legacy files don't have to be reformatted completely, because the differences of the commits would be too
  much.
- We name classes as specific as possible. There shouldn't be any classes like `Reader`, `Writer` etc. even if they
  might be unique inside their domain or namespace.  
  __Example:__ In general, we prefer classes like`\Store\Warehouse\XmlWarehouse` or `\Store\Warehouse\WarehouseXml`
  instead of `\Store\Warehouse\Xml`.
- We don't use the `get` prefix for getters in entities and value objects.  
  __Example:__ If there is a method that provides e.g. the first name, then it should be named `firstName`.
- Instead of using the `set` prefix for setters in entities and value objects, we give the methods a more meaningful
  name like e.g. `updateOrder`, `changeSorting`, or `replaceDescription` in context of the domain.
- We keep the nesting of control structures per method as small as possible. An example can be found
  [here](./attachments/003-nesting_and_early_exit_example.php).
- We exit as early as possible instead of nesting conditions or using else statements. An example can be found
  [here](./attachments/003-nesting_and_early_exit_example.php).
- We don't create or use magic numbers; we create constant or variables to specify these numbers and giving them more
  context.
- We add PHPDoc blocks that contain at least information about parameters, exceptions and the return value.
- We name events in *past tense* and don't add an `Event` suffix.
- Exceptions keep their `Exception` suffix, but should also be named as specific as possible. It's also a good idea to
  implement meaningful static construct methods like
  `throw CustomerCreationFailedException::becauseOfPreviousError($previousException);` or.
  `throw CustomerDoesNotExistException::forId($customerId);`.
- We keep methods and classes as simple/stupid as possible. Simpler is always better. Reduce complexity as much as
  possible.
- Interfaces don't have an `Interface` suffix. Therefore, they should be named as generic as possible and the
  implemented classes as specific as possible. Classes with the same name as the interface they are implementing should
  be a rare exception. Because of the interface segregation principle, it's recommended to create multiple interfaces
  with generic names and combine them.
- When writing unit tests [we focus on testing the behaviour] of the classes. Therefore, we don't write tests for
  service provider and it's ok to skip unit tests for low level value objects.
- Instead of creating unit tests for controllers or actions, we focus on integration tests for these classes.

### General standards and conventions

- We follow the [SOLID principles].
- We use [Domain-driven design] to model our domains.
- We mind the requirements for running the shop software like minimum and maximum versions or needed extensions.

### Recommendations

- It's better to implement a `toArray` method than the `JsonSerializable` interface, because this allows a more direct
  access to the data of a class. Furthermore, no `json_decode(json_encode(...))` hacks are needed and the objects don't
  make the impression that they can be deserialized easily.
- Some exceptions don't need to be part of the documentation (e.g. PHPDoc) because they aren't relevant. Good examples
  for this are the Doctrine exceptions that will be thrown by certain methods, when there is no DB connection or a
  rollback should be done without a started transaction. These exceptions aren't relevant for the documentation of a
  domain.
- When implementing a collection, we need to be careful about which interfaces we are using. It's not recommended using
  the `ArrayAccess` interface for value objects in general, because this makes them mutable. There it's better to use
  the `IteratorAggregate` interface instead.

## Consequences

These rules will increase the consistency of the source code and will make it easier for developers (external as well as
internal) to understand and work with it. By removing the `Interface` and `Event` suffix, we also remove tautologies
(saying the same thing twice), that are common in our everyday language.

## Updates

### Completely reworked proposed and not accepted ADR (2020-09-18)

The purpose of this ADR had been changed so that it focuses more on general coding guidelines instead of how to name
classes and interfaces. At this point, the ADR wasn't accepted (just proposed), so that there are no changes to be
explicitly enumerated.

### Completely reworked proposed and not accepted ADR (2020-04-01)

Added new recommendations regarding the usage of some PHP specific interfaces and restructured the content to separate
rules, recommendations, and standards more.


[pool in Bitrix]: https://gambio.bitrix24.de/company/personal/user/88/blog/13534/
[this coding style]: ./attachments/003-PHPStorm_coding_styles.jar
[we focus on testing the behaviour]: https://en.wikipedia.org/wiki/Behavior-driven_development#Behavioral_specifications
[SOLID principles]: https://en.wikipedia.org/wiki/SOLID
[Domain-driven design]: https://en.wikipedia.org/wiki/Domain-driven_design