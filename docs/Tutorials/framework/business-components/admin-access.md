# Admin Access

The **Admin Access** manages admin actions in certain areas of the shop. It controls what an admin can do, see or
interact with in the shop system. The shop owner (or any admin with specific permissions) can manage other admins
permissions by assigning roles to an admin. An admin can have multiple roles, and each role can have various
permissions granted.

The Admin Access can be divided into three domains (admins, groups and roles). Each of these domains has its
application service and factory to interact with that specific domain. Besides the three application services,
there is also a fourth application service for permissions. This service depends on the other services and can be
used as a simpler abstraction to interact with the permissions of an admin. Because of its context we handle
this service as part of the role domain.

The following sections describe each of these domains, their model, use cases and business rules.


## Admin domain

The admin domain provides some admin management functionality like serving all or a specific admin and assigning
or removing roles. 

Furthermore, this domain doesn't allow creating or deleting an admin, nor can it change specific attributes like
the name of an admin, because this would also affect parts of legacy code that handle the creation of customers
or users. In a future refactoring this could also become a functionality of this domain. 


### Aggregate root and domain model

The aggregate root `Gambio\Admin\Modules\Admin\Model\Admin` encapsulates a customer with admin permissions
(having a specific customer group). Among other information the aggregate root contains the currently
assigned roles of the admin. Using the services you can assign or remove roles from the aggregate root.


### Use cases


#### Fetching all or a specific admin

```
/** $readService \Gambio\Admin\Modules\Admin\Services\AdminReadService **/

$allAdmins     = $readService->getAdmins();
$specificAdmin = $readService->getAdminById(1);
```


#### Assigning one or multiple roles to an admin

```
/** $readService \Gambio\Admin\Modules\Admin\Services\AdminReadService **/
/** $writeService \Gambio\Admin\Modules\Admin\Services\AdminWriteService **/
/** $factory \Gambio\Admin\Modules\Admin\Services\AdminFactory **/

$admin1  = $readService->getAdminById(1);
$admin2  = $readService->getAdminById(1);

$roleId1 = $factory->createRoleId(1);
$roleId2 = $factory->createRoleId(2);

$admin1->assignRole($roleId1);
$admin2->assignRole($roleId1);
$admin2->assignRole($roleId2);

$writeService->storeAdmins($admin1, $admin2);
```


#### Removing one or multiple roles from an admin

```
/** $readService \Gambio\Admin\Modules\Admin\Services\AdminReadService **/
/** $writeService \Gambio\Admin\Modules\Admin\Services\AdminWriteService **/
/** $factory \Gambio\Admin\Modules\Admin\Services\AdminFactory **/

$admin1  = $readService->getAdminById(1);
$admin2  = $readService->getAdminById(1);

$roleId1 = $factory->createRoleId(1);
$roleId2 = $factory->createRoleId(2);

$admin1->removeRole($roleId1);
$admin2->removeRole($roleId1);
$admin2->removeRole($roleId2);

$writeService->storeAdmins($admin1, $admin2);
```


### Business rules

There are no specific business rules.


### Domain events

| Event | Description |
| ----- | ----------- |
| `Gambio\Admin\Modules\Admin\Model\Events\RoleToAdminAssigned`  | Will be raised if a role has been assigned to an admin.  |
| `Gambio\Admin\Modules\Admin\Model\Events\RoleFromAdminRemoved` | Will be raised if a role has been removed from an admin. |


## Access Group domain

The group domain is a representation of a simple data management (or CRUD) system. The focus on this domain
lies in managing groups and their group items. A group always represents a collection of group items which have
a specific context in common.


### Aggregate root and domain model

The aggregate root `Gambio\Admin\Modules\AccessGroup\Model\AccessGroup` contains a collection of items. Each of the
items represents an available page, a controller, an ajax handler or an HTTP route of the Gambio Admin. A group thus
represents a specific area or module in the Gambio Admin (e.g. product management, categories, etc.).

By default, the groups inside the shop are provided by Gambio. These groups are naturally protected and their
names and descriptions cannot be changed. However, a third-party developer may introduce new sections into
the Gambio Admin that they wish to encapsulate under a group. Such groups are not protected and their names
and descriptions can be freely changed. Shop owners can use these groups to manage the permissions of admins.

Group items are characterized by a type and a descriptor. The item type can represent a single page, controller,
AJAX handler or HTTP route of the Gambio Admin. The system uses the descriptor to determine which page,
controller, etc. it's representing.


### Use cases


#### Fetching all or a specific group

```
use Gambio\Admin\Modules\AccessGroup\Model\ValueObjects\GroupItem;

/** $service \Gambio\Admin\Modules\AccessGroup\Services\GroupReadService **/

$allGroups                 = $service->getAccessGroups();
$specificGroup             = $service->getAccessGroupById(1);
$groupWithSpecificRoute    = $service->getAccessGroupByTypeAndDescriptor(GroupItem::ROUTE_TYPE, 'a-route');
$groupForUnknownRouteItems = $service->getAccessGroupForUnknownItemsByType(GroupItem::ROUTE_TYPE);
```


#### Find best-matching group

