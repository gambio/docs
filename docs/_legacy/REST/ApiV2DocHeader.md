---

### Overview
Since Gambio GX2 v2.4 the shop system features a new RESTful API that is able to serve the application data to client 
consumers. This documentation reference will provide you analytic guides on how the API works, which resources are 
available and the proper way to request them efficiently. You will also find useful information in the "Appendices" 
section like resource representations and detailed change log. 

This document is more likely to be updated in the future whenever there are new revisions of the APIv2 of the shop 
system. It will feature a spot-the-difference mechanism so that you can easily see the changes that have been 
introduced. A changelog section is also provided at the end. In any case all minor changes will not break the public 
resource definitions, at least not without informing about deprecated properties and values in time. 

Thank you for using the Gambio GX3 API!

### Client Libraries
You can download one of the following client libraries which will enable you to easily consume the REST API within 
your systems. The list will be extended with new clients in the future. Feel free to contribute your own clients by 
sending an email to info@gambio.de.   

| Name                   | Language        | Author              | License | Link		                                      |
| ---------------------- | --------------- | ------------------- | ------- | ------------------------------------------------ |
| node-gambio-api-client | JavaScript/Node | Ronald Loyko        | GPL-2.0 | https://github.com/gambio/node-gambio-api-client |


### Concepts 
This API provides an easy way to access your shop information and manipulate them in external applications. It follows 
the REST architecture and uses JSON as the data format for all transactions. It is very easy to use from any language 
that supports the HTTP protocol. This section aims to cover the basic characteristics of the API before you make your 
first request.

#### Available Resources
As this is a work in progress not all API resources are ready yet. Keep up with the project updates and check the 
changelog for new resources and improvements of each release.

**Currently Available Resources**

- Addresses
- Categories
- Countries
- Customers
- Emails
- Orders
- Products
- Zones

This documentation contains a section for every possible operation inside the API context. Most resources support the 
basic CRUD operations but you should read them carefully and look at their examples in order to get a better 
understanding on their purpose. 

#### Error Handling 
Every error response will contain a valid HTTP Status Code. They will provide information about the request and the 
reason of the failure in order to make debugging easier. If for some reason this is not enough, you can always enable 
the `development` or `test` configuration of the API by editing the `api.php` file in the shop's root directory.

**Example:**
```json
{
  "code": 404,
  "status": "error",
  "message": "Record could not be found.",
  "request": {
    "method": "GET",
    "url": "http://example.org",
    "path": "/api.php/v2/addresses/3",
    "uri": {
      "root": "/api.php",
      "resource": "/v2/addresses/3"
    }
  },
  "errors": [
  	{
	  "file": "/var/www/html/GXEngine/Controllers/Api/v2/AddressesApiV2Controller.inc.php",
	  "line": 71, 
	  "stack": [
	    {
		  "function": "get",
		  "class": "AddressesApiV2Controller",
		  "type": "->",
		  "args": []
	    }
	  ]
  	}  
  ]
}
```

#### Method Override 
Some development ecosystems do not support modern HTTP methods and are limited to "GET" and "POST" requests. The API 
provides a method override feature where requests that contain the `X-HTTP-Method-Override` header will be taken into 
concern for the resource routing. 

**Example:**
```
POST /api.php/v2/customers/57 HTTP/1.1
Host: localhost:10320
Content-Type: application/json
X-HTTP-Method-Override: PUT
Cache-Control: no-cache
```

#### Managing GET Results 
The API supports various filtering options when performing GET requests upon resources. You can paginate, sort, search 
and minimize the results by providing specific GET parameters to the resource URL.
 
**Pagination:**
The default `per_page` value is 50 records. This applies if you omit the per_page parameter.
 
```
https://example.org/api.php/v2/customers?page=1&per_page=10
```

**Sort:**
Maximum sorting fields: 5 (+ ascending, - descending).

```
https://example.org/api.php/v2/customers?sort=+lastname,-firstname,+telephone
```

**Search:**
Keyword must be url encoded.

```
https://example.org/api.php/v2/customers?q=keyword
```

**Minimize Response:**
Provide comma-separated field names that you want to be included in the response.

```
https://example.org/api.php/v2/customers?fields=id,lastname,firstname,email
```

Combination of the above parameters is allowed as shown in the following example.

```
https://example.org/api.php/v2/customers?page=2&per_page=15&fields=id,lastname,firstname,email&sort=-id
```

