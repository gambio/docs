<?php

/* --------------------------------------------------------------
   SampleHttpRenderController.php 2016-02-12
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

/**
 * Class SampleHttpRenderController
 *
 * This is a sample http view controller class which demonstrate how to work with template files.
 *
 * IMPORTANT (Instruction to use the sample controller class):
 *
 * Copy this file to the destination directory 'src/GXEngine/Controllers' and register the sample controller
 * in the EnvironmentHttpViewControllerRegistryFactory::_addAvailableControllers method with the following code
 * snippet:
 * 
 *   $registry->set('SampleHttpRender', 'SampleHttpRenderController');
 *
 * Just paste the snippet to the end of the method body.
 *
 * Following request url's are used by this sample:
 *
 * @link http://shop-url.de/shop.php?do=SampleHttpRender/RenderDemonstration
 */
class SampleHttpRenderController extends HttpViewController
{
	/**
	 * Sample method to demonstrate how to render template files and inject values to them.
	 * The used template file is stored under docs/PHP/samples/http-service/render_sample.html.
	 * Please copy the sample template file and this controller class to the same directory to test it.
	 *
	 * Feel free to modify the injected template variables, the template directory, template file or whatever
	 * you want.
	 *
	 * @return HttpControllerResponseInterface
	 */
	public function actionRenderDemonstration()
	{
		# set the template directory to the current directory
		$this->contentView->set_template_dir(__DIR__ . DIRECTORY_SEPARATOR);
		$html = $this->_render('render_sample.html', array('hey' => 'Hello', 'world' => 'World'));

		return new HttpControllerResponse($html);
	}
}
