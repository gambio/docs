# Architecture and Framework

This part of our documentation explains the architecture and framework of the shop software. This basic knowledge
will help you understand how the software is structured or handles incoming requests.

Looking at the architecture of the shop software, we made a huge jump from GX3 to GX4. With GX4, we began to design
and implement a new architecture, which should be the footing for our future development. Even if we weren't able to
replace the architecture fully yet or set up interfaces to interact with the system, we were able to improve
the performance and way of development considerably.

The tutorial about the [Application Core] gives you an overview of the new architecture and mentions essential
components. We also provide further information about the [Application Layers], [Autoloading and Namespaces],
[DI Container] and [Service Providers], which are all part of the system.

Besides the general footing of our shop software, we also wanted to give you further information about the
[technical-] and [business-related components] you can use for developing your modules.

Because there are still some parts of the shop software that are using the [old architecture], we put up some
information about it as well, but we recommend to base your modules on the new architecture as far as possible.



[Application Core]: ./application-core.md
[Application Layers]: ./details/autoloading.md
[Autoloading and Namespaces]: ./details/autoloading.md
[DI Container]: ./details/di-container.md
[Service Providers]: ./details/service-provider.md
[technical-]: ./technical-components/index.md
[business-related components]: ./business-components/index.md
[old architecture]: ./legacy-architecture.md
