<?php
/* --------------------------------------------------------------
   remove_order.php 2016-02-16
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
 * @var OrderWriteService $orderWriteService
 */
$orderWriteService = StaticGXCoreLoader::getService('OrderWrite');

$orderId     = (array_key_exists('id', $_GET)) ? $_GET['id'] : 400211;
$orderIdType = new IdType($orderId);

try
{
	$orderWriteService->removeOrderById($orderIdType);
	echo 'Deleted order!';
}
catch(UnexpectedValueException $e)
{
	echo 'Could not find order with ID ' . $orderId;
}
