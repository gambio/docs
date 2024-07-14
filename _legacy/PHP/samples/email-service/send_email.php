<?php
/* --------------------------------------------------------------
   send_email.php 2016-02-16
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

/**
 * This script will send a new email.
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

// Send E-Mail
$service->send($email);

// Output
echo '
	<h1>Sent a new email!</h1>
	<pre>' . print_r($email, true) . '</pre>	
';
