<?php

/* --------------------------------------------------------------
   CustomActionsOrdersOverviewController.inc.php 2016-06-09
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

/**
 * Class CustomActionsOrdersOverviewController
 *
 * This is a sample overload for the OrdersOverviewController.
 *
 * @see OrdersOverviewController
 */
class CustomActionsOrdersOverviewController extends CustomActionsOrdersOverviewController_parent
{
	/**
	 * Override the parent and add the custom javascript files.
	 *
	 * @return array
	 */
	protected function _getAssetsArray()
	{
		$assets = parent::_getAssetsArray();
		
		$assets[] = MainFactory::create('Asset', DIR_WS_CATALOG . 'GXModules/MyName/MyModule/Shop/JavaScript/add_custom_bulk_action.js');
		$assets[] = MainFactory::create('Asset', DIR_WS_CATALOG . 'GXModules/MyName/MyModule/Shop/JavaScript/add_custom_row_action.js');
		
		return $assets;
	}
}