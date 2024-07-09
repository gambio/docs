# Docs (and documentation)

This directory contains documents mainly for documentation purpose. Its content is used to generate the developers'
documentation published for each master and feature version.

The `ADRs`, `REST` and `Tutorials` directories are the most important directories for the current and future
development of the shop software:

* The `ADRs` directory contains the [Architecture Decision Records]{target=_blank} for the Gambio Shop software.
  Please have in mind, that only the current development branch contains the latest versions of the ADRs.
  More information about ADRs can be found in the [first ADR] itself.
* The `REST` directory contains the OpenAPI v3 specifications for our REST API v2 and v3. More information about the
  specification files can be found in the [API README].
* The `Tutorials`directory contains the tutorials that are based on markdown files.
  * `Tutorials/GX3` contains the tutorials for the (older) GX 3 systems. More information about these tutorials can
    be found in the [GX3 tutorials README].
  * `Tutorials/GX4` contains the tutorials for the new GX 4 architecture, framework, business domains and general
    development for the shop software. More information about these tutorials can be found in the [GX4 tutorials
    README].
    

## Commands

There are some `yarn` commands that can be used to work with some parts of the developers' documentation:

* `yarn docu:build` builds the complete developers' documentation based on the content of the `docs` directory.
* `yarn docu:build-tutorials` generates the static HTML/CSS/JS files for the GX4 tutorials.
* `yarn docu:build-api-v3` and `yarn docu:build-api-v2` generates the static HTML/CSS/JS files for the REST API
  documentation.
* `yarn docu:serve-tutorials` sets up a local webserver, that serves the static HTML/CSS/JS files for the GX4
  tutorials and allows hot reloading.
* `yarn docu:build-api-v3` and `yarn docu:build-api-v2` sets up a local webserver, that serves the static HTML/CSS/JS
  files for the REST API documentation and allows hot reloading.


[Architecture Decision Records]: https://github.com/joelparkerhenderson/architecture_decision_record
[first ADR]: ./ADRs/001-starting_adr.md
[API README]: ./REST/README.md
[GX3 tutorials README]: ./Tutorials/GX3/README.md
[GX4 tutorials README]: ./Tutorials/GX4/README.md