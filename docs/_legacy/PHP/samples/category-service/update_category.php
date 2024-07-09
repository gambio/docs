<?php
/* --------------------------------------------------------------
   update_category.php 2016-02-18
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

/**
 * This script will update a category and display it in a rendered HTML page.
 *
 * You can update a specific category record by passing in a GET parameter `id`. Without that parameter a
 * category with ID 1 will be updated.
 */

// Including function to display the data from a category entity.
require_once 'display_category_data.php';

// Including the application_top file.
chdir('../../../../src');
require_once 'includes/application_top_main.php';

/**
 * Creating a category write service.
 * 
 * @var CategoryWriteService $categoryWriteService
 */
$categoryWriteService = StaticGXCoreLoader::getService('CategoryWrite');

/**
 * Creating a category read service.
 * 
 * @var CategoryReadService $categoryReadService
 */
$categoryReadService = StaticGXCoreLoader::getService('CategoryRead');

// ID and ID type object. If GET parameter `id` is provided it will be used.
$id     = (array_key_exists('id', $_GET)) ? $_GET['id'] : 10;
$idType = new IdType($id);

// Language code for German. Used as reference.
$languageCode = new LanguageCode(new StringType('de'));

/**
 * Helper function to generate a random string.
 *
 * @param int $charLength Maximum character count.
 *
 * @return string Generated output.
 */
function getRandomString($charLength = 5)
{
	// MD5 generated value.
	$randomString = md5(microtime());

	// Pick a random range from string with a defined maximum length.
	$cut = substr($randomString, mt_rand(0, 26), $charLength);

	// Returned cut value.
	return $cut;
}

/**
 * Helper function to return randomly a `true` or `false` value.
 */
function getRandomBoolean() {
	return mt_rand(0,1) == 1;
}

// Fetch and update the category.
try
{
	// Fetch category.
	$category = $categoryReadService->getCategoryById($idType);

	// Change some attributes.
	$category->setActive(new BoolType(getRandomBoolean()));
	$category->setName(new StringType(getRandomString()), $languageCode);
	$category->setDescription(new StringType(getRandomString()), $languageCode);

	// Save changed category.
	$categoryWriteService->updateCategory($category);
}
catch(UnexpectedValueException $e)
{
	$category = null;
}

// Display in HTML.
echo displayCategoryData($id, $category);