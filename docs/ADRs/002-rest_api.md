# Following a specific concept for the new REST API v3

**Created:** 2019-11-29 by Mirko

**Status:** accepted

**Decision makers:** Daniel Wu, Moritz, Wilken

**Last updated:** 2022-01-21 by Mirko

## Context

Currently, we are serving a REST API v2 with the shop software, which contains many endpoint for certain shop entities
etc. But it is noticeable, that some endpoint following different rules or concept than others. Furthermore, the current
API v2 dynamically determines the needed HTTP Controller based on the URL and don't use internal routing maps.

Because of these and more quirks, it's hard to implement new features or change existing endpoints. Therefore, we need a
new version of the REST API!

For creating a new version of the REST API it seems useful to setup a specific concept that should be use for planning
or implementing new API v3 endpoints.

The decision in this ADR is based on best practices and internal discussions as well as external requirements from ERP
systems.

The use of GraphQL has also been part of the discussion, but didn't fit in our current requirements (see
**Consequences**).

## Decision

We are documenting every API endpoint by using the
[OpenAPI v2 specification](https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md).

An example of some well documented endpoints can be found [here](attachments/002-example.api.yml).

### Naming of routes

While naming the routes, the endpoints are be grouped if the handle the same resources and plural forms are used.
E.q. `/api.php/v3/customers` contains every endpoints using the customer resources. Read, add, edit and delete actions
are encapsulated as HTTP methods (see "Request methods"). The resource routes should be as flat as possible.

### Request methods

We are using the following request methods like:

* `GET` is used to fetch a list or a specific document. `GET /api.php/v3/customers` will return a list of customers.
* `POST` is used to create one or more documents. `POST /api.php/v3/customers` will create on or more customers.
* `PUT` is used to update one or more documents. `PUT /api.php/v3/customers` will update on or more customers and
  `PUT /api.php/v3/customers/1` will update the customer with the ID 1.
* `PATCH` is used to patch one or more documents. `PATCH /api.php/v3/customers` will patch on or more customers and
  `PATCH /api.php/v3/customers/1` will patch the customer with the ID 1.
* `DELETE` is used to delete one or more documents. `DELETE /api.php/v3/customers/1` will delete the customer with the
  ID 1 and `DELETE /api.php/v3/customers/1,2,3` will delete the customers with the ID 1, ID 2 and ID 3.

> We are especially using `POST` for creating documents, because of bulk requests. Otherwise the client could mix
> create and update actions in one request.

> `PATCH` endpoint are optional. A new domain does't need to have these functionality and should only be implemented,
> if there is a real use case.

### Status codes

We are using the following status codes for responses like:

* General
    * `403` is used, if the requesting client isn't authorized.
    * `500` is used for unexpected errors.
* `GET`
    * `200` is used for successful requests.
    * `404` is used, if a specific document doesn't exist.
* `POST`
    * `201` is used for successful create requests.
    * `400` is used, if the data in the request body are incomplete or malformed.
    * `409` is used, if a conflict of data exists, even with valid information. E.q. a customer already exists with the
      same email address and it is not allowed to have two customers with the same email address.
    * `422` is used, if the data in the request body are okay, but invalid.
* `PUT`
    * `204` is used for successful update requests.
    * `400` is used, if the data in the request body are incomplete or malformed.
    * `404` is used, if the document that should be updated doesn't exist.
    * `409` is used, if a conflict of data exists, even with valid information. E.q. a customer already exists with the
      same email address and it is not allowed to have two customers with the same email address.
    * `422` is used, if the data in the request body are okay, but invalid.
* `PATCH`
    * `204` is used for successful patch requests.
    * `400` is used, if the data in the request body are incomplete or malformed.
    * `404` is used, if the document that should be patched doesn't exist.
    * `409` is used, if a conflict of data exists, even with valid information. E.q. a customer already exists with the
      same email address and it is not allowed to have two customers with the same email address.
    * `422` is used, if the data in the request body are okay, but invalid.
