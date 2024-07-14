<?php
/* --------------------------------------------------------------
   SampleModuleCenterModule.inc.php 2018-02-28
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2018 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

class SampleModuleCenterModule extends AbstractModuleCenterModule
{
	
	protected function _init()
	{
		$this->title       = $this->languageTextManager->get_text('sample_title');
		$this->description = $this->languageTextManager->get_text('sample_description');
		$this->sortOrder   = 99999;
	}
	
	/**
	 * Installs the module (optional)
	 */
	public function install()
	{
		parent::install();
		
		$columnsQuery = $this->db->query('DESCRIBE `admin_access` \'sample\'');
		if(!$columnsQuery->num_rows())
		{
			$this->db->query('ALTER TABLE `admin_access` ADD `sample` INT( 1 ) NOT NULL DEFAULT \'0\';');
		}
		
		/**
		 * Give access-rights to the first admin account and the admin who activates this module
		 */
		$this->db->set('sample', '1')->where('customers_id', '1')->limit(1)->update('admin_access');
		$this->db->set('sample', '1')
		         ->where('customers_id', $_SESSION['customer_id'])
		         ->limit(1)
		         ->update('admin_access');
	}
	
	/**
	 * Uninstalls the module (optional)
	 */
	public function uninstall()
	{
		parent::uninstall();
		
		$this->db->query('ALTER TABLE `admin_access` DROP `sample`');
	}
	
}