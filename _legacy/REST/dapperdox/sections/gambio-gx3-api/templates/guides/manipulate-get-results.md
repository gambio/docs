Navigation: Getting started/Manipulate Get Results
sortOrder: 150

# Manipulate Get Results

The API supports various filtering options when performing GET requests upon resources. 
You can paginate, sort, search and minimize the results by providing specific GET parameters to the resource URL.

**Pagination:**  The default `per_page` value is 50 records. This applies if you omit the per_page parameter.
```
https://example.org/api.php/v2/customers?page=1&per_page=10
```

**Sort:** Maximum sorting fields: 5 (+ ascending, - descending).
```
https://example.org/api.php/v2/customers?sort=+lastname,-firstname,+telephone
```

**Search:** Keyword must be url encoded.
```
https://example.org/api.php/v2/customers?q=keyword
```

**Minimize Response:** Provide comma-separated field names that you want to be included in the response.
```
https://example.org/api.php/v2/customers?fields=id,lastname,firstname,email
```

Combination of the above parameters is allowed as shown in the following example.
```
https://example.org/api.php/v2/customers?page=2&per_page=15&fields=id,lastname,firstname,email&sort=-id
```