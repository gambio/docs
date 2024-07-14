# All available business-related components 

Using the [DI Container] it's possible to request and use several services and components. The following
list shows all available business ones and their interfaces that can be requested through the [DI Container]
or [Legacy DI Container].

!!! note "Notice"
    Please have in mind that you can find the public API (public methods etc.) of a service following the namespace
    of this service and opening the corresponding PHP file.

__Available components:__

- `Gambio\Admin\ParcelService\ParcelServiceService`:  
  Service class to manage (read, update, delete) the parcel service of the shop.

- `Gambio\Admin\TrackingCode\TrackingCodeService`:  
  Service class to manage (read, update, delete) the tracking codes of the shop.

- `Gambio\Admin\UserConfiguration\CurrentUserConfigurationService`:  
  Simple service to get and set user-based (admin-based) configurations.

- `Gambio\Admin\Withdrawal\WithdrawalService`:  
  Service class to manage (read, update, delete) the withdrawals of the shop.

- `Gambio\Core\AdminAccess\AdminService`:  
  Service class to fetch available admins.

- `Gambio\Core\AdminAccess\GroupService`:  
  Service class to manage (read, update, delete) the admin access groups.

- `Gambio\Core\AdminAccess\PermissionService`:  
  Service class to check and update permissions.

- `Gambio\Core\AdminAccess\RoleService`:  
  Service class to manage (read, update, delete) the admin access roles.



[DI Container]: ./../details/di-container.md
[Legacy DI Container]: ./../details/di-container.md#legacy-di-container
