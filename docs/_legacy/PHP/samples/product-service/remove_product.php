<?php
/* --------------------------------------------------------------
   remove_product.php 2016-02-15
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
 * Creates the services to create product entities and perform write actions.
 *
 * @var ProductWriteService $productWriteService
 * @var ProductReadService  $productReadService
 */
$productWriteService = StaticGXCoreLoader::getService('ProductWrite');

/**
 * Creates an id type to pass it through the ::deleteProductById Method.
 */
$productId     = (array_key_exists('id', $_GET)) ? $_GET['id'] : 10;
$productIdType = new IdType($productId);

try
{
	$productWriteService->deleteProductById($productIdType);
	echo 'Deleted product with ID ' . $productId;
}
catch(UnexpectedValueException $e)
{
	echo 'Delete failed. Could not find order with ID '. $productId;
}