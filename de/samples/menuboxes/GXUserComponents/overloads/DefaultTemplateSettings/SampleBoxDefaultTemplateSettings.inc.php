<?php

/* --------------------------------------------------------------
   SampleBoxDefaultTemplateSettings.inc.php 2016-08-16
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   -------------------------------------------------------------- 
*/

class SampleBoxDefaultTemplateSettings extends SampleBoxDefaultTemplateSettings_parent
{
	public function setTemplateSettingsArray(array $settingsArray)
	{
		$settingsArray['MENUBOXES']['sample_box'] = array('POSITION' => 'gm_box_pos_99', 'STATUS' => 1);
		parent::setTemplateSettingsArray($settingsArray);
	}
}