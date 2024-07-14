<?php

/* --------------------------------------------------------------
   OrderTotalRepositoryDeleterTest.php 2016-10-24
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

require_once __DIR__ . '/../../tests.bootstrap.inc.php';
require_once __DIR__ . '/includes/OrderMockFactory.inc.php';
require_once __DIR__ . '/includes/OrderDatabaseTestCase.inc.php';

class OrderTotalRepositoryDeleterTest extends OrderDatabaseTestCase
{
	/**
	 * @var OrderTotalRepositoryDeleter
	 */
	protected $deleter;
	
	/**
	 * @var OrderMockFactory
	 */
	protected $mockFactory;
	
	/**
	 * @var CI_DB_query_builder
	 */
	protected $db;
	
	
	/**
	 * Get DataSet
	 *
	 * @return PHPUnit_Extensions_Database_DataSet_MysqlXmlDataSet
	 */
	public function getDataSet()
	{
		return $this->createMySQLXMLDataSet(__DIR__ . '/fixtures/OrdersDataSet.xml');
	}
	
	
	/**
	 * Test Setup
	 *
	 * Force the database connection of the shop system (required).
	 */
	public function setUp()
	{
		parent::setUp(); // Trigger the initial OrderTotalRepositoryDataSet.xml import.
		$this->db          = self::getCiDbQueryBuilder();
		$this->deleter     = new OrderTotalRepositoryDeleter($this->db);
		$this->mockFactory = new OrderMockFactory($this);
	}
	
	
	/**
	 * Setup Before Class
	 *
	 * Export database state.
	 */
	public static function setUpBeforeClass()
	{
		self::exportDatabase(__DIR__ . '/backup.sql', [
			'orders',
			'orders_parcel_tracking_codes',
			'orders_products',
			'orders_products_attributes',
			'orders_products_download',
			'orders_products_properties',
			'orders_products_quantity_units',
			'orders_recalculate',
			'orders_status',
			'orders_status_history',
			'orders_tax_sum_items',
			'orders_total',
			'addon_values_storage'
		]);
	}
	
	
	/**
	 * Tear Down After Class
	 *
	 * Import initial database state.
	 */
	public static function tearDownAfterClass()
	{
		self::importDatabase(__DIR__ . '/backup.sql', true);
	}
	
	
	public function testDeleterInitializeCorrectly()
	{
		$this->assertInstanceOf('OrderTotalRepositoryDeleter', $this->deleter);
	}
	
	
	// ------------------------------------------------------------------------
	// TEST DELETE TOTAL BY ID METHOD
	// ------------------------------------------------------------------------
	
	public function testDeleteTotalByIdMethodRemovesExpectedEntry()
	{
		$orderTotalId = $this->mockFactory->create('IdType', '1');
		$this->deleter->deleteTotalById($orderTotalId);
		
		// Assert deletion
		$expectedDataSet = $this->createMySQLXMLDataSet(__DIR__
		                                                . '/fixtures/OrderTotalRepositoryDeleterOrderTotal.xml');
		$actualDataSet   = $this->getConnection()->createDataSet(self::$exportedTables);
		$this->assertDataSetsEqual($expectedDataSet, $actualDataSet, 'New entry was not removed!');
	}
	
	
	public function testDeleteTotalByIdMethodReturnsSameInstance()
	{
		$orderTotalId = $this->mockFactory->create('IdType');
		$this->assertSame($this->deleter, $this->deleter->deleteTotalById($orderTotalId));
	}
	
	// ------------------------------------------------------------------------
	// TEST DELETE TOTALS BY ORDER ID METHOD
	// ------------------------------------------------------------------------
	
	public function testDeleteTotalsByOrderIdMethodRemoveExpectedEntry()
	{
		$orderId = $this->mockFactory->create('IdType', '400211');
		$this->deleter->deleteTotalsByOrderId($orderId);
		
		// Assert deletion
		$expectedDataSet = $this->createMySQLXMLDataSet(__DIR__ . '/fixtures/OrderTotalRepositoryDeleterOrder.xml');
		$actualDataSet   = $this->getConnection()->createDataSet(self::$exportedTables);
		$this->assertDataSetsEqual($expectedDataSet, $actualDataSet, 'New entry was not removed!');
	}
	
	
	public function testDeleteTotalsByOrderIdMethodReturnSameInstance()
	{
		$orderId = $this->mockFactory->create('IdType', '400211');
		$this->assertSame($this->deleter, $this->deleter->deleteTotalsByOrderId($orderId));
	}
}
