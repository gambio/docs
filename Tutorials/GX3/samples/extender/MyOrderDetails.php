<?php
/* --------------------------------------------------------------
   MyOrderDetails.inc.php 2017-04-11
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2017 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

/**
 * Class MyOrderDetails
 *
 * This is a sample overload for the CheckoutSuccessExtenderComponent.
 *
 * @see CheckoutSuccessExtenderComponent
 */
class MyOrderDetails extends MyOrderDetails_parent
{
	/**
	 * Overloaded "proceed" method.
	 */
	public function proceed()
	{
		parent::proceed();
		
		$orderId                   = new IdType($this->v_data_array['orders_id']);
		$this->html_output_array[] = $this->createOrderDetails($orderId);
	}
	
	/**
	 * Helpermethod for creating the HTML-Code for order details.
	 */
	private function createOrderDetails(IdType $orderId)
	{
		$orderReadService = StaticGXCoreLoader::getService('OrderRead');
		$order            = $orderReadService->getOrderById($orderId);
		
		$customerAdressBlock  = $order->getCustomerAddress();
		$billingAddressBlock  = $order->getBillingAddress();
		$deliveryAddressBlock = $order->getDeliveryAddress();
			
		$html = '<h2>Bestelldetails (#' . $order->getOrderId() . ')</h2>'
		        . '<div class="row">'
			        . '<div class="col-sm-4"><b>Kundenadresse:</b><br /> '
				        . $customerAdressBlock->getFirstname() . ' '
				        . $customerAdressBlock->getLastname() . '<br />'
				        . $customerAdressBlock->getStreet() . ' '
				        . $customerAdressBlock->getHouseNumber() . '<br />'
				        . $customerAdressBlock->getPostcode() . ' '
				        . $customerAdressBlock->getCity() . '<br />'
			        . '</div>'
			        . '<div class="col-sm-4"><b>Rechnungsadresse:</b><br /> '
				        . $billingAddressBlock->getFirstname() . ' '
				        . $billingAddressBlock->getLastname() . '<br />'
				        . $billingAddressBlock->getStreet() . ' '
				        . $billingAddressBlock->getHouseNumber() . '<br />'
				        . $billingAddressBlock->getPostcode() . ' '
				        . $billingAddressBlock->getCity() . '<br />'
			        . '</div>'
			        . '<div class="col-sm-4"><b>Lieferadresse:</b><br /> '
				        . $deliveryAddressBlock->getFirstname() . ' '
				        . $deliveryAddressBlock->getLastname() . '<br />'
				        . $deliveryAddressBlock->getStreet() . ' '
				        . $deliveryAddressBlock->getHouseNumber() . '<br />'
				        . $deliveryAddressBlock->getPostcode() . ' '
				        . $deliveryAddressBlock->getCity() . '<br />'
		            . '</div>'
		        . '</div>';
		
		return $html;
	}
}