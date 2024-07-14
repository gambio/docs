<?php
/* --------------------------------------------------------------
   display_order_data.php 2016-02-16
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

/**
 * Display Order Data 
 * 
 * @param int $orderId
 * @param GXEngineOrder|null $order
 *
 * @return string
 */
function displayOrderData($orderId, GXEngineOrder $order = null)
{
	ob_start();
	?>
	<html>
		<head>
			<title>Orders Data</title>
			<link rel="stylesheet"
			      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
			      integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
			      crossorigin="anonymous">
		</head>
		<body class="container">
			<div class="row">
				<?php if($order): ?>
					<table class="table">
						<thead>
							<tr>
								<th>Nr</th>
								<th>Customer Id</th>
								<th>Price</th>
								<th>Payment Type</th>
								<th>Orders Date</th>
								<th>Status Id</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php echo $order->getOrderId() ?></td>
								<td><?php echo $order->getCustomerId() ?></td>
								<td>
									<?php foreach($order->getOrderTotals() as $orderTotal): ?>
										<?php echo $orderTotal->getTitle() ?>
										<br />
									<?php endforeach; ?>
								</td>
								<td><?php echo $order->getPaymentType()->getTitle() ?></td>
								<td><?php echo $order->getPurchaseDateTime()->format('d.m.Y') ?></td>
								<td><?php echo $order->getStatusId() ?></td>
							</tr>
						</tbody>
					</table>
					<pre>
				<?php print_r($order); ?>
			</pre>
				<?php else: ?>
					<div class="text-center">
						Order with ID <?php echo $orderId ?> does not exist.
					</div>
				<?php endif; ?>
			</div>
		</body>
	</html>
	<?php

	return ob_get_clean();
}
