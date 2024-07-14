# Gambio GX3 REST API Swagger-Documentation

The Swagger 2.0 specification enables us to introduce new documentation tools, 
for example using [Dapperdox](http://dapperdox.io/) in favour of ApiDoc at [developers.gambio.de](developers.gambio.de).
Furthermore we are striving for a more centralized and maintainable solution with the end-costumer in mind.

This guide provides you with a quick rundown on how to use our swagger toolchain - for more in-depth information on the swagger format and its features, refer to their [official page](swagger.io).
Do note, that we are currently using Swagger 2.0 instead of 3.0. This is due to 2.0 already having plenty of community resources to extend from.

## Why Swagger?
The swagger format describes a unified file (swagger.json) to hold all documentation on endpoints of the REST API, 
including its JSON responses, HTTP status codes, possible path parameters, 
query parameters such as `?limit=n&offset=x` and example response messages.

At Gambio, this unified swagger.json is concatenated from various smaller YAML files 
(see the folders `api/` and `definitions/` in this README's directory).

Having each API endpoint described in its seperate YAML file, 
compared to our former ApiDoc approach, where documentation was within the source code, provides us with clearer means to: 
- keep the documentation up-to-date and structured
- keep the source code clean
- diminish redundancies

## Adding Endpoints
When adding a new endpoint to the API documentation, 
all you have to do is add a corresponding YAML file in the `api/` directory. 
Best practice to this, as developers generally like it, 
is to duplicate an existing endpoint definition, and alter it to its new requirements.

The structure to the API definitions is to be kept consistent. 
For example, if we were to introduce a new endpoint `GET example.com/api/pets/:id`, we would create a new file in `api/pets/get_pets_(id).yml`. 
To provide quick navigation, the file name should sufficiently resemble what this part of the documentation is about.

Given the following simple example, the overall structure can be explained easily.
I will include comments identified by a `#` symbol, keep in mind that this is currently NOT supported and should be omitted when writing documentation.
```
/pets/{pet_id}: # the endpoint's URL. The dynamic parameter's name should be provided semantically.
      get: # the HTTP Method for this endpoint
            tags: # an array of strings to provide easy filtering and navigation
                  - 'pet'
            summary: 'Find pet by ID'
            description: 'Returns a single pet'
            operationId: 'getPet' # a unique identifier for this operation
            produces:
                  - 'application/json'
            parameters: # an array describing request parameters
                  - name: 'pet_id'
                    in: 'path' # here the parameter is in the URL path, it can also be provided as a query, cookie, header, ...
                    description: 'ID of the pet to return'
                    required: true
                    type: string
            responses: # the HTTP status codes that may be a response to this operation
                  200:
                      description: 'Upon success, returns the pet that was fetched'
                      schema:
                            $ref: '#/definitions/Pet' # a reference to a returned definition schema, see below
                  400:
                      description 'Invalid ID supplied'
                  404:
                      description: 'Pet not found'
```

## Schemas and $ref

In the above example-endpoint's `response` section, the exotic `$ref` key provides an object schema that this endpoint is returning.

Schemas are described as files in the `definitions/` directory, adjacent to `api`. 
The overall structure closely resembles the one for endpoint-documentation above, however, the files in this directory do not document endpoints but rather object-definitions that in turn are included in an endpoint's responses.

Just as with endpoint documentation, object defining YAML files are to be grouped according to their subject, and should reflect their cause in the file name.

Here's to provide the above documentation's object schema reference. Lines again are commented, which is not supported in production.
```
Pet: # The first line should denote the definition's name that is referenced via $ref
    type: object
    properties: # arbitrary keys defining the object's data-types
        id:
           type: integer
           format: int64 # when provided an integer, the format is to be included. This is not the case for string or array.
           readonly: true
        name:
           type: string
        species:
           type: string
           enum: # You can document that certain properties may only contain certain values
                - 'dog'
                - 'cat'
                - 'parrot'
        category:
           $ref: '#/definitions/Category' # Schemas referencing other definitions (nested definitions) are perfectly fine
    required:
        - id
        - name
    example: # The example section is helpful for API-consumers, and should always be included
        id: 1
        name: "Woof Doe"
        species: 'dog'
        category: # when another definition is referenced, the example has to be provided in the definition referencing it.
            id: 1
            name: 'stray'
```