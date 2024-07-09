<?php
/* --------------------------------------------------------------
   display_category_data.php 2016-02-16
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

/**
 * Display Category Data
 * 
 * @param int $categoryId
 * @param StoredCategory|null $category
 *
 * @return string
 */
function displayCategoryData($categoryId, StoredCategory $category = null)
{
	ob_start();
	?>
	<html>
		<head>
			<title>Category Data</title>
			<link rel="stylesheet"
			      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
			      integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
			      crossorigin="anonymous">
		</head>
		<body class="container">
			<div class="row">
				<?php if($category): ?>
					<table class="table">
						<thead>
							<tr>
								<th>Nr</th>
								<th>Is active?</th>
								<th>Date added</th>
								<th>Date last modified</th>
								<th>Name</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php echo $category->getCategoryId(); ?></td>
								<td><?php echo $category->isActive() ? 'true' : 'false'; ?></td>
								<td><?php echo $category->getAddedDateTime()->format('d.m.Y H:i'); ?></td>
								<td><?php echo $category->getLastModifiedDateTime()->format('d.m.Y H:i'); ?></td>
								<td><?php echo $category->getName(new LanguageCode(new StringType('de'))); ?></td>
								<td><?php echo $category->getDescription(new LanguageCode(new StringType('de'))); ?></td>
							</tr>
						</tbody>
					</table>
					<pre>
				<?php print_r($category); ?>
			</pre>
				<?php else: ?>
					<div class="text-center">
						Could not find category with ID <?php echo $categoryId ?>.
					</div>
				<?php endif; ?>
			</div>
		</body>
	</html>
	<?php

	return ob_get_clean();
}
