#### Internal Use Only - Should Not Be Released


## ExceptionTransmitter


The ExceptionTransmitter component allows you to send an Exception and additional data to a project-specific Sentry
server.

It utilizes an internal cache to prevent the same error from being sent more than once within a 24-hour period.

**This information is stored in the cache directory, and deleting the transmission cache file will result in the generation of additional reports.**

An Exception will only be sent if the user has consented to data transfer by installing the "Send error reports" module
from the Modules-Center. It's important to note that this consent check is internal to the service and does not require 
any additional actions outside of it.


### How to Transmit an Exception

To transmit an Exception, use the following code:

```php
/** @var \Gambio\Core\ErrorHandling\Services\ExceptionTransmitter $transmitter */
$transmitter->handleException(
    new \Exception('Send me please'), 
    ['optional none sensitive data']
);
```

The `handleException` method accepts two arguments: the first is the Exception itself, 
and the second is an optional argument for context data, which must be provided as an array. 
Please ensure that the context data does not contain any sensitive information or personally identifiable
information about users.