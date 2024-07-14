<?php
/* --------------------------------------------------------------
   remove_account.php 2016-02-16
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

// Change location to omit errors when including the application top file.
chdir('../../../../src');
require_once 'includes/application_top_main.php';

/**
 * Id of customers data to fetch.
 * 
 * Default is 1, the id of the admin account.
 */
$customerId = (array_key_exists('id', $_GET)) ? (int)$_GET['id'] : 2;

if($customerId === 1)
{
	die('Customer ID 1 is not allowed for this sample .. if you want to remove the admin account, set the customer '
	    . 'id to 1 with the get parameter "id" and uncomment the lines 30-32 of this sample file.');	
}

/**
 * Replace the constructor arguments with your admin login credentials.
 * 
 * Otherwise, the authorization fail and you are not able to create a new customer.
 */
$consumer = new RestSampleConsumer('admin@example.org', '12345');

/**
 * $result represent the response and contains information about the status of the request and may contain additional
 * information on success.
 * 
 * The consumer sends a DELETE request to the url http[s]://your-shop.eg/api.php/v2/customers/[id].
 * 
 * Feel free to modify the last segment of the request url to remove other customers instead of that one with
 * the customer id 2.
 * 
 * Optional, you can use the GET Parameter 'id' to modify the used customer id.
 */
$resultArray =
	$consumer->delete(HTTP_SERVER . DIR_WS_CATALOG . 'api.php/v2/customers/' . $customerId)->getBodyAsArray();
?>

<html>
	<head>
		<title>REST Customer Delete Sample</title>
		<link rel="stylesheet"
		      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
		      integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
		      crossorigin="anonymous">
	</head>
	<body class="container-fluid">
		<div class="alert alert-info text-center">
			Bitte stellen Sie sicher, dass ein Benutzerkonto mit dem Nutzer <b>admin@example.org</b> und dem Passwort <b>12345</b> existiert und in der Config-Datei eingetragen ist.
		</div>

		<div class="alert alert-success text-center">
			Removed customer with ID: <?php echo $customerId ?>
		</div>
		<pre>Response: <?php print_r($resultArray); ?></pre>
	</body>
</html>
