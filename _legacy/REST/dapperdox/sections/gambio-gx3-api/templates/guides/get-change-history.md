Navigation: Getting started/Receiving a Change History
sortOrder: 155

# Receiving a Change History

The API supports various filtering options when performing GET requests upon resources. 
Further filtering option are `changed`, `modified` and `deleted`, which can be used to receive only changed or deleted entities.
These three filtering options can be used as query parameters, that can be for a GET request.

Not all endpoint do except these parameters. At the moment they are only available for Customers, Categories, Products and Orders.


## changed
This parameter can be used to receive changed and deleted entities of certain endpoint.

**Example Request:**
```
curl -i https://example.org/api.php/v2/customers?changed=2018-01-01
```

**Example Response:**
```
{
	"updated": [
		{
			"id": 1,
			"number": "1",
			"gender": "m",
			"firstname": "John",
			"lastname": "Doe",
			"dateOfBirth": "1985-02-13",
			"vatNumber": "0923429837942",
			"vatNumberStatus": 0,
			"telephone": "0049 0123 456789-0",
			"fax": "0049 0123 456789-1",
			"email": "admin@example.org",
			"statusId": 0,
			"isGuest": false,
			"addressId": 1,
			"addonValues": {
				"test_key": "test_value"
			}
		}
	],
	"deleted": [
		{
			"id": 1,
			"date": "2018-01-01 11:11:11"
		}
	]
}
```


## modified
This parameter can be used to receive only changed entities of certain endpoint.

**Example Request:**
```
curl -i https://example.org/api.php/v2/customers?modified=2018-01-01
```

**Example Response:**
```
{
	"updated": [
		{
			"id": 1,
			"number": "1",
			"gender": "m",
			"firstname": "John",
			"lastname": "Doe",
			"dateOfBirth": "1985-02-13",
			"vatNumber": "0923429837942",
			"vatNumberStatus": 0,
			"telephone": "0049 0123 456789-0",
			"fax": "0049 0123 456789-1",
			"email": "admin@example.org",
			"statusId": 0,
			"isGuest": false,
			"addressId": 1,
			"addonValues": {
				"test_key": "test_value"
			}
		}
	],
	"deleted": []
}
```

**Notice:** The `deleted` attribute is available in the response, but it won't have any other value.


## deleted
This parameter can be used to receive only changed entities of certain endpoint.

**Example Request:**
```
curl -i https://example.org/api.php/v2/customers?deleted=2018-01-01
```

**Example Response:**
```
{
	"updated": [],
	"deleted": [
		{
			"id": 1,
			"date": "2018-01-01 11:11:11"
		}
	]
}
```

**Notice:** The `updated` attribute is available in the response, but it won't have any other value.