Navigation: Getting started/Example Requests
sortOrder: 130

# Example Request

The following example will show you how to make a simple request to the API. By making a `GET` request 
to the `https://example.org/api.php/v2` you will get a JSON object with the currently available resources and the URIs.

**Request through cURL:**
```
curl -i https://example.org/api.php/v2
```

**Response:**
```
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