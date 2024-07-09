<?php
/* --------------------------------------------------------------
   remove_category.php 2016-02-18
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

/**
 * This script will delete a category.
 *
 * You can delete a specific category record by passing in a GET parameter `id`. Without that parameter a
 * category with ID 10 will be deleted.
 */

// Including the application_top file.
chdir('../../../../src');
require_once 'includes/application_top_main.php';

/**
 * Creating a category write service.
 * 
 * @var CategoryWriteService $categoryWriteService
 */
$categoryWriteService = StaticGXCoreLoader::getService('CategoryWrite');

// ID and ID type object. If GET parameter `id` is provided it will be used.
$id     = (array_key_exists('id', $_GET)) ? $_GET['id'] : 10;
$idType = new IdType($id);

// Deleting category.
try
{
	$categoryWriteService->deleteCategoryById($idType);
	echo '<h1>Deleted category with ID ' . $id . '</h1>';
}
catch(UnexpectedValueException $e)
{
	echo '<h1>Could not delete category with ID ' . $id . '</h1>';
	echo '<h3>Error object:</h3>';
	echo '<pre>';
	print_r($e);
	echo '</pre>';
}
