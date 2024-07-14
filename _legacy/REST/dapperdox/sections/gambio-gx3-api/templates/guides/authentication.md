Navigation: Getting started/Authentication
sortOrder: 120

# Authentication

Every request of the API needs to be authenticated otherwise a `401 Unauthorized` response will be returned. 
The client will need to use the administrator user's credentials through the HTTP Basic Auth header. 
**That means that if you plan to use the API of your shop installation you will need to do it through the HTTPS protocol in order to be secure.** 
You can enable HTTPS by purchasing an SSL certificate for your server.

The HTTP Basic Auth header works by providing the username:password string combination encoded in base64. 
The header expected by the API must look like this `Authorization: Basic YWRtaW5AZXhhbXBsZS5vcmc6MTIzNDU=` which 
stands for `admin@example.org:12345`.

You can find more information about basic HTTP authentication in the Wikipedia article: https://en.wikipedia.org/wiki/Basic_access_authentication

### JSONP

JSONP is not supported because the API requires authentication for every request and this is not possible with this technique.