Sometimes you don't know if there is a specific group for the given type and descriptor. Therefore, the
`findGroupByTypeAndDescriptor` method always provides the best-matching group. This could be the group for unknown
items or a group containing a more generic descriptor as group item (e.g. `<controller>` instead of
`<controller>/<methoder>` or `/some/http/route` instead of `/some/http/route/that/is/to/specific`).

```
use Gambio\Admin\Modules\AccessGroup\Model\ValueObjects\GroupItem;

/** $service \Gambio\Admin\Modules\AccessGroup\Services\GroupReadService **/

$group = $service->findAccessGroupByTypeAndDescriptor(GroupItem::ROUTE_TYPE, 'a-route');
```


#### Create a new group 

```
/** $service \Gambio\Admin\Modules\AccessGroup\Services\AccessGroupWriteService **/

$names         = ['en' => 'english name', 'de' => 'german name'];
$descriptions  = ['en' => 'english description', 'de' => 'german description'];
$sortOrder     = 100;

// Creating a new group with some default values.
$newGroup1 = $service->createAccessGroup($names, $descriptions, $sortOrder);

$isProtected   = true;
$parentGroupId = 2;

// This time, we set some optional values like protection state and parent group ID.
$newGroup2 = $service->createAccessGroup($names, $descriptions, $sortOrder, $isProtected, $parentGroupId);
```


#### Delete an existing group 

```
/** $service \Gambio\Admin\Modules\AccessGroup\Services\AccessGroupWriteService **/

$id = 1;

$writeService->deleteAccessGroups($id);
// Method can handle multiple IDs like: $writeService->deleteAccessGroups($id1, $id2, $id3);
```


#### Add items to a group

```
use Gambio\Admin\Modules\AccessGroup\Model\ValueObjects\GroupItem;

/** $readService \Gambio\Admin\Modules\AccessGroup\Services\AccessGroupReadService **/
/** $writeService \Gambio\Admin\Modules\AccessGroup\Services\AccessGroupWriteService **/
/** $factory \Gambio\Admin\Modules\AccessGroup\Services\GroupFactory **/

$groupItem = $factory->createAccessGroupItem(GroupItem::PAGE_TYPE, 'customers.php');

$group = $readService->getAccessGroupById(1);
$group->addItem($groupItem);

$writeService->storeAccessGroups($group);
```


#### Remove items from a group

```
use Gambio\Admin\Modules\AccessGroup\Model\ValueObjects\GroupItem;

/** $readService \Gambio\Admin\Modules\AccessGroup\Services\AccessGroupReadService **/
/** $writeService \Gambio\Admin\Modules\AccessGroup\Services\AccessGroupWriteService **/
/** $factory \Gambio\Admin\Modules\AccessGroup\Services\GroupFactory **/

$groupItem = $factory->createAccessGroupItem(GroupItem::CONTROLLER_TYPE, 'OrdersOverview');

$group = $readService->getAccessGroupById(1);
$group->removeItem($groupItem);

$writeService->storeAccessGroups($group);
```


#### Update name and description of a group

```
/** $readService \Gambio\Admin\Modules\AccessGroup\Services\AccessGroupReadService **/
/** $writeService \Gambio\Admin\Modules\AccessGroup\Services\AccessGroupWriteService **/

$names        = $factory->createGroupNames(['en' => 'new english name', 'de' => 'new german name']);
$descriptions = $factory->createGroupDescriptions(['en' => 'new english description', 'de' => 'new german description']);

$group = $readService->getAccessGroupById(1);
$group->updateNamesAndDescriptions($names, $descriptions);

$writeService->storeAccessGroups($group);
```


#### Update sort order of a group

```
/** $readService \Gambio\Admin\Modules\AccessGroup\Services\AccessGroupReadService **/
/** $writeService \Gambio\Admin\Modules\AccessGroup\Services\AccessGroupWriteService **/

$group = $readService->getAccessGroupById(1);
$group->updateSortOrder(200);

$writeService->storeAccessGroups($group);
```


### Business rules

- Each combination of item type and descriptor can only belong to one group.
- The name and description of a group with an active protected state should not be mutable through the Gambio Admin.


### Domain events

| Event | Description |
| ----- | ----------- |
| `Gambio\Admin\Modules\AccessGroup\Model\Events\ItemToAccessGroupAdded`      | Will be raised if an item has been added to a group. |
| `Gambio\Admin\Modules\AccessGroup\Model\Events\AccessGroupCreated`          | Will be raised if a group has been created. |
| `Gambio\Admin\Modules\AccessGroup\Model\Events\AccessGroupDeleted`          | Will be raised if a group has been deleted. |
| `Gambio\Admin\Modules\AccessGroup\Model\Events\ItemFromAccessGroupRemoved`  | Will be raised if an item has been removed from a group. |
| `Gambio\Admin\Modules\AccessGroup\Model\Events\NamesAndDescriptionsUpdated` | Will be raised if a group name and description has been updated. |
| `Gambio\Admin\Modules\AccessGroup\Model\Events\SortOrderUpdated`            | Will be raised if a group sort order has been updated. |


