<?php
/* --------------------------------------------------------------
   CustomColumnOrdersOverviewColumns.inc.php.php 2016-05-30
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

/**
 * Class CustomColumnOrdersOverviewColumns
 *
 * This is a sample overload for the OrdersOverviewColumns.
 *
 * @see OrdersOverviewColumns
 */
class CustomColumnOrdersOverviewColumns extends CustomColumnOrdersOverviewColumns_parent
{
	/**
	 * Overloaded constructor.
	 *
	 * By calling the parent constructor we set the original column definitions and extend the
	 * table with a new column.
	 */
	public function __construct()
	{
		parent::__construct();
		
		// Custom
		$this->columns[] = MainFactory::create('DataTableColumn')
		                              ->setTitle(new StringType('Test'))
		                              ->setName(new StringType('customTest'))
		                              ->setType(new DataTableColumnType(DataTableColumnType::STRING));
	}
}