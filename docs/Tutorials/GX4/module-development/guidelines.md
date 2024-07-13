# Development Guidelines

We don't want to define any strict rules you need to follow if you're going to develop for the shop software, but
we want to give you some pieces of advice for producing clean and good code.

At first, there are some general programming principles we want to mention. The first principles are part of the
[SOLID]{target=_blank} acronym and advise you on how to write robust and solid software. We mention this one first
because in our opinion these principles are the most important ones! Besides the [SOLID]{target=_blank} principles,
there are some shorter or less powerful (but still not pointless) principles:

- **[KISS]{target=_blank} (Keep It Simple/Stupid):**  
  Sometimes in the process of implementing a specific logic, it happens that these implementations get huge or even
  complex. This principle says that you should split these huge or complex implementations into smaller and much
  simpler methods, components, etc. This helps you understand the source code better and also makes it easier to
  maintain. Additionally it helps to mind the [Single-responsibility principle]{target=_blank}.

- **[DRY]{target=_blank} (Don't Repeat Yourself):**  
  In general, it's painful to implement the same logic multiple times because it takes longer and makes it harder
  to maintain the code. So you should try not to repeat yourself and therefore use specific patterns or techniques.

- **[Favor Composition over Inheritance]{target=_blank}:**  
  This one is important regarding the principle above, because it says that you should favor composition over
  inheritance if it comes to reuse code you have already written. Components that can be used at different parts of
  your application or module are easier to maintain than new abstractions of specific classes.

- **[YAGNI]{target=_blank} (You Aren't Gonna Need It):**  
  This principle is pretty easy to understand. Don't implement something unless you are sure you really need it.

- **Code Against Interfaces, Not Implementations:**  
  If, for instance, our class relies on a specific helper class, you should mind coding against the interface of
  this helper class, not the concrete implementation. This way you make sure that you can change the implementation
  later on and don't break the classes that rely on these helper classes.

On top of all these principles, we have some further advice for you:

- Always use strict comparisons
- Add `declare(strict_types=1)` at the beginning of a file
- Keep the nesting of control structures per method as small as possible
- Instead of using magic numbers, create constants or variables to specify these numbers
- Learn about [Unit Testing]{target=_blank} and use [Test-driven development]{target=_blank}
- Learn about [Domain-driven design]{target=_blank} and use it to model your business logic

In the end, we want to recommend the following books:

- [Clean Code]{target=_blank} by Robert C. Martin
- [Clean Architecture]{target=_blank} by Robert C. Martin
- [Domain-Driven Design]{target=_blank} by Eric Evans
- [Implementing Domain-Driven Design]{target=_blank} by Vaughn Vernon



[SOLID]: https://en.wikipedia.org/wiki/SOLID
[KISS]: https://en.wikipedia.org/wiki/KISS_principle
[Single-responsibility principle]: https://en.wikipedia.org/wiki/Single-responsibility_principle
[DRY]: https://en.wikipedia.org/wiki/Don%27t_repeat_yourself
[Favor Composition over Inheritance]: https://en.wikipedia.org/wiki/Composition_over_inheritance
[YAGNI]: https://en.wikipedia.org/wiki/You_aren%27t_gonna_need_it
[Unit Testing]: https://en.wikipedia.org/wiki/Unit_testing
[Test-driven development]: https://en.wikipedia.org/wiki/Test-driven_development
[Domain-driven design]: https://en.wikipedia.org/wiki/Domain-driven_design
[Clean Code]: https://www.amazon.de/Clean-Code-Handbook-Software-Craftsmanship/dp/0132350882
[Clean Architecture]: https://www.amazon.de/Clean-Architecture-Craftsmans-Software-Structure/dp/0134494164
[Domain-Driven Design]: https://www.amazon.de/Domain-Driven-Design-Tackling-Complexity-Software/dp/0321125215
[Implementing Domain-Driven Design]: https://www.amazon.de/Implementing-Domain-Driven-Design-Vaughn-Vernon/dp/0321834577