## Role domain

The role domain is mainly a representation of a simple data management (or CRUD) system. The focus on this domain lies
in managing roles and their granted permissions.


### Aggregate root and domain model

The aggregate root `Gambio\Admin\Modules\AccessRole\Model\AccessRole` contains a collection of permissions which
describe what this role is allowed to do. Permissions are split into reading, writing and deletion. Each permission
is applied to a specific group and its group items.

By default, roles inside the shop are provided by Gambio. These roles are naturally protected and can not be
changed. However, it is possible to introduce new roles that can freely be managed and changed.


### Use cases


#### Fetching all or a specific role

```
/** $service \Gambio\Admin\Modules\AccessRole\Services\AccessRoleReadService **/

$allRoles             = $service->getAccessRoles();
$rolesOfSpecificAdmin = $service->getAccessRolesByAdmin(1);
$specificRole         = $service->getAccessRoleById(1);
```


#### Create a new role 

```
/** $service \Gambio\Admin\Modules\AccessRole\Services\AccessRoleWriteService **/

$names         = ['en' => 'english name', 'de' => 'german name'];
$descriptions  = ['en' => 'english description', 'de' => 'german description'];
$sortOrder     = 100;

// Creating a new role with a default value.
$role1 = $service->createAccessRole($names, $descriptions, $sortOrder);

$isProtected = true;

// This time, we set the optional value protection state.
$role2 = $service->createAccessRole($names, $descriptions, $sortOrder, $isProtected);
```


#### Delete an existing role 

```
/** $service \Gambio\Admin\Modules\AccessRole\Services\AccessRoleWriteService **/

$id = 1;

$writeService->deleteAccessRoles($id);
// Method can handle multiple IDs like: $writeService->deleteAccessRoles($id1, $id2, $id3);
```


#### Check permission of a role

```
use Gambio\Admin\Modules\AccessRole\Model\ValueObjects\PermissionAction;

/** $service \Gambio\Admin\Modules\AccessRole\Services\AccessRoleReadService **/
/** $factory \Gambio\Admin\Modules\AccessRole\Services\RoleFactory **/

$action  = $factory->createPermissionAction(PermissionAction::READ);
$groupId = $factory->createAccessGroupId(1);

$role = $service->getAccessGroupById(1);

$permissionGranted = $role->checkPermission($action, $groupId);
```

> __Note:__ To check the permissions on an admin, you need to iterate over all roles of that admin.


#### Update permission of a role

```
/** $readService \Gambio\Admin\Modules\AccessRole\Services\AccessRoleReadService **/
/** $writeService \Gambio\Admin\Modules\AccessRole\Services\AccessRoleWriteService **/
/** $factory \Gambio\Admin\Modules\AccessRole\Services\RoleFactory **/

$groupId         = 1;
$readingGranted  = true;
$writingGranted  = true;
$deletingGranted = false;

$permission = $factory->createPermission($groupId, $readingGranted, $writingGranted, $deletingGranted);

$role = $readService->getAccessRoleById(1);
$role->updatePermission($permission);

$writeService->storeAccessRoles($role);
```


#### Update name and description of a role

```
/** $readService \Gambio\Admin\Modules\AccessRole\Services\AccessRoleReadService **/
/** $writeService \Gambio\Admin\Modules\AccessRole\Services\AccessRoleWriteService **/
/** $factory \Gambio\Admin\Modules\AccessRole\Services\RoleFactory **/

$names        = $factory->createAccessRoleNames(['en' => 'new english name', 'de' => 'new german name']);
$descriptions = $factory->createAccessRoleDescriptions(['en' => 'new english description', 'de' => 'new german description']);

$role = $readService->getAccessRoleById(1);
$role->updateNamesAndDescriptions($names, $descriptions);

$writeService->storeAccessRoles($role);
```


#### Update sort order of a role

```
/** $readService \Gambio\Admin\Modules\AccessRole\Services\AccessRoleReadService **/
/** $writeService \Gambio\Admin\Modules\AccessRole\Services\AccessRoleWriteService **/

$role = $readService->getAccessRoleById(1);
$role->updateSortOrder(200);

$writeService->storeAccessRoles($role);
```


### Business rules

- If you check a permission that the role does not have (e.g. because it doesn't exist) the check should return false.
- The name and description of a role with an active protected state should not be mutable through the Gambio Admin.


### Domain events

| Event | Description |
| ----- | ----------- |
| `Gambio\Admin\Modules\AccessRole\Model\Events\AccessRoleCreated`           | Will be raised if a role has been created. |
| `Gambio\Admin\Modules\AccessRole\Model\Events\AccessRoleDeleted`           | Will be raised if a role has been deleted. |
| `Gambio\Admin\Modules\AccessRole\Model\Events\NamesAndDescriptionsUpdated` | Will be raised if a role name and description has been updated. |
| `Gambio\Admin\Modules\AccessRole\Model\Events\PermissionUpdated`           | Will be raised if a role permission has been updated. |
| `Gambio\Admin\Modules\AccessRole\Model\Events\SortOrderUpdated`            | Will be raised if a role sort order has been updated. |
