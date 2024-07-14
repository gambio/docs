<?php

/* --------------------------------------------------------------
   SampleHttpRequestController.php 2016-02-11
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

/**
 * Class SampleHttpRequestController
 *
 * This is a sample HTTP view controller class which demonstrate how to work with the global variables
 * $_GET and $_POST in the internal controller layer.
 *
 * IMPORTANT (Instruction to use the sample controller class):
 *
 * Copy this file to the destination directory 'src/GXEngine/Controllers' and register the sample controller
 * in the EnvironmentHttpViewControllerRegistryFactory::_addAvailableControllers method with the following code
 * snippet:
 * 
 *   $registry->set('SampleHttpRequest', 'SampleHttpRequestController');
 *
 * Just paste the snippet to the end of the method body.
 *
 * Following request URL's are used by this sample:
 *
 * @link http://shop-url.de/shop.php?do=SampleHttpRequest/HandleGetParameterCollection
 * @link http://shop-url.de/shop.php?do=SampleHttpRequest/HandleGetParameterCollection&1=a&2=b&3=c
 * @link http://shop-url.de/shop.php?do=SampleHttpRequest/HandleSpecificGetParameter
 * @link http://shop-url.de/shop.php?do=SampleHttpRequest/HandleSpecificGetParameter&hello=World
 * @link http://shop-url.de/shop.php?do=SampleHttpRequest/HandlePostParameterCollection
 * @link http://shop-url.de/shop.php?do=SampleHttpRequest/HandleSpecificPostParameter
 */
class SampleHttpRequestController extends HttpViewController
{
	/**
	 * Sample method to demonstrate how to work with the query data collection.
	 * 
	 * The query collection is an instance of KeyValueCollection and hold all values
	 * from the global $_GET variable.
	 * 
	 * If you want to get a specific value by his key, use the ::_getQueryData($key) method.
	 *
	 * @see KeyValueCollection
	 * @see HttpViewController::_getQueryData
	 * @see HttpViewController::_getQueryDataCollection
	 *
	 * @return HttpControllerResponseInterface
	 */
	public function actionHandleGetParameterCollection()
	{
		$getCollection = $this->_getQueryParametersCollection();
		var_dump($getCollection);

		return new HttpControllerResponse('Response body, ' . implode(' - ', $getCollection->getArray()));
	}


	/**
	 * Sample method to demonstrate how to work with specific get parameter.
	 * 
	 * This method access to the key 'hello', which is equal to global $_GET['hello'].
	 * 
	 * Please execute the method with the request URL
	 * 'xx.de?do=SampleHttpRequestController/HandleSpecificGetParameter&hello=$yourValue'
	 *
	 * @see HttpViewController::_getQueryDataCollection
	 *
	 * @return HttpControllerResponseInterface
	 */
	public function actionHandleSpecificGetParameter()
	{
		$value = $this->_getQueryParameter('hello');
		var_dump($value);

		return new HttpControllerResponse('Response body, ' . $value);
	}


	/**
	 * Sample method to demonstrate how to work with the post data collection.
	 * 
	 * The post collection is an instance of KeyValueCollection and hold all values
	 * from the global $_POST variable.
	 * 
	 * If you want to get a specific value by his key, use the ::_getPostData($key) method.
	 *
	 * @see KeyValueCollection
	 * @see HttpViewController::_getPostData
	 * @see HttpViewController::_getPostDataCollection
	 *
	 * @return HttpControllerResponseInterface
	 */
	public function actionHandlePostParameterCollection()
	{
		$postCollection = $this->_getPostDataCollection();
		var_dump($postCollection);

		return new HttpControllerResponse('Response body, ' . implode(' - ', $postCollection->getArray()));
	}


	/**
	 * Sample method to demonstrate how to work with specific post parameter.
	 * 
	 * This method access to the key 'hello', which is equal to global $_POST['hello'].
	 * 
	 * Please execute the method with the request URL
	 * 'xx.de?do=SampleHttpRequestController/HandleSpecificPostParameter', and the 'POST' request method.
	 *
	 * @see HttpViewController::_getPostDataCollection
	 *
	 * @return HttpControllerResponseInterface
	 */
	public function actionHandleSpecificPostParameter()
	{
		$value = $this->_getPostData('hello');
		var_dump($value);

		return new HttpControllerResponse('Response body, ' . $value);
	}
}
