<?php
/* --------------------------------------------------------------
   EmailSubjectTest.php 2015-01-29 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2015 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

require_once __DIR__ . '/../../tests.bootstrap.inc.php';
require_once __DIR__ . '/includes/EmailMockFactory.inc.php';

class EmailSubjectTest extends GxTestCase
{
	// -------------------------------------------------------------------------
	// TEST OBJECT INSTANTIATION
	// -------------------------------------------------------------------------
	
	public function testConstructorMethodWithValidArgument()
	{
		new EmailSubject('Subject');
	}
	
	
	public function testConstructorMethodThrowsExceptionWithNull()
	{
		$this->expectException(InvalidArgumentException::class, false);
		new EmailSubject(null);
	}
	
	
	public function testConstructorMethodThrowsExceptionWithLargeString()
	{
		$this->expectException(InvalidArgumentException::class, false);
		new EmailSubject(str_repeat('-', 999));
	}
	
	// -------------------------------------------------------------------------
	// TEST STRING USAGE
	// -------------------------------------------------------------------------
	
	public function testStringTypeCastReturnsSubject()
	{
		$testSubject = 'Subject';
		$subject     = new EmailSubject($testSubject);
		$this->assertEquals($testSubject, (string)$subject);
	}
}