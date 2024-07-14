Navigation: Getting started/Request Requirements
sortOrder: 110

# Getting Started

This sections aims to get you started with API by making a simple request. You will need to authorize and provide the 
required headers in order to get the response. You can set the `api.php` environment to `develop` if you want to get 
analytic error information but do not forget to set it back to `production` when finished with testing. 
All the API resources are accessible more or less in the same way.

### Request Requirements
 
All requests must meet the following requirements in order to be accepted by the API. 
Otherwise a 400 error will be returned stating the validation failure of the request.

1. `User-Agent` header must always be present.
2. POST/PUT/PATCH requests must include JSON formatted data directly in the request body.
3. POST/PUT/PATCH requests must contain the `Content-Type` equal to `application/json`.

**Rule (2) and (3) do not apply when uploading an email attachment or any other file.**