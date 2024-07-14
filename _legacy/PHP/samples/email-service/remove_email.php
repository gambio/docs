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
 * If no ID has been provided as GET parameter ID number 13 will be used.
 *
 * @var int    $id
 * @var IdType $idType
 */
$id     = (array_key_exists('id', $_GET)) ? $_GET['id'] : 10;
$idType = new IdType($id);

/**
 * Fetch email entity.
 *
 * @var Email|null $email
 */
$email = $service->findById($idType);

if(null === $email)
{
	echo '<h1>Could not find email with ID ' . $id . '!</h1>';
}
else
{
	// Delete email.
	$service->delete($email);
	echo '<h1>Deleted email with ID ' . $id . '!</h1>';
}