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

function displayOrderData(array $resultArray)
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
		<body>
			<?php if(array_key_exists('status', $resultArray) && $resultArray['status'] === 'error'): ?>
				<div class="alert alert-danger text-center">
					<?php echo $resultArray['message'] ?>
				</div>
			<?php else: ?>
				<div>
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
								<td><?php echo $resultArray['id'] ?></td>
								<td><?php echo $resultArray['customer']['id'] ?></td>
								<td>
									<?php foreach($resultArray['totals'] as $orderTotal): ?>
										<?php echo $orderTotal['title'] ?>
										<br />
										<?php echo $orderTotal['valueText'] ?>
										<br />
									<?php endforeach; ?>
								</td>
								<td><?php echo $resultArray['paymentType']['title'] ?></td>
								<td><?php echo $resultArray['purchaseDate'] ?></td>
								<td><?php echo $resultArray['statusId'] ?></td>
							</tr>
						</tbody>
					</table>
				</div>
				<pre>
				<?php print_r($resultArray) ?>
			</pre>
			<?php endif; ?>
		</body>
	</html>
	<?php

	return ob_get_clean();
}
