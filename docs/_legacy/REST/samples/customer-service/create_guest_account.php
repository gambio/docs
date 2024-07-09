<?php
/* --------------------------------------------------------------
   create_account.php 2016-02-16
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
 * Gets a proper formatted json string from a sample file.
 *
 * Feel free to modify the json sample to your own needs.
 */
$requestJson = file_get_contents('./json-samples/PostGuestRequest.json');

// Change location to omit errors when including the application top file.
chdir('../../../../src');
require_once 'includes/application_top_main.php';

/**
 * Replace the constructor arguments with your admin login credentials.
 * 
 * Otherwise, the authorization fail and you are not able to create a new customer.
 */
$consumer = new RestSampleConsumer('admin@example.org', '12345');

/**
 * Replace the email address of the json sample to omit errors that customers have the same email address.
 */
$requestJson = str_replace('"email": "guest2@example.org"',
                           '"email": "rest-api-example-guest-' . mt_rand(100, 999) . '@example.de"', $requestJson);

/**
 * $result represent the response and contains information about the status of the request and may contain additional
 * information on success.
 *
 * The consumer sends a POST request to the url http[s]://your-shop.eg/api.php/v2/customers. The content type of the
 * request is set to 'application/json' and the data is a json string.
 *
 * (Gets by the sample file: docs/REST/samples/customer-service/PostRegistreeRequest.json)
 *
 * @var RestSampleResponse $result
 */
$result      = $consumer->post(HTTP_SERVER . DIR_WS_CATALOG . 'api.php/v2/customers',
                               array('Content-Type: application/json'), $requestJson);
$resultArray = $result->getBodyAsArray();

echo displayCustomerData($resultArray);