* `DELETE`
    * `204` is used for successful delete requests.

> Error handling and validation should be done as complete as possible to provided as many error information as
> possible. E.q. should a 422 error result contain information about every invalid attribute in the provided request
> body.

> The `DELETE` response will also return an `204` status code, even if the document with the provided ID does not exit.

### Responses

All API response have the `application/json` content type and must always contain the following HTTP headers:

* `X-Shop-Version` contains the current shop version.
* `X-API-Version` contains the current REST API version.
* `X-Rate-Limit-Limit` contains the request limit per hour.
* `X-Rate-Limit-Remaining` contains the remaining request for the current time frame.
* `X-Rate-Limit-Reset` contains the number of seconds til the current rate limit will be reset.

> The listed HTTP headers are just the minimum set of headers, depending the endpoint it's possible to add additional
> HTTP headers.

Links will be part of the response body and should be added to the `_meta` attribute, depending on the executed request.
E.q. a link to a specific customer resource inside the response body of a specific orders document.

The response body of a successful request is always enveloped, and contain an attribute `data` with the result data and
an attribute `_meta` for meta information:

```json
{
    "data": {
        ...
    },
    "_meta": {
        ...
    }
}
```

The response body of a failed request is always enveloped, and contain an attribute `errors` with information about the
errors and an attribute `_meta` for meta information:

```json
{
    "errors": {
        ...
    },
    "_meta": {
        ...
    }
}
```

The response for a create, update or patch request don't contain the complete documents on success. The response of a
create request will contain a link and the ID of the created document. The response of a update, patch or delete request
should contain no response body and have a 204 status code.

A `GET` endpoint that will return a collection of documents can be customized by the following query parameters:

* `per-page` is used to change the number of documents, that will be returned per page.
* `page` is used for pagination and changes the page of a collection, that will be returned.
* `fields` is used to filter the attributes of the documents, that will be returned. The `fields` parameter always
  contains document attributes and never database column etc.
* `sort` is used to sort the documents, that will be returned. The `sort` parameter always contains a comma seperated
  list of the document attributes. A `+` (ascending) or `-` (descending) at the beginning of a attribute can be used
  modify the order. If no specific order is provided than a ascending order should be used.
* `filter` is used to filter the documents, that will be returned, based on the provided rules. The `filter` parameter
  is always an array, which maps a specific filter pattern to a document attribute. The filtering on string attributes
  must allow wildcards (`*` character) and be case insensitive. The API must also provided the possibility to use
  operations like greater (gt), greater equals (gte), less (lt), less equals (lte) for numeric or datetime attributes.
  If no operation is provided, it will be handled as an equals operation. The operation must be part of the value and
  can be added before the filter pattern, like the following examples show:
    * `GET /api.php/v3/customers?filter[firstName]=John` will return all customers with first name "John".
    * `GET /api.php/v3/customers?filter[firstName]=J*` will return all customers whose first name begins with "J".
    * `GET /api.php/v3/customers?filter[firstName]=J*&filter[id]=*1` will return all customers whose first name begins
      with "J" and whose ID will end with an one.
    * `GET /api.php/v3/customers?filter[id]=gt|42` will return all customers whose ID is greater than 42.
    * `GET /api.php/v3/customers?filter[id]=gte|42` will return all customers whose ID is equals or greater than 42.
    * `GET /api.php/v3/customers?filter[id]=lt|42` will return all customers whose ID is less than 42.
    * `GET /api.php/v3/customers?filter[id]=lte|42` will return all customers whose ID is equals or less than 42.
    * `GET /api.php/v3/customers?filter[id]=neq|42` will return all customers whose ID is not equal to 42.
    * `GET /api.php/v3/customers?filter[id]=eq|42` or `GET /api.php/v3/customers?filter[id]=42` will return the customer
      with the ID 42.

