<?php
/* --------------------------------------------------------------
   fetch_email.php 2016-02-16
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

/**
 * This script will fetch and display an email.
 *
 * You can provide an ID as GET-Parameter to fetch an email with that ID.
 */

// Including function to display email in a HTML markup.
require_once 'display_email_data.php';

// Including the application_top file.
chdir('../../../../src');
require_once 'includes/application_top_main.php';

/**
 * Creating instance of the email service.
 *
 * @var EmailService $service
 */
$service = StaticGXCoreLoader::getService('Email');

/**
 * E-Mail ID.
 *
 * If no ID has been provided as GET parameter ID number 1 will be used.
 *
 * @var int    $id
 * @var IdType $idType
 */
$id     = (array_key_exists('id', $_GET)) ? $_GET['id'] : 1;
$idType = new IdType($id);

/**
 * Fetch email entity.
 *
 * @var Email|null $email
 */
try
{
	$email = $service->getById($idType);
}
catch(UnexpectedValueException $error)
{
	$email = null;
}

echo displayEmailData($id, $email);