<?php
/* --------------------------------------------------------------
   create_email.php 2016-02-16
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

/**
 * This script will queue a new email with an attachment, so it can be sent later.
 *
 * To see a working example of the email send process, see 'send_email.php'.
 */

// Including the application_top file.
chdir('../../../../src');
require_once 'includes/application_top_main.php';

/**
 * Creating instance of the email service.
 *
 * @var EmailService $service
 */
$service = StaticGXCoreLoader::getService('Email');

/**
 * Creating a new email.
 *
 * @var Email $email
 */
$email = MainFactory::create('Email');

/**
 * Create and assign email sender.
 *
 * @var EmailContact $sender
 */
$sender = MainFactory::create('EmailContact', MainFactory::create('EmailAddress', 'php-sample@example.com'),
                              MainFactory::create('ContactType', 'sender'),
                              MainFactory::create('ContactName', 'Marcus Testman'));
$email->setSender($sender);

/**
 * Create and assign email recipient.
 *
 * @var EmailContact $recipient
 */
$recipient = MainFactory::create('EmailContact',
                                 MainFactory::create('EmailAddress', 'php-sample-recipient@example.com'),
                                 MainFactory::create('ContactType', 'recipient'),
                                 MainFactory::create('ContactName', 'Peter Testman'));
$email->setRecipient($recipient);

/**
 * Create and assign email subject.
 *
 * @var EmailSubject $subject
 */
$subject = MainFactory::create('EmailSubject', 'Test email');
$email->setSubject($subject);

/**
 * Create and assign email plain content.
 *
 * @var EmailContent $plainContent
 */
$plainContent = MainFactory::create('EmailContent', 'Hello! This is an example text.');
$email->setContentPlain($plainContent);

/**
 * Attach a file to email.
 *
 * @var EmailAttachment      $attachment
 * @var AttachmentCollection $attachmentCollection
 */
$attachment = MainFactory::create('EmailAttachment');
$attachment->setName(MainFactory::create('AttachmentName', 'my_file_name.txt'));
$attachment->setPath(MainFactory::create('AttachmentPath', __DIR__ . DIRECTORY_SEPARATOR . 'upload_sample.txt'));

$attachmentCollection = MainFactory::create('AttachmentCollection', $attachment);
$email->setAttachments($attachmentCollection);

// Queue E-Mail
$service->queue($email);

// Output
echo '
	<h1>Queued a new email!</h1>
	<pre>' . print_r($email, true) . '</pre>
';
