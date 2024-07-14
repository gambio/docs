<?php
/* --------------------------------------------------------------
   display_customer_data.php 2016-02-15
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

/**
 * Display Customer Data
 *
 * @param Customer $customer
 *
 * @return string
 */
function displayCustomerData(Customer $customer)
{
	ob_start();
	?>
	<html>
		<head>
			<title>Customer Data</title>
			<link rel="stylesheet"
			      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
			      integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
			      crossorigin="anonymous">
		</head>
		<body class="container">
			<div class="row">
				<table class="table">
					<thead>
						<tr>
							<th>ID</th>
							<th>Gender</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Email</th>
							<th>Date of Birth</th>
							<th>Vat Number</th>
							<th>Vat Number Status</th>
							<th>Telephone Number</th>
							<th>Fax Number</th>
							<th>Company</th>
							<th>Pass Hash</th>
							<th>Address</th>
							<th>Customer Status Id</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo $customer->getId(); ?></td>
							<td><?php echo $customer->getGender(); ?></td>
							<td><?php echo $customer->getFirstname(); ?></td>
							<td><?php echo $customer->getLastname(); ?></td>
							<td><?php echo $customer->getEmail(); ?></td>
							<td><?php echo $customer->getDateOfBirth()->format('d.m.Y'); ?></td>
							<td><?php echo $customer->getVatNumber(); ?></td>
							<td><?php echo $customer->getVatNumberStatus(); ?></td>
							<td><?php echo $customer->getTelephoneNumber(); ?></td>
							<td><?php echo $customer->getFaxNumber(); ?></td>
							<td><?php echo $customer->getDefaultAddress()->getCompany(); ?></td>
							<td><?php echo $customer->getPassword(); ?></td>
							<td>
								<?php echo $customer->getDefaultAddress()->getStreet() . '<br/>'
								           . $customer->getDefaultAddress()->getPostcode() . ' '
								           . $customer->getDefaultAddress()->getCity() . '<br/>'
								           . $customer->getDefaultAddress()->getCountry()->getName(); ?>
							</td>
							<td><?php echo $customer->getStatusId(); ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		<pre>
			<?php print_r($customer); ?>
		</pre>
		</body>
	</html>
	<?php
	return ob_get_clean();
}
