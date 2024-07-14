<?php
/* --------------------------------------------------------------
   update_order.php 2016-02-16
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
 * Creates instances of the order read and write service.
 * 
 * The read service fetch a stored order. To update the db record, modify the order object with the 'set'-accessor
 * methods and pass it through the OrderWriteService::updateOrder.
 *
 * @var OrderReadService  $orderReadService
 * @var OrderWriteService $orderWriteService
 */
$orderReadService  = StaticGXCoreLoader::getService('OrderRead');
$orderWriteService = StaticGXCoreLoader::getService('OrderWrite');

$orderId     = (array_key_exists('id', $_GET)) ? $_GET['id'] : 400210; // 400210 is the first created order id
$orderIdType = new IdType($orderId);

try
{
	/**
	 * Random numbers to aim different records with each sample request.
	 */
	$shippingRandom = mt_rand(100, 999);
	$paymentRandom  = mt_rand(100, 999);

	/**
	 * Fetch the order object with the read service.
	 */
	$order = $orderReadService->getOrderById($orderIdType);

	/**
	 * Modify the order instance with their 'set'-accessor methods.
	 */
	$order->setCustomerId(new IdType(mt_rand(1, 100)));
	$order->setCustomerEmail(new EmailStringType('new-order-example-mail-' . mt_rand(1000, 9999) . '@example.org'));
	$order->setCustomerTelephone(new StringType('0123 ' . mt_rand(100000, 999999)));
	$order->setStatusId(new IdType(mt_rand(1, 100)));
	$order->setCustomerNumber(new StringType('customer number ' . mt_rand(100, 999)));
	$order->setCustomerStatusInformation(MainFactory::create('CustomerStatusInformation', new IdType(mt_rand(1, 100))));
	$order->setShippingType(MainFactory::create('OrderShippingType',
	                                            new StringType('test-' . $shippingRandom . '-shipping-title'),
	                                            new StringType('test-' . $shippingRandom . '-shipping-module')));
	$order->setPaymentType(MainFactory::create('OrderPaymentType',
	                                           new StringType('test-' . $paymentRandom . '-payment-title'),
	                                           new StringType('test-' . $paymentRandom . '-payment-module')));
	$order->setCurrencyCode(MainFactory::create('CurrencyCode', new StringType('EUR')));
	$order->setLanguageCode(MainFactory::create('LanguageCode', new StringType('DE')));
	$order->setPurchaseDateTime(new DateTime());
	$order->setComment(new StringType('order test comment ' . mt_rand(100, 999)));

	//$order->setCustomerAddress();
	//$order->setBillingAddress();
	//$order->setDeliveryAddress();
	//$order->setOrderItems();
	//$order->setOrderTotals();

	/**
	 * Pass the order object as argument through the OrderWriteService::updateOrder method.
	 */
	$orderWriteService->updateOrder($order);

	echo 'Updated order.';
}
catch(UnexpectedValueException $e)
{
	$order        = null;
}

echo displayOrderData($orderId, $order);
