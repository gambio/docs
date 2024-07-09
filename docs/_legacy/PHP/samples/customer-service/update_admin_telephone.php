<?php
/* --------------------------------------------------------------
   update_admin_telephone.php 2016-02-15
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

// Function to display the data from a customer entity.
require_once 'display_customer_data.php';

// Change location to omit errors when including the application top file.
chdir('../../../../src');
require_once 'includes/application_top_main.php';

/**
 * Customer read and write service to fetch and update the customer data.
 *
 * @var CustomerReadService  $customerReadService
 * @var CustomerWriteService $customerWriteService
 */
$customerReadService  = StaticGXCoreLoader::getService('CustomerRead');
$customerWriteService = StaticGXCoreLoader::getService('CustomerWrite');

/**
 * Admin account id is equal to 1.
 */
$adminAccountId = new IdType(1);

/**
 * Fetches customer data and returns them as customer entity.
 */
$customer = $customerReadService->getCustomerById($adminAccountId);

/**
 * Sets the new telephone number and pass the entity in the ::updateCustomer method.
 *
 * The update process is done now.
 *
 * Feel free to modify this sample script.
 */
$customer->setTelephoneNumber(new CustomerCallNumber('(012) 333 444'));
$customerWriteService->updateCustomer($customer);

echo displayCustomerData($customer);
