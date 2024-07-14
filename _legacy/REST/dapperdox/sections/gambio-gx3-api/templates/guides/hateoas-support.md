Navigation: Getting started/HATEOAS Support
sortOrder: 170

# HATEOAS Support
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
```
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

You can disable the "_links" property by providing a GET parameter with the name `disable_links`. 
This param does not need to contain any value and is used as in the following example:
```
https://example.org/api.php/v2/addresses?page=3&per_page=20&disable_links&fields=firstname,lastname,city
```

**Response Body:**
```
{
  "firstname": "John", 
  "lastname": "Doe", 
  "city": "Bremen"
}
```