Overlay: true

[[security]]

In order to provide the authentication, you must insert the Basic Auth inside the HTTP header. The Basic Auth
is an encrypted base64 string that holds the following content: `admin@example.org:12345` where the structure is 
as follows: `username:password`.

An example header would look as follows:

```http
Authorization: Basic YWRtaW5Ac2hvcC5kZToxMjM0NQ==
```