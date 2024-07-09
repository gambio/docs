<?php
/* --------------------------------------------------------------
   display_product_data.php 2016-04-15
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

/**
 * Display Product Data
 *
 * @param GXEngineProduct $product
 *
 * @return string
 */
function displayProductData(GXEngineProduct $product)
{
	/**
	 * Creates a language provider instance and fetch the existing language codes.
	 *
	 * The language codes are required for the language specific product data.
	 *
	 * @var LanguageProvider $languageProvider
	 */
	$languageProvider = MainFactory::create('LanguageProvider', StaticGXCoreLoader::getDatabaseQueryBuilder());
	$languageCodeArray = $languageProvider->getCodes();
	
	ob_start();
	?>
	<html>
		<head>
			<title>Product Data</title>
			<link rel="stylesheet"
			      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
			      integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
			      crossorigin="anonymous">
		</head>
		<body class="container">
			<div class="row">
				<table class="table">
					<thead>
						<tr>
							<th>ID</th>
							<th>Language Code</th>
							<th>Name</th>
							<th>Quantity</th>
							<th>Price</th>
							<th>Model</th>
							<th>Sort</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($languageCodeArray as $languageCode): ?>
							<tr>
								<td><?php echo $product->getProductId(); ?></td>
								<td><?php echo $languageCode; ?></td>
								<td><?php echo $product->getName($languageCode); ?></td>
								<td><?php echo $product->getQuantity(); ?></td>
								<td><?php echo $product->getPrice(); ?></td>
								<td><?php echo $product->getProductModel(); ?></td>
								<td><?php echo $product->getSortOrder(); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		<pre>
			<?php print_r($product); ?>
		</pre>
		</body>
	</html>
	<?php
	return ob_get_clean();
}