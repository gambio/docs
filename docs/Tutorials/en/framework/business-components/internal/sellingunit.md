# Selling Unit

The SellingUnit is a layer that intents to give and easy and reliable source of information for a selected
product/service in the Gambio Shop. It offers in a centralized way access to all the information and exceptions
for a product in the shop current state.
The current shop state means that the SellingUnit cannot give the representation of a product in the past, but
it will reconstruct its data based on the shop current parameters.

## SellingUnit composition

### Understanding the concept of sellable unit

The objective of the shop is to sell goods or services that will be delivered/supplied to the customer.
Those goods or services may have specific characteristics that may affect what is going to be delivered. 
As an example, a product can have a property called Size, inside the Size we can have different selectable options,
for example for the property Size we can 41, 42, or 43 options. 
The selected product with the selected size will result in a different physical good tp be delivered.

### Abstracting the real world

The SellingUnit intents fulfill the requirements of the selling process, where the user chooses a product and supplies
additional information e.g. color, size, warehouse, shipping type, etc.
In this example, the selected color, size, warehouse, shipping type are the selected **modifiers**, and the ID of those
selected modifiers will be included in the SellingUnitId.

The minimum deliverable and sellable unit, plus the additional information related with the Selling, is called the
SellingUnit.

The selected property is named as modifier, and the property with all its options is called Modifier Group.

The SellingUnit doesn't implement the business rules but only supply an interface where different modules can compete
and/or cooperate to create some information without coupling with each other.

## Structure examples

### Modifier Group
    
- Group Size {**id**: 1, **description**: Size}<- *Modifier Group*
    - 41 *{**id**: 1, **description**: 41, **class** PropertyModifier}* <- **Modifier**
    - 42 *{**id**: 2, **description**: 42, **class** PropertyModifier}* <- **Modifier**
    - 43 *{**id**: 3, **description**: 43, **class** PropertyModifier}* <- **Modifier**


- Group Color {**id**: 2, **description**: Color}<- *Modifier Group*
    - Blue *{**id**: 30, **description**: Blue, **class** PropertyModifier}* <- **Modifier**
    - Black *{**id**: 31, **description**: Black, **class** PropertyModifier}* <- **Modifier**
    - Yellow *{**id**: 32, **description**: Yellow, **class** PropertyModifier}* <- **Modifier**

### SellingUnit Identification

The SellingUnit identification is a composition of the productId, a language, and a collection of many modifiers. While
the language doesn't change most of the values (like stock, size, and weight) it can change language-dependent
information, e.g. the product description.
Example:

Bellow, it is demonstrated how the SellingUnitId use of composition to then create its unique identity.
- ***SellingUnitId*** 
    - **productId** [1] <- *the product id*
    - **modifiers:** <- *collection of modifiers id*
        - *{**code**: 1, **class**:PropertyModifierId}* <- *id of the Size modifier Option 41*
        - *{**code**: 30, **class**:PropertyModifierId}* <- *id of the Color modifier Option Blue*
    - **language** {value: 1, class Language} 



## Handling the cooperation and competition between modules

An example of modules that may compete or cooperate to create some information is the properties, the product, and
the attributes. 
These 3 modules compete and cooperate to the construction of the SellingUnit Weight.

The weight is composed of two different pieces of information
1. **Main Weight** [1] - The principal weight of the SellingUnit. 
   - A null value means that the SellingUnit state is not valid.
   - The modules Product and Properties compete for defining this information
1. **Additional Weight** [n] - Weights that will be added to the main weight. 
   - The module Attributes and Properties cooperate with this information.

Every module will supply the information by using the event WeightBuilder. 
The WeightBuilder accepts many additional weights, but only one main weight.
To handle the concurrence, every module defines its priority when giving the information, it means that, 
if the **product** module (priority 1000) and **properties** module (priority 10000) define the main weight, 
the **properties** module information will be selected, because it has a bigger priority.

The priorities are hardcoded, meaning that external modules can collide over the information priority.


## Advantages

#### The main benefits of the SellingUnit

##### Decoupling modules

Different modules that compete or cooperate for the same information and don't know about each other.

##### Easy implementation of new modules

Once defined how the information is composed and how the modules should interact with each other, it is possible to
implement new modules without changing the code of the existing modules.

##### Reusability 

The SellingUnit can be used in any part of the Shop FrontEnd, and it can offer a centralized source of credible
information.


## Disadvantages

### No implementation for custom fields

The SellingUnit doesn't offer an easy way of implementing new fields, but only to interact over the information it
already has.
    
    Obs: The merge request https://sources.gambio-server.net/gambio/gxdev/-/merge_requests/965 proproses an implementation of custom fields for the SellingUnit
### Granularity

The implementation of the modules of the SellingUnit modules structured in a very granular way, meaning that some
modules do many queries over the same table to get different information.
The Module for Properties were partially refactored in order to use a centralized in-memory cached repository.

## Structure

All the fields of the SellingUnit are LazyLoaded by an EventBased structure.
When a field accessed at the first time, it will trigger an event, this event will be captured by listeners that
will compete of cooperate for the ownership of the information.
The image bellow demonstrate the SellingUnit and it's events.

![SellingUnit diagram](../_assets/selling-unit-structure.png)


