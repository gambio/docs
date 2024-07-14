Navigation: Getting started/Error Handling
sortOrder: 140

# Error Handling

Every error response will contain a valid HTTP Status Code. They will provide information about the request and the 
reason of the failure in order to make debugging easier. 
If for some reason this is not enough, you can always enable the `development` or `test` configuration of the API 
by editing the `api.php` file in the shop's root directory.

**Example:**

```
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