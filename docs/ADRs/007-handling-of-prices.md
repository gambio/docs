# Handling of prices

**Created:** 2021-11-11 by Mirko Janssen

**Status:** accepted

**Decision makers:** Moritz, Mirko

## Context

When it comes to prices and handling numbers used for that purpose, we should mind some pitfalls and best practices. In
the shop software, we are often handling different types of prices, and inside all sorts of different domains;
therefore, it's important to have similar rules of handling them.

## Decision

- We always store prices and numbers used for price calculation with at least four decimal places.
- When storing prices and numbers used for price calculation, we ensure that the context to which they belong is clear
  and meaningful. It should always be clear based on the context if a price is net or gross, additional documentation
  may also help.
- As long as it's not clear what kind of tax rate is used for calculating taxes for a given price, the price is always
  stored as a net price. Otherwise, the gross price can be stored together with information about the tax rates it's
  based on.