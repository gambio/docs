<?php
/* --------------------------------------------------------------
   display_category_data.php 2016-02-24
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
 * @param array $resultArray
 * @param bool  $created
 *
 * @return string
 */
function displayCategoryData(array $resultArray, $created = true)
{
	ob_start();
	?>
	<html>
		<head>
			<title>REST Category Sample</title>
			<link rel="stylesheet"
			      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
			      integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
			      crossorigin="anonymous">
		</head>
		<body class="container-fluid">
			<?php if(array_key_exists('status', $resultArray) && $resultArray['status'] === 'error'): ?>
				<div class="alert alert-danger text-center">
					<?php echo $resultArray['message'] ?>
				</div>
			<?php else: ?>
				<div>
					<?php if($created): ?>
						<div class="alert alert-success text-center">
							Category <?php echo ($created === 'updated') ? 'aktualisiert' : 'hinzugefügt' ?>.
						</div>
					<?php endif; ?>
					<table class="table">
						<thead>
							<tr>
								<th>Id</th>
								<th>Parent Id</th>
								<th>Active</th>
								<th>Sort Order</th>
								<th>Date Added</th>
								<th>Last Modified</th>
								<th>Name</th>
								<th>Title</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php echo $resultArray['id'] ?></td>
								<td><?php echo $resultArray['parentId'] ?></td>
								<td><?php echo $resultArray['isActive'] ?></td>
								<td><?php echo $resultArray['sortOrder'] ?></td>
								<td><?php echo $resultArray['dateAdded'] ?></td>
								<td><?php echo $resultArray['lastModified'] ?></td>
								<td>
									<?php
									foreach($resultArray['name'] as $lang => $categoryName):
										echo $lang . ': ' . $categoryName . '<br/>';
									endforeach;
									?>
								</td>
								<td>
									<?php
									foreach($resultArray['headingTitle'] as $lang => $categoryTitle):
										echo $lang . ': ' . $categoryTitle . '<br/>';
									endforeach;
									?>
								</td>
								<td>
									<?php
									foreach($resultArray['description'] as $lang => $categoryDescription):
										echo $lang . ': ' . $categoryDescription . '<br/>';
									endforeach;
									?>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			<?php endif; ?>
		</body>
	</html>
	<?php
	return ob_get_clean();
}
