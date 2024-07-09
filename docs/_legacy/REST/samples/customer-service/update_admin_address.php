<?php
/* --------------------------------------------------------------
   update_admin_address.php 2016-02-16
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

/**
 * Required helper classes to handle curl request.
 * 
 * They give an object oriented layer to work with REST-API methods and helps you to handle tasks like authorization.
 * 
 * Feel free to modify or adjust these classes to your needs.
 */
require_once '../RestSampleConsumer.php';
require_once '../RestSampleResponse.php';

/**
 * Feel free to modify the json sample to your own needs.
 */
$requestData = array(
	'company' => 'Test Company - UPDATED', 
	'firstname' => 'John - UPDATED', 
	'lastname' => 'Doe - UPDATED', 
	'street' => 'Test Street - UPDATED', 
	'suburb' => 'Test Suburb - UPDATED', 
	'city' => 'Test City - UPDATED'
);

// change location to omit errors when including the application top file.
chdir('../../../../src');
require_once 'includes/application_top_main.php';

/**
 * Replace the constructor arguments with your admin login credentials.
 * 
 * Otherwise, the authorization fail and you are not able to create a new customer.
 */
$consumer = new RestSampleConsumer('admin@example.org', '12345');

/**
 * Determine the address id of the admin account via the rest - api.
 */
$customerResultArray = $consumer->get(HTTP_SERVER . DIR_WS_CATALOG . 'api.php/v2/customers/1')->getBodyAsArray();
$adminAddressId      = $customerResultArray['addressId'];

/**
 * $result represent the response and contains information about the status of the request and may contain additional
 * information on success.
 * 
 * The consumer sends a PUT request to the url http[s]://your-shop.eg/api.php/v2/addresses/[addressId]. The content
 * type of the request is set to 'application/json' and the data is a json string.
 */
$addressResultArray = $consumer->put(HTTP_SERVER . DIR_WS_CATALOG . 'api.php/v2/addresses/' . $adminAddressId,
                                     array('Content-Type: application/json'),
                                     json_encode($requestData))->getBodyAsArray();
?>

<html>
	<head>
		<title>REST Customer Sample</title>
		<link rel="stylesheet"
		      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
		      integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
		      crossorigin="anonymous">
	</head>
	<body class="container-fluid">
		<div>
      <div class="alert alert-info text-center">
				Bitte stellen Sie sicher, dass ein Benutzerkonto mit dem Nutzer <b>admin@example.org</b> und dem Passwort <b>12345</b> existiert und in der Config-Datei eingetragen ist.
			</div>

			<div class="alert alert-success text-center">
				Admin customer address was changed.
			</div>
			<table class="table">
				<thead>
					<tr>
						<th>Customer ID</th>
						<th>Gender</th>
						<th>Company</th>
						<th>First name</th>
						<th>Last name</th>
						<th>Street</th>
						<th>Suburb</th>
						<th>Postcode</th>
						<th>City</th>
						<th>Country ID</th>
						<th>Zone ID</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo $addressResultArray['customerId']; ?></td>
						<td><?php echo $addressResultArray['gender']; ?></td>
						<td><?php echo $addressResultArray['company']; ?></td>
						<td><?php echo $addressResultArray['firstname']; ?></td>
						<td><?php echo $addressResultArray['lastname']; ?></td>
						<td><?php echo $addressResultArray['street']; ?></td>
						<td><?php echo $addressResultArray['suburb']; ?></td>
						<td><?php echo $addressResultArray['postcode']; ?></td>
						<td><?php echo $addressResultArray['city']; ?></td>
						<td><?php echo $addressResultArray['countryId']; ?></td>
						<td><?php echo $addressResultArray['zoneId']; ?></td>
					</tr>
				</tbody>
			</table>
		</div>
		<pre>Addresses Result: <?php print_r($addressResultArray) ?></pre>
		<pre>Customer Result: <?php print_r($customerResultArray) ?></pre>
	</body>
</html>
