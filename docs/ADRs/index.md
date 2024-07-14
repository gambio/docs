# We are going to create architectural decision records

**Created:** 2019-11-28 by Mirko

**Status:** accepted

**Decision makers:** Moritz, Daniel Wu


## Context

Sometimes it is hard to remember why certain decisions where made and in which context. Additional it is also difficult
to find specific information about architectural systems and how we things should be done correctly.

In context of refactoring the core system of the shop, there are many decisions that need to be done and it seems very
important to find a good way to communicate these decisions with the whole team. That's why it seems like a good idea
to introduce **architectural decision records** (ADR).

Here a short overview about the topic. An **architectural decision** (AD) is a design decision considering the
architecture of the software, that addresses architecturally significant requirements. An **architecture decision
record** (ADR) is a document that captures an important architectural decision made along with its context and
consequences. An **architecture decision log** (ADL) is the collection of all ADRs created and maintained for a
particular project (or organization).

More information can be found on [wikipedia](https://en.wikipedia.org/wiki/Architectural_decision)
or [here](https://github.com/joelparkerhenderson/architecture_decision_record).


## Decision

We are going to create architectural decision records based on this [template](attachments/001-template.md) for
every architectural decision. Everyone will be allowed to create and propose new ADRs. New ADRs will be created to
propose changes to existing ADRs.

After a AD has been accepted, the ADR status will be changed and everyone at Gambio, that is developing for the shop
software, will mind these decisions and follow them.

If a AD has been rejected or if it is deprecated, that status of the ADR will also be updated and a short text about
it will be added to the ADR.

For each new proposed ADR a Bitrix post will be created for the "Entwicklung (Core)" group, so that every developer
will be notified and there is the possibility to discuss certain ADs, even if the decision itself will be done by the
deciders.

The latest ADRs will always be in the latest feature development branch of the shop software.


## Consequences

**Positive:**

* It will be easier to find/remember architectural decisions, that have been made in the past
* Architectural decisions should be more comprehensible
* Information about how to solve/implement certain architectural problems/components can be found easier
* The documentation of this software will be become better

**Negative:**

* Making architectural decisions will more time consuming