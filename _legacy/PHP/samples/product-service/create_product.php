<?php
/* --------------------------------------------------------------
   create_product.php 2017-12-01
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2017 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

// Change location to omit errors when including the application top file.
chdir('../../../../src');
require_once 'includes/application_top_main.php';

/**
 * Creates the services to create product entities and perform write actions.
 *
 * @var ProductWriteService  $productWriteService
 * @var ProductObjectService $productObjectService
 */
$productWriteService  = StaticGXCoreLoader::getService('ProductWrite');
$productObjectService = StaticGXCoreLoader::getService('ProductObject');

/**
 * Creates an empty product entity with default values.
 */
$product = $productObjectService->createProductObject();

/**
 * Creates a language provider instance and fetch the existing language codes.
 * 
 * The language codes are required for the language specific product data.
 *
 * @var LanguageProvider $languageProvider
 */
$languageProvider  = MainFactory::create('LanguageProvider', StaticGXCoreLoader::getDatabaseQueryBuilder());
$languageCodeArray = $languageProvider->getCodes();

/**
 * Sets the product configuration values.
 */
$product->setQuantity(new DecimalType(mt_rand(0.0, 100.0)));
$product->setProductTypeId(new IdType(mt_rand(1, 10)));
$product->setProductModel(new StringType('product-model-' . mt_rand(1000, 9999)));
$product->setEan(new StringType('product-ean-' . mt_rand(100, 999)));
$product->setPrice(new DecimalType(mt_rand(0.0, 100.0)));
$product->setActive(new BoolType(mt_rand(1, 2) === 1));
$product->setSortOrder(new IntType(mt_rand(1, 50)));
$product->setDiscountAllowed(new DecimalType(mt_rand(0.0, 100.0)));
$product->setWeight(new DecimalType(mt_rand(0.0, 100.0)));
$product->setTaxClassId(new IdType(mt_rand(0, 100)));
$product->setManufacturerId(new IdType(mt_rand(0, 100)));
$product->setFsk18(new BoolType(mt_rand(1, 2) === 1));
$product->setVpeValue(new DecimalType(mt_rand(0.0, 100.0)));
$product->setVpeActive(new BoolType(mt_rand(1, 2) === 1));
$product->setVpeId(new IdType(mt_rand(1, 100)));
$product->setShippingCosts(new DecimalType(mt_rand(0.0, 100.0)));

/**
 * Sets the language specific values by the given language codes.
 */
foreach($languageCodeArray as $languageCode):
	$product->setName(new StringType('New Article Name'), $languageCode);
	$product->setDescription(new StringType('this description is a bit longer than the short one'), $languageCode);
	$product->setShortDescription(new StringType('this is a short description'), $languageCode);
	$product->setKeywords(new StringType('keywords, key, words'), $languageCode);
	$product->setInfoUrl(new StringType('https://www.google.de'), $languageCode);
	$product->setMetaTitle(new StringType('meta-title'), $languageCode);
	$product->setMetaDescription(new StringType('meta-description'), $languageCode);
	$product->setMetaKeywords(new StringType('meta-keywords'), $languageCode);
	$product->setUrlKeywords(new StringType('url-keywords'), $languageCode);
	$product->setCheckoutInformation(new StringType('Checkout Information'), $languageCode);
	$product->setViewedCount(new IntType(0), $languageCode);
endforeach;

/**
 * Fetch the settings from the product entity.
 */
$settings = $product->getSettings();

/**
 * Sets new setting values.
 */
$settings->setShowOnStartpage(new BoolType(mt_rand(1, 2) === 1));
$settings->setStartpageSortOrder(new IntType(mt_rand(1, 10)));
$settings->setDetailsTemplate(new StringType('details_template_name.html'));
$settings->setOptionsDetailsTemplate(new StringType('option_details_template.html'));
$settings->setOptionsListingTemplate(new StringType('option_listing_template.html'));
$settings->setShowAddedDateTime(new BoolType(mt_rand(1, 2) === 1));
$settings->setShowPriceOffer(new BoolType(mt_rand(1, 2) === 1));
$settings->setPriceStatus(new IntType(mt_rand(1, 10)));
$settings->setShowQuantityInfo(new BoolType(mt_rand(1, 2) === 1));
$settings->setShowWeight(new BoolType(mt_rand(1, 2) === 1));
$settings->setMinOrder(new DecimalType(0.5));
$settings->setGraduatedQuantity(new DecimalType(0.5));
$settings->setSitemapPriority(new StringType('site map priority'));
$settings->setSitemapChangeFreq(new StringType('0.6'));
$settings->setSitemapEntry(new BoolType(mt_rand(1, 2) === 1));

/**
 * Sets the settings to the product entity.
 */
$product->setSettings($settings);

/**
 * Creates a new product.
 */
$productWriteService->createProduct($product);

echo 'Created product!';
