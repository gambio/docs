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
 * @param int        $emailId
 * @param Email|null $email
 *
 * @return string
 */
function displayEmailData($emailId, Email $email = null)
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
		<body class="container">
			<div class="row">
				<?php if($email): ?>
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
								<td><?php echo $email->getId(); ?></td>
								<td><?php echo $email->getSender(); ?></td>
								<td><?php echo $email->getRecipient(); ?></td>
								<td><?php echo $email->getSubject(); ?></td>
								<td style="max-width: 800px;">
									<pre style="max-width: 50%;max-height: 400px;"><?php echo $email->getContentPlain(); ?></pre>
								</td>
								<td><?php echo $email->isPending() ? 'true' : 'false'; ?></td>
								<td><?php echo ($email->getCreationDate()) ? $email->getCreationDate()
								                                                   ->format('d.m.Y H:i:s') : ''; ?></td>
								<td><?php echo ($email->getSentDate()) ? $email->getSentDate()
								                                               ->format('d.m.Y H:i:s') : ''; ?></td>
							</tr>
						</tbody>
					</table>
					<pre>
						<?php echo filter_var(print_r($email, true), FILTER_SANITIZE_FULL_SPECIAL_CHARS); ?>
					</pre>
				<?php else: ?>
					<div class="text-center">
						Email with ID <?php echo $emailId ?> does not exist.
					</div>
				<?php endif; ?>
			</div>
		</body>
	</html>
	<?php
	
	return ob_get_clean();
}
