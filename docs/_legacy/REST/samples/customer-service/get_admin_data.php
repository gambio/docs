<?php
/* --------------------------------------------------------------
   get_admin_data.php 2016-02-16
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

// Change location to omit errors when including the application top file.
chdir('../../../../src');
require_once 'includes/application_top_main.php';

/**
 * Id of customers data to fetch.
 * 
 * Default is 1, the id of the admin account.
 */
$customerId = (array_key_exists('id', $_GET)) ? $_GET['id'] : 1;

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
 * The consumer sends a GET request to the url http[s]://your-shop.eg/api.php/v2/customers/1.
 * 
 * Feel free to modify the last segment of the request url to fetch data from other customers instead of the admin
 * account.
 * 
 * Optional, you can use the GET Parameter 'id' to modify the used customer id.
 */
$resultArray = $consumer->get(HTTP_SERVER . DIR_WS_CATALOG . 'api.php/v2/customers/' . $customerId)->getBodyAsArray();

echo displayCustomerData($resultArray, false, $customerId);