#### HATEOAS Support
HATEOAS stands for Hypermedia as the Engine of Application State and describes the use of links which point to external 
resources or actions that are related to a specific resource. The API will provide links where possible in the `Link` 
header or in the resource payload (`_links` property). 
 
**Request:**
```
https://example.org/api.php/v2/addresses?page=3&per_page=20
```
 
**Link Header:**
```
Link Header →
<https://example.org/api.php/v2/addresses?page=1&per_page=20>; rel="first", 
<https://example.org/api.php/v2/addresses?page=2&per_page=20>; rel="previous", 
<https://example.org/api.php/v2/addresses?page=4&per_page=20>; rel="next", 
<https://example.org/api.php/v2/addresses?page=5&per_page=20>; rel="last"
```

**Response Body:** 
```json
{
  "firstname": "John", 
  "lastname": "Doe", 
  "city": "Bremen",
  "_links": {
    "customer": "https://example.org/api.php/customers/2",
    "country": "https://example.org/api.php/countries/81",
    "zone": "https://example.org/api.php/zones/84"
  }
}
```

You can disable the "_links" property by providing a GET parameter with the name `disable_links`. This param does not 
need to contain any value and is used as in the following example: 

```
https://example.org/api.php/v2/addresses?page=3&per_page=20&disable_links&fields=firstname,lastname,city
```

**Response Body:** 
```json
{
  "firstname": "John", 
  "lastname": "Doe", 
  "city": "Bremen"
}
```

#### HTTP Caching Support
Web caching is not currently supported by any resource but is planned for a future release of the API. Caching support 
will be stated in each section explicitly and the API will return an `ETag` or `Last-Modified` along with an `Expires` 
headers, containing information about the provided response. 

---

### Getting Started
This sections aims to get you started with API by making a simple request. You will need to authorize and provide the 
required headers in order to get the response. You can set the `api.php` environment to `develop` if you want to get 
analytic error information but do not forget to set it back to `production` when finished with testing. All the API 
resources are accessible more or less in the same way.

#### Request Requirements
All requests must meet the following requirements in order to be accepted by the API. Otherwise a 400 error will be 
returned stating the validation failure of the request.

1. `User-Agent` header must always be present. 
2. POST/PUT/PATCH requests must include JSON formatted data directly in the request body.
3. POST/PUT/PATCH requests must contain the `Content-Type` equal to `application/json`. 

**Rule (2) and (3) do not apply when uploading an email attachment or any other file.**

#### Example Request
The following example will show you how to make a simple request to the API. By making a `GET` request to the 
`https://example.org/api.php/v2` you will get a JSON object with the currently available resources and the URIs.

**Request through cURL:** 
```
curl -i https://example.org/api.php/v2
```

**Response:**
```json
{
  "addresses": "https://example.org/api.php/v2/addresses",
  "attachments": "https://example.org/api.php/v2/attachments",
  "categories": "https://example.org/api.php/v2/categories",
  "category_images": "https://example.org/api.php/v2/category_images",
  "category_icons": "https://example.org/api.php/v2/category_icons",
  "countries": "https://example.org/api.php/v2/countries",
  "customers": "https://example.org/api.php/v2/customers",
  "emails": "https://example.org/api.php/v2/emails",
  "orders": "https://example.org/api.php/v2/orders",
  "product_images": "https://example.org/api.php/v2/product_images",
  "products": "https://example.org/api.php/v2/products",
  "zones": "https://example.org/api.php/v2/zones"
}
```

#### Authentication
Every request of the API needs to be authenticated otherwise a `401 Unauthorized` response will be returned. The client 
will need to use the administrator user's credentials through the HTTP Basic Auth header. **That means that if you plan 
to use the API of your shop installation you will need to do it through the HTTPS protocol in order to be secure.** You 
can enable HTTPS by purchasing an SSL certificate for your server. 

The HTTP Basic Auth header works by providing the username:password string combination encoded in base64. The header 
expected by the API must look like this `Authorization: Basic YWRtaW5Ac2hvcC5kZToxMjM0NQ==` which stands for 
`admin@example.org:12345`.

You can find more information about basic HTTP authentication in the Wikipedia article:
<https://en.wikipedia.org/wiki/Basic_access_authentication>


#### JSONP
JSONP is not supported because the API requires authentication for every request and this is not possible with this 
technique.
