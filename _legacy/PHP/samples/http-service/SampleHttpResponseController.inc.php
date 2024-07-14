<?php

/* --------------------------------------------------------------
   SampleHttpResponseController.php 2016-02-11
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

/**
 * Class SampleHttpResponseController
 *
 * This is a sample HTTP view controller class which present the several response values of the action methods.
 *
 * IMPORTANT (Instruction to use the sample controller class):
 *
 * Copy this file to the destination directory 'src/GXEngine/Controllers' and register the sample controller
 * in the EnvironmentHttpViewControllerRegistryFactory::_addAvailableControllers method with the following code
 * snippet:
 * 
 *   $registry->set('SampleHttpResponse', 'SampleHttpResponseController');
 * 
 * Just paste the snippet to the end of the method body.
 *
 * Following request URL's are used by this sample:
 *
 * @link http://shop-url.de/shop.php?do=SampleHttpResponse/HttpResponse
 * @link http://shop-url.de/shop.php?do=SampleHttpResponse/JsonResponse
 * @link http://shop-url.de/shop.php?do=SampleHttpResponse/RedirectResponse
 * @link http://shop-url.de/admin/admin.php?do=SampleHttpResponse/AdminPageResponse
 */
class SampleHttpResponseController extends AdminHttpViewController
{
	/**
	 * Sample method which returns a sample instance of a http controller response.
	 *
	 * This method is invoked by the request URL: 'start.php?do=SampleHttpResponse/HttpResponse'
	 *
	 * @return HttpControllerResponseInterface
	 */
	public function actionHttpResponse()
	{
		// Execute business logic here ... 
		return new HttpControllerResponse('Hello world response body.');
	}


	/**
	 * Sample method which returns a sample instance of a json http controller response.
	 *
	 * This method is invoked by the request URL: 'start.php?do=SampleHttpResponse/JsonResponse'
	 *
	 * @return HttpControllerResponseInterface
	 */
	public function actionJsonResponse()
	{
		// Execute business logic here ... 
		return new JsonHttpControllerResponse(array('jsonKey' => 'jsonValue', 'other', 'key' => array('foo' => 'bar')));
	}


	/**
	 * Sample method which returns a sample instance of a redirect http controller response.
	 *
	 * This method is invoked by the request URL: 'start.php?do=SampleHttpResponse/RedirectResponse'
	 *
	 * @return HttpControllerResponseInterface
	 */
	public function actionRedirectResponse()
	{
		// Execute business logic here ... 
		return new RedirectHttpControllerResponse('http://www.google.de');
	}


	/**
	 * Sample method which returns a sample instance of a http controller response.
	 *
	 * This method is invoked by the request URL: 'start.php?do=SampleHttpResponse/AdminPageResponse'
	 *
	 * @return HttpControllerResponseInterface
	 */
	public function actionAdminPageResponse()
	{
		// Execute business logic here ... 
		
		// WARNING -    this method is just a sample .. if you return an instance of AdminPageHttpControllerResponse,
		//              let the controller class extend the AdminHttpViewController.
		
		return new AdminPageHttpControllerResponse('Admin Page Title', 'Hello world response body.');
	}
}
