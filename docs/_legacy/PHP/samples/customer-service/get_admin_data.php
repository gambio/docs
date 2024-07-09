<?php
/* --------------------------------------------------------------
   get_admin_data.php 2016-02-15
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

// function to display the data from a customer entity.
require_once 'display_customer_data.php';

// change location to omit errors when including the application top file.
chdir('../../../../src');
require_once 'includes/application_top_main.php';

/**
 * Customer read service to fetch the customer data.
 *
 * @var CustomerReadService $customerReadService
 */
$customerReadService = StaticGXCoreLoader::getService('CustomerRead');

/**
 * Admin account id is equal to 1.
 *
 * To fetch the data of another customer, just use the $_GET['id'] Parameter.
 */
$adminAccountId = (array_key_exists('id', $_GET)) ? new IdType($_GET['id']) : new IdType(1);

/**
 * Fetches customer data and returns them as customer entity.
 */
$customer = $customerReadService->getCustomerById($adminAccountId);

echo displayCustomerData($customer);
