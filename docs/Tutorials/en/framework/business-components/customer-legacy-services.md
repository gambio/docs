# Customer Legacy Services


The current Gambio Admin page for editing a customer contains several configurations that aren't part of the new
customer domains or the other ones we designed. Therefore, we are going to introduce further compatibility services or
even domains that we don't want to advertise for external developers to use.

The following documentation is for internal use and should create an image of how these old systems/mechanics are linked
with the new designed domains.


## Customer Address


In the Gambio Admin it's possible to change the general default address of a customer. For this reason we need partially
implemented the customer address domain. To keep the work here to a minimum we are going to implement only the necessary
logic to get and update the customers' default address.

![](./diagrams/customer-address/model.png){.enlargeable .fullWidth}
![](./diagrams/customer-address/services.png){.enlargeable .fullWidth}
![](./diagrams/customer-address/events.png){.enlargeable .fullWidth}

## Newsletter


The subscription for newsletters can also be seen and changed in the Gambio Admin page where you edit the customers.
Therefore, we are going to implement a super simple model plus service to see if a customer is already subscribed as
well as managing all subscriptions.

![](./diagrams/newsletter/model.png){.enlargeable .fullWidth}
![](./diagrams/newsletter/services.png){.enlargeable .fullWidth}


## Payment and Shipping Modules


It's also possible to decide which payment and shipping modules are disallowed for a certain customer. To allow this in
the future version, we are going to implement a simple model plus service for these two domains.

![](./diagrams/payment-module/model.png){.enlargeable .fullWidth}
![](./diagrams/payment-module/services.png){.enlargeable .fullWidth}

![](./diagrams/shipping-module/model.png){.enlargeable .fullWidth}
![](./diagrams/shipping-module/services.png){.enlargeable .fullWidth}