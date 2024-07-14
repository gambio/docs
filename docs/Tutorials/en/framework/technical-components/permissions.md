# Permissions

We provide the `Gambio\Core\Permission\Services\PermissionService` to quickly check the admin permissions.
This service is based on the [Admin Access] domains and uses their services.

The following gives an example of how to use it:

```php
use Gambio\Admin\Modules\AccessGroup\Model\ValueObjects\AccessGroupItem;
use Gambio\Core\Application\ValueObjects\UserPreferences;
use Gambio\Core\Permission\Services\PermissionService;

/**
 * Class SampleClass
 */
class SampleClass
{
    /**
     * @var PermissionService
     */
    private $permissionService;
    
    /**
     * @var UserPreferences
     */
    private $userPreferences;
    
    
    /**
     * SampleClass constructor.
     *
     * @param PermissionService $permissionService
     * @param UserPreferences $userPreferences
     */
    public function __construct(PermissionService $permissionService, UserPreferences $userPreferences)
    {
        $this->permissionService = $permissionService;
        $this->userPreferences   = $userPreferences;
    }
    
    
    /**
     * @param string   $action
     * @param string   $groupItemType
     * @param string   $groupItemDescriptor
     *
     * @return bool
     */
    public function checkPermissionOfCurrentAdmin(
        string $action,
        string $groupItemType,
        string $groupItemDescriptor
    ): bool
    {
        $currentAdminId = $this->userPreferences->userId();

        return $this->permissionService->checkAdminPermission($currentAdminId,
                                                              $action,
                                                              $groupItemType,
                                                              $groupItemDescriptor);
    }
    
    
    /**
     * @param int    $accessRoleId
     * @param bool   $readPermission
     * @param bool   $writingPermission
     * @param bool   $deletingPermission
     */
    public function setAccessRolePermissionsForMySampleModule(
        int $accessRoleId,
        bool $readPermission,
        bool $writingPermission,
        bool $deletingPermission
    ): void
    {
        $accessGroupItemType       = AccessGroupItem::CONTROLLER_TYPE;
        $accessGroupItemDescriptor = 'SampleController';

        $this->permissionService->setAccessRolePermissionsForAccessGroup($accessRoleId,
                                                                         $accessGroupItemType,
                                                                         $accessGroupItemDescriptor,
                                                                         $readPermission,
                                                                         $writingPermission,
                                                                         $deletingPermission);
    }
}
```

!!! Notice "Notice"
    This example expects you to use the [Service Provider] to register your classes to the [Application Core].
    If your are using the legacy architecture, you need to fetch this service using the [Legacy DI Container].



[Admin Access]: ./../business-components/admin-access.md
[Application Core]: ./../application-core.md
[Service Provider]: ./../details/service-provider.md
[Legacy DI Container]: ./../details/di-container.md#legacy-di-container
