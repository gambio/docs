<?php
/* --------------------------------------------------------------
   CustomColumnOrdersOverviewController.inc.php.php 2016-05-30
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

/**
 * Class CustomColumnOrdersOverviewController
 *
 * This is a sample overload for the OrdersOverviewController.
 *
 * @see OrdersOverviewController
 */
class CustomColumnOrdersOverviewController extends CustomColumnOrdersOverviewController_parent
{
	/**
	 * Overloaded _getAssetsArray-Method.
	 *
	 * Append the assets-Array with your custom javascript, css or language-file.
	 * These assets will be loaded within the Orders-Overview-Page.
	 */
	protected function _getAssetsArray()
	{
		$assetsArray = parent::_getAssetsArray();
		$assetsArray[] = MainFactory::create('Asset', DIR_WS_CATALOG.'GXModules/MyName/MyModule/Shop/JavaScript/add_custom_column.js');
		
		return $assetsArray;
	}
}