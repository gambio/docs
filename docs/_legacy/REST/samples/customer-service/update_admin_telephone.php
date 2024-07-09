<?php
/* --------------------------------------------------------------
   update_admin_telephone.php 2016-02-16
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
require_once 'display_customer_data.php';

/**
 * Feel free to modify the json sample to your own needs.
 */
$requestData = array(
	'telephone' => '(123) - 789321456'
);

// change location to omit errors when including the application top file.
chdir('../../../../src');
require_once 'includes/application_top_main.php';

/**
 * Replace the constructor arguments with your admin login credentials.
 * Otherwise, the authorization fail and you are not able to create a new customer.
 */
$consumer = new RestSampleConsumer('admin@example.org', '12345');

/**
 * $result represent the response and contains information about the status of the request and may contain additional
 * information on success.
 * 
 * The consumer sends a PUT request to the url http[s]://your-shop.eg/api.php/v2/customers/[customerId]. The content
 * type of the request is set to 'application/json' and the data is a json string.
 */
$resultArray = $consumer->put(HTTP_SERVER . DIR_WS_CATALOG . 'api.php/v2/customers/1',
                              array('Content-Type: application/json'),
                              json_encode($requestData))->getBodyAsArray();

echo displayCustomerData($resultArray, false, 1);
