<?php
/* --------------------------------------------------------------
   display_customer_data.php 2016-02-24
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

/**
 * Display Customer Data
 * 
 * @param array $resultArray
 * @param bool  $create
 * @param int   $customerId
 *
 * @return string
 */
function displayCustomerData(array $resultArray, $create = true, $customerId = 0)
{
	ob_start();
	?>
	<html>
		<head>
			<title>REST Customer Sample</title>
			<link rel="stylesheet"
			      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
			      integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
			      crossorigin="anonymous">
		</head>
		<body class="container-fluid">
			<div class="alert alert-info text-center">
				Bitte stellen Sie sicher, dass ein Benutzerkonto mit dem Nutzer <b>admin@example.org</b> und dem Passwort <b>12345</b> existiert und in der Config-Datei eingetragen ist.
			</div>

			<?php if(array_key_exists('status', $resultArray) && $resultArray['status'] === 'error'): ?>
				<div class="alert alert-danger text-center">
					<?php echo $resultArray['message'] ?>
				</div>
			<?php else: ?>
				<div>
					<div class="alert alert-success text-center">
						<?php if($create): ?>
							Neues <?php echo ($resultArray['isGuest']) ? 'Gast' : 'Kunden' ?>konto angelegt.
							<?php else: ?>
							Daten des Kundenkontos mit der ID <?php echo $customerId ?>
						<?php endif; ?>
					</div>
					<table class="table">
						<thead>
							<tr>
								<th>Id</th>
								<th>Number</th>
								<th>Gender</th>
								<th>First name</th>
								<th>Last name</th>
								<th>Date of brith</th>
								<th>Vat number</th>
								<th>Vat number status</th>
								<th>Telephone</th>
								<th>Fax</th>
								<th>E-Mail</th>
								<th>Status ID</th>
								<th>Gast</th>
								<th>Address Id</th>
								<th>Link</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php echo $resultArray['id']; ?></td>
								<td><?php echo $resultArray['number']; ?></td>
								<td><?php echo $resultArray['gender']; ?></td>
								<td><?php echo $resultArray['firstname']; ?></td>
								<td><?php echo $resultArray['lastname']; ?></td>
								<td><?php echo $resultArray['dateOfBirth']; ?></td>
								<td><?php echo $resultArray['vatNumber']; ?></td>
								<td><?php echo $resultArray['vatNumberStatus']; ?></td>
								<td><?php echo $resultArray['telephone']; ?></td>
								<td><?php echo $resultArray['fax']; ?></td>
								<td><?php echo $resultArray['email']; ?></td>
								<td><?php echo $resultArray['statusId']; ?></td>
								<td><?php echo ($resultArray['isGuest']) ? 'Ja' : 'Nein'; ?></td>
								<td><?php echo $resultArray['addressId']; ?></td>
								<td><?php echo $resultArray['_links']['address']; ?></td>
							</tr>
						</tbody>
					</table>
					<pre>Response: <?php print_r($resultArray) ?></pre>
				</div>
			<?php endif; ?>
		</body>
	</html>
	<?php
	return ob_get_clean();
}
