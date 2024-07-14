<?php
/* --------------------------------------------------------------
   fetch_order.php 2016-02-15
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

// Function to display the data from a order entity.
require_once 'display_order_data.php';

// Change location to omit errors when including the application top file.
chdir('../../../../src');
require_once 'includes/application_top_main.php';

/**
 * @var OrderReadService $orderReadService
 */
$orderReadService = StaticGXCoreLoader::getService('OrderRead');

$orderId     = (array_key_exists('id', $_GET)) ? $_GET['id'] : 400210; // 400210 is the first created order id
$orderIdType = new IdType($orderId);

try
{
	/**
	 * Fetch the order entity.
	 */
	$order = $orderReadService->getOrderById($orderIdType);
}
catch(UnexpectedValueException $e)
{
	$order = null;
}

echo displayOrderData($orderId, $order);
