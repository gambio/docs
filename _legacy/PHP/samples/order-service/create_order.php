<?php
/* --------------------------------------------------------------
   create_order.php 2016-02-15
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
 * Creates the customer service
 *
 * @var CustomerReadService $customerReadService
 */
$customerReadService = StaticGXCoreLoader::getService('CustomerRead');
$adminAccountId      = new IdType(1);
$adminCustomer       = $customerReadService->getCustomerById($adminAccountId);

/**
 * Order object service to create order item objects.
 *
 * @var OrderObjectService $orderObjectService
 */
$orderObjectService = StaticGXCoreLoader::getService('OrderObject');
$orderTotalObjects  = array(
	$orderObjectService->createOrderTotalObject(new StringType('<b>Zwischensumme:</b>'),
	                                            new DecimalType(0),
	                                            new StringType('0'),
	                                            new StringType('ot_subtotal'))
);

/**
 * Creates objects that are required for the ::createNewCustomerOrder Param signature.
 */
$orderTotals        = MainFactory::create('OrderTotalCollection', $orderTotalObjects);
$customerStatusInfo = MainFactory::create('CustomerStatusInformation',
                                          new IdType(1),
                                          new StringType('Customer status name'),
                                          new StringType('Customer status image'),
                                          new DecimalType(0.0),
                                          new BoolType(mt_rand(1, 2) === 1));

/**
 * Creates the order write service and make an order.
 *
 * @var OrderWriteService $orderWriteService
 */
$orderWriteService = StaticGXCoreLoader::getService('OrderWrite');
$orderWriteService->createNewCustomerOrder($adminAccountId,
                                           $customerStatusInfo,
                                           new StringType('customer number'),
                                           new EmailStringType('order-email-' . mt_rand(1000, 9999) . '@example.org'),
                                           new StringType('0123 456789'),
                                           new StringType('vat number id'),
                                           $adminCustomer->getDefaultAddress(), #requried AddressBlockInterfaces
                                           $adminCustomer->getDefaultAddress(), #requried AddressBlockInterfaces
                                           $adminCustomer->getDefaultAddress(), #requried AddressBlockInterfaces
                                           MainFactory::create('OrderItemCollection',
                                                               MainFactory::create('OrderItem',
                                                                                   new StringType('order item name'))),
                                           $orderTotals,
                                           MainFactory::create('OrderShippingType',
                                                               new StringType('Pauschale Versandkosten'),
                                                               new StringType('flat_flat')),
                                           MainFactory::create('OrderPaymentType',
                                                               new StringType('cod'),
                                                               new StringType('cod')),
                                           MainFactory::create('CurrencyCode',
                                                               new NonEmptyStringType(DEFAULT_CURRENCY)),
                                           new LanguageCode(new NonEmptyStringType('DE')),
                                           new DecimalType(0.5));

echo 'Added order!';
