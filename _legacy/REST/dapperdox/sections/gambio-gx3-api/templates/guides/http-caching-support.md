Navigation: Getting started/HTTP Caching Support
sortOrder: 180

# HTTP Caching Support
Web caching is not currently supported by any resource but is planned for a future release of the API. 
Caching support will be stated in each section explicitly and the API will return an `ETag` or `Last-Modified` 
along with an `Expires` headers, containing information about the provided response.