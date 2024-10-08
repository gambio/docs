<?php
/* --------------------------------------------------------------
   create-guest-account.php 2016-02-15
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

// Change location to omit errors when including the application top file.
chdir('../../../../src');
require_once 'includes/application_top_main.php';

/**
 * Instance of country service.
 *
 * Required for creating a customer collections and to instantiate the create account process module.
 *
 * @var CountryService $countryService
 */
$countryService = StaticGXCoreLoader::getService('Country');

/**
 * Input transformer to create a customer collection instance from an array.
 *
 * @var CustomerInputToCollectionTransformer $inputTransformer
 */
$inputTransformer = MainFactory::create('CustomerInputToCollectionTransformer');

/**
 * Array which contains the account information.
 *
 * Feel free to modify this values or add some additional information, e.g: dob.
 */
$personalInputs = array(
	'firstname'      => 'Gast',
	'lastname'       => 'Kunde',
	'email_address'  => 'guest-account-' . mt_rand(1000, 9999) . '@example.org',
	'street_address' => 'Teststreet 123',
	'postcode'       => '12345',
	'city'           => 'Test City',
	'country'        => '81', # country id is used by the service
);

$additionalInputs = array(
	'gender'    => 'm',
	'company'   => 'Test Company',
	'suburb'    => 'Test Suburb',
	'state'     => 'Test State',
	'telephone' => '0123 456789',
	'fax'       => '0321 456789',
	'vat'       => ''
);

$inputArray = array_merge($personalInputs, $additionalInputs);

/**
 * Module to process the customer information.
 *
 * @var CreateAccountProcess $createAccountProcess
 */
$createAccountProcess = MainFactory::create('CreateAccountProcess', StaticGXCoreLoader::getService('CustomerWrite'),
                                            $countryService);

/**
 * Customer collection instance. Type is required for the proceedGuest method.
 */
$customerCollection = $inputTransformer->getGuestCollectionFromInputArray($inputArray, $countryService);

/**
 * Creates the guest account.
 */
$createAccountProcess->proceedGuest($customerCollection);

echo 'Created guest customer account.';
