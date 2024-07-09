<?php

/* --------------------------------------------------------------
   OrderTotalRepositoryReaderTest.php 2016-10-24
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

class OrderTotalRepositoryReaderTest extends OrderDatabaseTestCase
{
	/**
	 * @var CI_DB_query_builder
	 */
	protected $db;
	
	/**
	 * @var OrderMockFactory
	 */
	protected $mockFactory;
	
	/**
	 * @var OrderTotalFactory
	 */
	protected $orderTotalFactory;
	
	/**
	 * @var OrderTotalRepositoryReader
	 */
	protected $orderTotalRepositoryReader;
	
	
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
	 * Tests Setup
	 */
	public function setUp()
	{
		parent::setUp(); // Trigger DataSet loading. 
		$this->db = self::getCiDbQueryBuilder();
		
		$this->mockFactory = new OrderMockFactory($this);
		
		$this->orderTotalFactory = $this->mockFactory->create('OrderTotalFactory');
		
		$this->orderTotalRepositoryReader = new OrderTotalRepositoryReader($this->db, $this->orderTotalFactory);
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
	
	
	public function testGetTotalByIdMethodReturnsAStoredOrderTotalReader()
	{
		$orderTotalId     = $this->mockFactory->create('IdType', 4);
		$storedOrderTotal = $this->mockFactory->create('StoredOrderTotal');
		
		$this->orderTotalFactory->method('createStoredOrderTotal')->willReturn($storedOrderTotal);
		
		$this->assertInstanceOf('StoredOrderTotalInterface',
		                        $this->orderTotalRepositoryReader->getTotalById($orderTotalId));
	}
	
	
	public function testGetTotalByIdMethodThrowsAnUnexpectedValueExceptionIfNoOrderTotalResultWasFoundWithGivenOrderTotalId()
	{
		$this->expectException('UnexpectedValueException');
		
		$orderTotalId = $this->mockFactory->create('IdType', 1111);
		
		$this->orderTotalRepositoryReader->getTotalById($orderTotalId);
	}
	
	
	public function testGetTotalByIdMethodCallsExpectedSetterMethodsWithExpectedValuesOnStoredOrderTotalInstance()
	{
		$orderTotalId     = $this->mockFactory->create('IdType', 4);
		$storedOrderTotal = $this->mockFactory->create('StoredOrderTotal');
		
		$storedOrderTotal->expects($this->once())
		                 ->method('setTitle')
		                 ->with($this->equalTo(new StringType('inkl. 19% MwSt.:')));
		$storedOrderTotal->expects($this->once())
		                 ->method('setValueText')
		                 ->with($this->equalTo(new StringType('7,98 EUR')));
		$storedOrderTotal->expects($this->once())->method('setValue')->with($this->equalTo(new DecimalType(7.9800)));
		$storedOrderTotal->expects($this->once())->method('setClass')->with($this->equalTo(new StringType('ot_tax')));
		$storedOrderTotal->expects($this->once())->method('setSortOrder')->with($this->equalTo(new IntType(97)));
		
		$this->orderTotalFactory->method('createStoredOrderTotal')->willReturn($storedOrderTotal);
		
		$this->orderTotalRepositoryReader->getTotalById($orderTotalId);
	}
	
	
	public function testGetTotalsByOrderIdMethodReturnsAStoredOrderTotalCollection()
	{
		$orderId          = $this->mockFactory->create('IdType', 400210);
		$storedOrderTotal = $this->mockFactory->create('StoredOrderTotal');
		
		$this->orderTotalFactory->method('createStoredOrderTotal')->willReturn($storedOrderTotal);
		
		$this->assertInstanceOf('StoredOrderTotalCollection',
		                        $this->orderTotalRepositoryReader->getTotalsByOrderId($orderId));
	}
	
	
	public function testGetTotalsByOrderIdMethodReturnsAStoredOrderTotalCollectionWithExpectedAmountOfItems()
	{
		$orderId          = $this->mockFactory->create('IdType', 400210);
		$storedOrderTotal = $this->mockFactory->create('StoredOrderTotal');
		
		$this->orderTotalFactory->method('createStoredOrderTotal')->willReturn($storedOrderTotal);
		
		$orderTotalsCollection = $this->orderTotalRepositoryReader->getTotalsByOrderId($orderId);
		$this->assertTrue($orderTotalsCollection->count() == 6);
	}
	
	
	public function testGetTotalsByOrderIdMethodReturnsAStoredOrderTotalCollectionWithExpectedItems()
	{
		$orderId          = $this->mockFactory->create('IdType', 400210);
		$storedOrderTotal = $this->mockFactory->create('StoredOrderTotal');
		
		$this->orderTotalFactory->method('createStoredOrderTotal')->willReturn($storedOrderTotal);
		
		$this->orderTotalFactory->expects($this->at(0))
		                        ->method('createStoredOrderTotal')
		                        ->with($this->equalTo(new IdType(1)));
		$this->orderTotalFactory->expects($this->at(1))
		                        ->method('createStoredOrderTotal')
		                        ->with($this->equalTo(new IdType(2)));
		$this->orderTotalFactory->expects($this->at(2))
		                        ->method('createStoredOrderTotal')
		                        ->with($this->equalTo(new IdType(3)));
		$this->orderTotalFactory->expects($this->at(3))
		                        ->method('createStoredOrderTotal')
		                        ->with($this->equalTo(new IdType(4)));
		$this->orderTotalFactory->expects($this->at(4))
		                        ->method('createStoredOrderTotal')
		                        ->with($this->equalTo(new IdType(5)));
		$this->orderTotalFactory->expects($this->at(5))
		                        ->method('createStoredOrderTotal')
		                        ->with($this->equalTo(new IdType(6)));
		
		$this->orderTotalRepositoryReader->getTotalsByOrderId($orderId);
	}
}