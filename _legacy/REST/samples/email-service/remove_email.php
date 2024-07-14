<?php
/* --------------------------------------------------------------
   remove_email.php 2016-02-16
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

/**
 * This script will delete an email.
 * 
 * You can provide an ID as GET-Parameter to fetch an email with that ID.
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
require_once 'display_email_data.php';

// Including the application_top file.
chdir('../../../../src');
require_once 'includes/application_top_main.php';

/**
 * E-Mail ID.
 * 
 * If no ID has been provided as GET parameter ID number 1 will be used.
 *
 * @var int $id
 */
$id = (array_key_exists('id', $_GET)) ? $_GET['id'] : 10;

/**
 * Replace the constructor arguments with your admin login credentials.
 * 
 * Otherwise, the authorization fail and you are not able to create a new customer.
 */
$consumer = new RestSampleConsumer('admin@example.org', '12345');

/**
 * $resultArray represent the response array and contains information about the status of the request and may contain
 * additional information on success.
 * 
 * The consumer sends a DELETE request to the url http[s]://your-shop.eg/api.php/v2/emails/[id].
 */
$resultArray = $consumer->delete(HTTP_SERVER . DIR_WS_CATALOG . 'api.php/v2/emails/' . $id)->getBodyAsArray();

?>

<html>
	<head>
		<title>REST Email Delete Sample</title>
		<link rel="stylesheet"
		      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
		      integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
		      crossorigin="anonymous">
	</head>
	<body class="container-fluid">
		<?php if(array_key_exists('status', $resultArray) && $resultArray['status'] === 'error'): ?>
			<div class="alert alert-danger text-center">
				<?php echo $resultArray['message'] ?>
			</div>
		<?php else: ?>
			<div class="alert alert-success text-center">
				Deleted email with ID <?php echo $id; ?>.
			</div>
			<pre>Response: <?php print_r($resultArray); ?></pre>
		<?php endif; ?>
	</body>
</html>

