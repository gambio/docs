<?php
/* --------------------------------------------------------------
   CustomColumnOrdersOverviewAjaxController.inc.php.php 2016-05-30
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

/**
 * Class CustomColumnOrdersOverviewAjaxController
 *
 * This is a sample overload for the OrdersOverviewAjaxController.
 *
 * @see OrdersOverviewAjaxController
 */
class CustomColumnOrdersOverviewAjaxController extends CustomColumnOrdersOverviewAjaxController_parent
{
	/**
	 * Overloaded _getTableData-Method.
	 * 
	 * Fetch the $tableData from the parent class and perform your own filtering, sorting or extend logic directly 
	 * in the result array.
	 */
	protected function _getTableData()
	{
		$tableData = parent::_getTableData();
		
		foreach($tableData as &$row) 
		{
			$row['customTest'] = 'Test Data'; 
		}
		
		return $tableData;
	}
}