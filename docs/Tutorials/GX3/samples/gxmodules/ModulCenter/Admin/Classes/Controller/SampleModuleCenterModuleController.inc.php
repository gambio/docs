<?php
/* --------------------------------------------------------------
   SampleModuleCenterModuleController.inc.php 2016-03-01
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2018 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

class SampleModuleCenterModuleController extends AbstractModuleCenterModuleController
{
	protected function _init()
	{
		$this->pageTitle = new NonEmptyStringType($this->languageTextManager->get_text('sample_title'));
	}
	
	
	public function actionDefault()
	{
		$template = new ExistingFile(new NonEmptyStringType(DIR_FS_CATALOG
		                                                    . 'GXModules/Samples/ModulCenter/Admin/Html/sample_configuration.html'));
		
		$data = MainFactory::create('KeyValueCollection', [
			'greeting' => 'Hallo Welt!',
		]);
		
		return MainFactory::create('AdminLayoutHttpControllerResponse', $this->pageTitle, $template, $data);
	}
}