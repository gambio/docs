# Authentication

Authentication is an important part of the shop software. There are two ways of authenticate a user (normal customer
or admin):

1. Authentication by email address and password using the `UserAuthenticator` service
2. Authentication by a JSON web token using the `JsonWebTokenAuthenticator` service


## `UserAuthenticator` service

The `Gambio\Core\Auth\UserAuthenticator` service is used in most cases, e.g. the login page or REST API.
Besides the authentication of a user, this services provides the functionality to change the password of a user,
or to generate a request key if the user has forgotten his password.


### Authenticate a user

The `UserAuthenticator` provides a simple `authentication` method, which expects a user's email address and password.
The method returns a `Gambio\Core\Auth\UserId` object, which provides a `userId` method that returns the ID of
the authenticated user.

If the user can't be authenticated, a `Gambio\Core\Auth\Exceptions\AuthenticationException` exception will be thrown.

The following example shows how you could use this service:

```php
namespace GXModules\<Vendor>\<Module>;

use Gambio\Core\Auth\UserAuthenticator;
use Gambio\Core\Auth\Exceptions\AuthenticationException;

/**
 * Class SampleClass
 * @package GXModules\<Vendor>\<Module>
 */
class SampleClass
{
    /**
     * @var UserAuthenticator 
     */
    private $authenticator;
    
    
    /**
     * SampleClass constructor.
     *
     * @param UserAuthenticator $authenticator
     */
    public function __construct(UserAuthenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }
    
    
    /**
     * @param string $email
     * @param string $password
     *
     * @return int
     */
    public function checkUserCredentials(string $email, string $password): int
    {
        try {
            $userId = $this->authenticator->authenticate($email, $password);
            
            return $userId->userId();
        } catch (AuthenticationException $exception) {
            return false;
        }
    }
}
```

!!! Notice "Notice"
    This example expects you to use the [Service Provider] to register your classes to the [Application Core].
    If your are using the legacy architecture, you need to fetch this service using the [Legacy DI Container].


### Work in progress - Update user password

As said, the service also provides the possibility to update a users' password.

The following example shows how you could use this service:

```php
namespace GXModules\<Vendor>\<Module>;

use Gambio\Core\Auth\UserAuthenticator;
use Gambio\Core\Auth\UserId;
use Gambio\Core\Auth\Exceptions\UserNotFound;

/**
 * Class SampleClass
 * @package GXModules\<Vendor>\<Module>
 */
class SampleClass
{
    /**
     * @var UserAuthenticator 
     */
    private $authenticator;
    
    
    /**
     * SampleClass constructor.
     *
     * @param UserAuthenticator $authenticator
     */
    public function __construct(UserAuthenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }
    
    
    /**
     * @param int    $userId
     * @param string $newPassword
     *
     * @return bool
     */
    public function updateUserCredentials(int $userId, string $newPassword): bool
    {
        try {
            $this->authenticator->updateUserPassword($userId, $newPassword);
            
            return true;
        } catch (UserNotFound $exception) {
            return false;
        }
    }
}
```

!!! Notice "Notice"
This example expects you to use the [Service Provider] to register your classes to the [Application Core].
If your are using the legacy architecture, you need to fetch this service using the [Legacy DI Container].


### Work in progress - Generate request key

If a user forgot his password, it's possible to create a request key to change the password.

The following example shows how you could use this service:

```php
namespace GXModules\<Vendor>\<Module>;

use Gambio\Core\Auth\UserAuthenticator;
use Gambio\Core\Auth\UserId;
use Gambio\Core\Auth\Exceptions\UserNotFound;

/**
 * Class SampleClass
 * @package GXModules\<Vendor>\<Module>
 */
class SampleClass
{
    /**
     * @var UserAuthenticator 
     */
    private $authenticator;
    
    
    /**
     * SampleClass constructor.
     *
     * @param UserAuthenticator $authenticator
     */
    public function __construct(UserAuthenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }
    
    
    /**
     * @param int $userId
     *
     * @return string|null
     */
    public function updateUserCredentials(int $userId): ?string
    {
        try {
            return $this->authenticator->generateRequestKey($userId, $newPassword);
        } catch (UserNotFound $exception) {
            return null;
        }
    }
}
```

!!! Notice "Notice"
This example expects you to use the [Service Provider] to register your classes to the [Application Core].
If your are using the legacy architecture, you need to fetch this service using the [Legacy DI Container].


### Password hashes

Since the user's passwords are only available in the database as hashes, the validation of the passwords is based on
implementations of the `Gambio\Core\Auth\HashStrategy` interface, for which there are currently two implementations:

1. `Gambio\Core\Auth\HashStrategies\Md5HashStrategy` creates and validates password hashes using MD5
2. `Gambio\Core\Auth\HashStrategies\PhpNativeHashStrategy` creates and validates password hashes using the
   PHP native functions `password_hash` and `password_verify`. This strategy is used primarly.


## `JsonWebTokenAuthenticator` service

The `JsonWebTokenAuthenticator` provides a simple `authenticate` method, which expects a JSON web token. The method
returns a `Gambio\Core\Auth\UserId` object, which provides a `userId` method, that returns the ID of the
authenticated user.

If the user can't be authenticated, a `Gambio\Core\Auth\Exceptions\AuthenticationException` exception will be thrown.

The following example shows how you could use this service:

```php
namespace GXModules\<Vendor>\<Module>;

use Gambio\Core\Auth\JsonWebTokenAuthenticator;
use Gambio\Core\Auth\Exceptions\AuthenticationException;

/**
 * Class SampleClass
 * @package GXModules\<Vendor>\<Module>
 */
class SampleClass
{
    /**
     * @var JsonWebTokenAuthenticator
     */
    private $authenticator;
    
    
    /**
     * SampleClass constructor.
     *
     * @param JsonWebTokenAuthenticator $authenticator
     */
    public function __construct(JsonWebTokenAuthenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }
    
    
    /**
     * @param string $token
     *
     * @return int
     */
    public function checkUserCredentials(string $token): int
    {
        try {
            $userId = $this->authenticator->authenticate($token);
            
            return $userId->userId();
        } catch (AuthenticationException $exception) {
            return false;
        }
    }
}
```

!!! Notice "Notice"
    This example expects you to use the [Service Provider] to register your classes to the [Application Core].
    If your are using the legacy architecture, you need to fetch this service using the [Legacy DI Container].



[Application Core]: ./../application-core.md
[Service Provider]: ./../details/service-provider.md
[Legacy DI Container]: ./../details/di-container.md#legacy-di-container