A `GET` endpoint that will return a collection of documents does always provided pagination links inside the `_meta`
attribute, as well as additional meta information about the total number of documents, the current per-page and page,
like:

```json
{
    "data": [
        ...
    ],
    "_meta": {
        "totalItems": 145,
        "page": 3,
        "perPage": 25,
        "links": {
            "firstPage": "/api.php/v3/customers?page=1",
            "previousPage": "/api.php/v3/customers?page=2",
            "nextPage": "/api.php/v3/customers?page=4",
            "lastPage": "/api.php/v3/customers?page=5"
        }
    }
}
```

The response of a `GET` endpoint, that will return a collection of documents, is always enveloped and does always
provide meta information about the total number of documents, the current page and per-page values. (Additional meta
information are possible.)

### Bulk requests

In general, we are implementing endpoints for bulk request and only don't, if there is a good reason not to do this.

Bulk requests are implemented for creating and updating documents and will be have the same route like the base route
for requesting a collection of documents, e.q. `POST /api.php/v3/customers` or `PUT /api.php/v3/customers`.

For the bulk delete request we will accept a comma-separated list of IDs of documents, that should be deleted, as path
parameter like: `DELETE /api.php/v3/customers/1,2,3`

Bulk request are handled as one transaction, if a single create, update, patch or delete fails, then there will be a
rollback.

The request body for bulk creation and updates should always be a simple JSON array. The keys of this array should be
used for the response body. In case of a successful action, e.q. the ID of the created document can be mapped to this
key. In case of an error, e.q. the errors can be mapped to this key. This way the client can still identify which
created ID or which error belongs to which document.

> Please have in mind, that a PHP array is only also a JSON array, if its keys are consecutive numbers starting at 0.

#### Links as meta information

Every REST API responses should provide links as meta information as far as possible. These could be links to newly
created entities or related ones. We should attempt to link our resources as tightly as possible, which means that:

- Sub-resources should link their main resources if possible.  
  E.g. `GET /api.php/v3/customers/{customerId}/memos/{memoId}` should link to `GET /api.php/v3/customers/{customerId}`
- Resources should link to related resources even if there might be no data, as long as an empty collection will be
  returned.  
  E.g. `GET /api.php/v3/customers/{customerId}` should link to `GET /api.php/v3/customers/{customerId}/memos` even
  though there are no actual memos for that customer.
- The `links` array as part of the `_meta` block of the response should always be a map and have a descriptive key for
  their related links.

## Consequences

We won't use GraphQL for creating a new web API, because we want to focus on creating stable endpoint and domain
services, instead focusing on a new technology. A further reason why we choose REST instead of GraphQL, is a simple
cost-benefit calculation: We don't thing, that there is a big need for a web API based on GraphQL. Furthermore, the API
v3 will be more likely an additional API for the existing v2 API and not a fully covering shop API. Currently, it is
more likely that a future v4 API will be based on GraphQL.

We introduced a general attribute for meta information and envelop every response body. Furthermore, we handle bulk
request as one and will use transactions that can be rolled back. This will probably increase the effort of implementing
a new endpoint, but also improve the use- and accessibility.

We also want to write the API documentation first and test our API endpoint against this documentation to improve the
completeness and timeliness of the documentation.

It's likely that these rules will need an update in the future, after we implemented some new endpoints.

## Updates

### Request body of bulk request should always be a JSON array (2020-07-30)

Currently, it's too hard to handle JSON arrays and objects as a request body for bulk requests simultaneously. That's
why we (Toby, Moritz, and Mirko) decided that the request body of a bulk request should be a JSON array.

This way, it's easier to define a schema for the OpenAPI specifications, and it's also easier to parse the request body
with PHP.

### Added new example request for filter (2021-08-11)

The new endpoints for the REST API v3 should also support the `neq` operator, that's why I added it to the filter sample
requests.

### Added new section about linking resources (2022-01-21)

The new section `Links as meta information` was added to emphasize the importance of linking related resources.