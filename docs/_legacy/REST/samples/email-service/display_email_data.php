<?php
/* --------------------------------------------------------------
   display_email_data.php 2016-02-16
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

/**
 * Display Email Data
 * 
 * @param array $resultArray
 *
 * @return string
 */
function displayEmailData(array $resultArray)
{
	ob_start();
	?>
	<html>
		<head>
			<title>Email Data</title>
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
					<table class="table">
						<thead>
							<tr>
								<th>Nr</th>
								<th>Sender</th>
								<th>Recipient</th>
								<th>Subject</th>
								<th>Plain content</th>
								<th>Is pending?</th>
								<th>Created</th>
								<th>Sent</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php echo $resultArray['id'] ?></td>
								<td><?php echo $resultArray['sender']['emailAddress'] . ' (' . $resultArray['sender']['contactName'] . ')'; ?></td>
								<td><?php echo $resultArray['recipient']['emailAddress'] . ' (' . $resultArray['recipient']['contactName'] . ')'; ?></td>
								<td><?php echo $resultArray['subject'] ?></td>
								<td style="max-width: 800px;"><pre style="max-width: 50%;max-height: 400px;"><?php echo $resultArray['contentPlain'] ?></pre></td>
								<td><?php echo $resultArray['isPending'] ?></td>
								<td><?php echo $resultArray['creationDate'] ?></td>
								<td><?php echo $resultArray['sentDate'] ?></td>
							</tr>
						</tbody>
					</table>
				</div>
				<pre><?php echo filter_var(print_r($resultArray, true), FILTER_SANITIZE_FULL_SPECIAL_CHARS); ?></pre>
			<?php endif; ?>
		</body>
	</html>
	<?php

	return ob_get_clean();
}