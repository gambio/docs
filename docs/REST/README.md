# REST API documentation

This directory contains the specifications to build the API documentation of the Gambio REST API. The build process is
based on OPEN API v3 specifications, an HTML/CSS/JS template, and some external Node modules included by Yarn.

The OpenAPI v3 specifications are split into several files, which isn't of the [OpenAPI v3 standard] but allows better
handling for a high number of endpoints. Therefore, the separate files need to be merged, so that the tool that
generates the documentation can process the specification correctly.

As you can see, the `[v2|v3]/openapi.json` uses JSON references to include additional content of other JSON or YAML
files. The Node module `json-refs` merges the content (or resolving the references to external files) and creates the
`[v2|v3]/resolved.openapi.json` file, which is used by the Node module `redoc-cli` to generate the documentation.
The documentation is not only based on the content of the OpenAPI v3 specification, a template located at `./template`
is used by the Redoc CLI tool and defines the look of the generated web page.

> __Note:__ Each JSON file can be replaced with a YAML files (and the other way around). For the merging CLI tool it
> doesn't matter, if a JSON or YAML file is referenced.


## Structure of the specification folder

As said, the specification is split into several files, which can be found in the `[v2|v3]` directory. The
sub-directories mirrors the structure of the [OpenAPI v3 standard] based on the `[v2|v3]/openapi.json` file.

* `[v2|v3]/components`  
  This directory contains definitions of parts of the request and response body, as well as the HTTP header. The
  internal structure of the [OpenAPI v3 standard] is strictly mirrored in this directory. The contained `index.json`
  files are used to structure the other JSON/YAML files in the same directory or the directories below.
  
* `[v2|v3]/paths`  
  This directory contains the files that define the several API endpoints. The `[v2|v3]/paths/index.json` file
  defines the URLs and references the corresponding HTTP methods. The contained `index.json` inside the sub-directories
  (e.g. `[v2|v3]/paths/parcel-services/index.json`) maps a specific HTTP method with the json files, that defines
  the endpoint specifications.
  
* `[v2|v3]/tags`  
  This directory contains the tags. Each group of API endpoints have a specific tag. E.g. all endpoints starting with
  `api.php/v3/parcel-service` belong to the tag *parcel service* and the files `[v2|v3]/tags/parcelServices.json`.
  It's also possible to add additional tags to the specification to provide additional information, like its done
  with the `[v2|v3]/tags/generalInformation.yaml` file. The tag files need to be referenced in the
  `[v2|v3]/openapi.json` file.


## How to define a new API endpoint

At first, you need to understand the [OpenAPI v3 standard]. It's similar to the v2 standard, that is used to define the
Gambio REST API v2 endpoints, but doesn't match one-to-one.

To define the structure of the request and response body, you need to define their schemas by creating new files and a
new sub-directory inside `[v2|v3]/components/schemas` (similar to the existing schemas). References to other schema
files can and should be used. After adding the new schemas, you need to add them to the
`[v2|v3]/components/schemas/index.json` as well. The assigned JSON key is later used to reference the schemas in the
definition files for the endpoints. E.g. the reference `#/components/schemas/trackingCodes-trackingCode` would
reference the schema defined in `[v2|v3]/components/schemas/trackingCodes/trackingCode.json`.

To define new HTTP endpoints, you need to define their schemas by creating new files and new sub-directories inside
`[v2|v3]/paths`. References to other schema files are also possible, but you should use the internal references
(e.g. `#/components/schemas/trackingCodes-trackingCode`) to reference schemas for response and request bodies, etc.
After adding the new schemas, you need to add them to the `[v2|v3]/paths/index.json` as well.



[OpenAPI v3 standard]: http://spec.openapis.org/oas/v3.0.3