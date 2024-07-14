<?php
/* --------------------------------------------------------------
   fetch_product.php 2016-02-15
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

require_once 'display_product_data.php'; 

// Change location to omit errors when including the application top file.
chdir('../../../../src');
require_once 'includes/application_top_main.php';

/**
 * Creates the services to fetch product entities
 *
 * @var ProductReadService $productReadService
 */
$productReadService = StaticGXCoreLoader::getService('ProductRead');

$productId     = (array_key_exists('id', $_GET)) ? $_GET['id'] : 1;
$productIdType = new IdType($productId);

/**
 * Fetches the product entity.
 */
$product = $productReadService->getProductById($productIdType);

echo displayProductData($product); 