<?php
/* --------------------------------------------------------------
   remove_account.php 2016-02-15
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

// Change location to omit errors when including the application top file.
chdir('../../../../src');
require_once 'includes/application_top_main.php';

/**
 * Customer write service to update the customer data (delete in this case).
 *
 * @var CustomerReadService  $customerReadService
 * @var CustomerWriteService $customerWriteService
 */
$customerWriteService = StaticGXCoreLoader::getService('CustomerWrite');

/**
 * To remove another customer, just use the $_GET['id'] Parameter.
 */
$customerId     = (array_key_exists('id', $_GET)) ? $_GET['id'] : 10;
$customerIdType = new IdType($customerId);

/**
 * Removes the customer account with the id 10.
 * 
 * Feel free to modify this sample.
 */
$customerWriteService->deleteCustomerById($customerIdType);

echo 'Deleted customer account with ID ' . $customerId;
