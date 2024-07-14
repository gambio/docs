<?php
/* --------------------------------------------------------------
   fetch_category.php 2016-02-18
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

/**
 * This script will fetch a category and display it in a rendered HTML page.
 *
 * You can fetch a specific category record by passing in a GET parameter `id`. Without that parameter a
 * category with ID 1 will be fetched.
 */

// Including function to display the data from a category entity.
require_once 'display_category_data.php';

// Including the application_top file.
chdir('../../../../src');
require_once 'includes/application_top_main.php';

/**
 * Creating a category read service.
 * @var CategoryReadService $categoryReadService
 */
$categoryReadService = StaticGXCoreLoader::getService('CategoryRead');

// ID and ID type object. If GET parameter `id` is provided it will be used.
$id     = (array_key_exists('id', $_GET)) ? $_GET['id'] : 1;
$idType = new IdType($id);

// Fetching category.
try
{
	$category = $categoryReadService->getCategoryById($idType);
}
catch(UnexpectedValueException $e)
{
	$category = null;
}

// Display in HTML.
echo displayCategoryData($id, $category);