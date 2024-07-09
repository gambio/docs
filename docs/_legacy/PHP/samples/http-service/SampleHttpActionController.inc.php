<?php
/* --------------------------------------------------------------
   SampleHttpController.php 2016-02-11
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

/**
 * Class SampleHttpController
 *
 * This is a sample http view controller class which present several action methods.
 *
 * IMPORTANT (Instruction to use the sample controller class):
 *
 * Copy this file to the destination directory 'src/GXEngine/Controllers' and register the sample controller
 * in the EnvironmentHttpViewControllerRegistryFactory::_addAvailableControllers method with the following code
 * snippet:
 * 
 *   $registry->set('SampleHttpAction', 'SampleHttpActionController');
 * 
 * Just paste the snippet to the end of the method body.
 *
 * Afterwards, open the UR  http://shop-url.de/shop.php?do=SampleHttpAction or 
 * http://shop-url.de/shop.php?do=SampleHttpAction/XY to delegate to the action methods.
 */
class SampleHttpActionController extends HttpViewController
{
	/**
	 * Default action method.
	 *
	 * This method is invoked by the request url: 'start.php?do=SampleHttpAction'
	 *
	 * @return HttpControllerResponseInterface
	 */
	public function actionDefault()
	{
		// Execute business logic here!
		return new HttpControllerResponse('Hello World');
	}


	/**
	 * XY action method.
	 *
	 * This method is invoked by the request url: 'start.php?do=SampleHttpAction/XY'
	 *
	 * @return HttpControllerResponseInterface
	 */
	public function actionXY()
	{
		// Execute business logic here!
		return new HttpControllerResponse('Hello World with special action');
	}
}
