<?php
/* --------------------------------------------------------------
   create_category.php 2016-02-18
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

/**
 * This script will create a new category.
 */

// Including the application_top file.
chdir('../../../../src');
require_once 'includes/application_top_main.php';

/**
 * Creating a category object service.
 * 
 * @var CategoryObjectService $categoryObjectService
 */
$categoryObjectService = StaticGXCoreLoader::getService('CategoryObject');

/**
 * Creating a category write service.
 * 
 * @var CategoryWriteService $categoryWriteService
 */
$categoryWriteService = StaticGXCoreLoader::getService('CategoryWrite');

/**
 * Creating a category read service.
 * 
 * @var CategoryReadService $categoryWriteService
 */
$categoryReadService = StaticGXCoreLoader::getService('CategoryRead');

/**
 * Creating a new category.
 * 
 * @var Category $category
 */
$category = $categoryObjectService->createCategoryObject();

// Setting attributes.
$category->setActive(new BoolType(true));
$category->setParentId(new IdType(0));
$category->setName(new StringType('Testkategorie'), new LanguageCode(new StringType('de')));
$category->setDescription(new StringType('Kategoriebeschreibung'), new LanguageCode(new StringType('de')));
$category->setHeadingTitle(new StringType('Kagegorieüberschrift'), new LanguageCode(new StringType('de')));

// Setting some category settings.
$categorySettings = $category->getSettings();
$categorySettings->setShowStock(new BoolType(true));
$categorySettings->setShowGraduatedPrices(new BoolType(true));
$categorySettings->setPermittedCustomerStatus(new IdType(1), new BoolType(true));
$categorySettings->setShowSubcategories(new BoolType(true));
$categorySettings->setShowSubcategoryImages(new BoolType(true));

// Setting addon value.
$category->setAddonValue(new StringType('additionalDataKey'), new StringType('additionalDataValue'));

// Setting category image and respective alternative text.
// The given image has to be imported first.
// Then you will be able to assign the image to the category.
$imagePath       = __DIR__ . DIRECTORY_SEPARATOR . 'image_sample.jpg';
$storedImageName = $categoryWriteService->importCategoryImageFile(new ExistingFile(new NonEmptyStringType($imagePath)),
                                                                  new FilenameStringType(basename($imagePath)));
$category->setImage(new StringType(basename($imagePath)));
$category->setImageAltText(new StringType('Alternativtext Kategoriebild'), new LanguageCode(new StringType('de')));

// Store category to database (Created ID is returned from server).
$storedCategoryId = $categoryWriteService->createCategory($category);

// Fetch newly created category from database to get the stored category object.
$storedCategory = $categoryReadService->getCategoryById(new IdType($storedCategoryId));

// Output
echo '<h1>Stored a new category!</h1>';
echo '<pre>';
print_r($storedCategory);
echo '</pre>';
