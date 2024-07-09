Navigation: Getting started/Method Override
sortOrder: 160

# Method Override

Some development ecosystems do not support modern HTTP methods and are limited to "GET" and "POST" requests. 
The API provides a method override feature where requests that contain the `X-HTTP-Method-Override` 
header will be taken into concern for the resource routing.

**Example:**

```
POST /api.php/v2/customers/57 HTTP/1.1
Host: localhost:10320
Content-Type: application/json
X-HTTP-Method-Override: PUT
Cache-Control: no-cache
```