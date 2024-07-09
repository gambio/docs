<?php
/* --------------------------------------------------------------
   update_admin_address.php 2016-02-15
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

$newStreet   = 'Same-Script-Str. 1';
$newPostCode = '12345';
$newCity     = 'Test';

/**
 * Admin account id is equal to 1.
 *
 * To update the data of another customer, just use the $_GET['id'] Parameter.
 */
$adminAccountId = (array_key_exists('id', $_GET)) ? new IdType($_GET['id']) : new IdType(1);

/**
 * Fetches customer data and returns them as customer entity.
 */
$customer = $customerReadService->getCustomerById($adminAccountId);

$address = $customer->getDefaultAddress();
$address->setStreet(MainFactory::create('CustomerStreet', $newStreet));
$address->setPostcode(MainFactory::create('CustomerPostcode', $newPostCode));
$address->setCity(MainFactory::create('CustomerCity', $newCity));

$customer->setDefaultAddress($address);

/**
 * The update process is done now.
 *
 * Feel free to modify this sample script.
 */
$customerWriteService->updateCustomer($customer);

echo displayCustomerData($customer);
