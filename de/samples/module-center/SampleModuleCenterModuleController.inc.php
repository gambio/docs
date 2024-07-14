<?php
/* --------------------------------------------------------------
   SampleModuleCenterModuleController.inc.php 2016-03-01
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

class SampleModuleCenterModuleController extends AbstractModuleCenterModuleController
{
	protected function _init()
	{
		$this->pageTitle = $this->languageTextManager->get_text('sample_title');
		$this->contentView->set_template_dir(DIR_FS_ADMIN . 'html/content/module_center/');
	}
	
	
	public function actionDefault()
	{
		$templateData = array('greeting' => 'Hallo Welt!');
		
		$content = $this->_render('sample_configuration.html', $templateData);
		
		return new AdminPageHttpControllerResponse($this->pageTitle, $content);
	}
}