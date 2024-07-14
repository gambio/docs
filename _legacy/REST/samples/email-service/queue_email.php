<?php
/* --------------------------------------------------------------
   queue_email.php 2016-02-16
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

/**
 * This script will queue a new email with an attachment, so it can be sent later.
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

/**
 * Gets a proper formatted json string from a sample file.
 * 
 * Feel free to modify the json sample to your own needs.
 */
$requestJson = file_get_contents('./json-samples/EmailRequest.json');

// Including the application_top file.
chdir('../../../../src');
require_once 'includes/application_top_main.php';

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
 * The consumer sends a PUT request to the url http[s]://your-shop.eg/api.php/v2/emails.
 */
$resultArray = $consumer->put(HTTP_SERVER . DIR_WS_CATALOG . 'api.php/v2/emails',
                               array('Content-Type: application/json'),
                               $requestJson)->getBodyAsArray();

// Output
echo displayEmailData($resultArray);