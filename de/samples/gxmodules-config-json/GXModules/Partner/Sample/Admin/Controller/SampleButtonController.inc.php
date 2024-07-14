<?php
/* --------------------------------------------------------------
	SampleButtonController.inc.php 2018-01-23
	Gambio GmbH
	http://www.gambio.de
	Copyright (c) 2018 Gambio GmbH
	Released under the GNU General Public License (Version 2)
	[http://www.gnu.org/licenses/gpl-2.0.html]
	--------------------------------------------------------------
*/

/**
 * Class SampleButtonController
 */
class SampleButtonController extends GXModuleController
{
	/**
	 * @return array|string
	 */
	public function setContent()
	{
		return $this->config->get('active');
	}
	
	
	/**
	 * @param $data
	 *
	 * @return string
	 */
	public function setInfo($data)
	{
		return 'setInfo';
	}
	
	
	/**
	 * @param $data
	 *
	 * @return string
	 */
	public function someAction($data)
	{
		return 'someAction';
	}
}