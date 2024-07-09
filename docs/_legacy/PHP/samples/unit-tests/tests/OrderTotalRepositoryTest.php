<?php

/* --------------------------------------------------------------
   OrderTotalRepositoryTest.php 2015-12-23
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2015 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

require_once __DIR__ . '/../../tests.bootstrap.inc.php';
require_once __DIR__ . '/includes/OrderMockFactory.inc.php';

class OrderTotalRepositoryTest extends GxTestCase
{
	/**
	 * @var OrderTotalRepository
	 */
	protected $repository;
	
	/**
	 * @var OrderMockFactory
	 */
	protected $mockFactory;
	
	/**
	 * @var OrderTotalRepositoryReader
	 */
	protected $reader;
	
	/**
	 * @var OrderTotalRepositoryWriter
	 */
	protected $writer;
	
	/**
	 * @var OrderTotalRepositoryDeleter
	 */
	protected $deleter;
	
	
	public function setUp()
	{
		$this->mockFactory = new OrderMockFactory($this);
		$this->reader      = $this->mockFactory->create('OrderTotalRepositoryReader');
		$this->writer      = $this->mockFactory->create('OrderTotalRepositoryWriter');
		$this->deleter     = $this->mockFactory->create('OrderTotalRepositoryDeleter');
		
		$this->repository = new OrderTotalRepository($this->reader, $this->writer, $this->deleter);
	}
	
	
	// ------------------------------------------------------------------------
	// TEST ADD TO ORDER METHOD
	// ------------------------------------------------------------------------
	
	public function testAddToOrderMethodReturnsOrderTotalIdAsInteger()
	{
		$orderTotal = $this->mockFactory->create('OrderTotal');
		$orderId    = $this->mockFactory->create('IdType');
		
		$this->writer->method('insertIntoOrder')->willReturn(1);
		
		$this->assertTrue(is_int($this->repository->addToOrder($orderId, $orderTotal)));
	}
	
	
	public function testAddToOrderMethodDelegatesToOrderTotalRepositoryWriter()
	{
		$orderTotal = $this->mockFactory->create('OrderTotal');
		$orderId    = $this->mockFactory->create('IdType', 1);
		
		$this->writer->expects($this->once())
		             ->method('insertIntoOrder')
		             ->with($this->equalTo($orderId), $this->equalTo($orderTotal));
		
		$this->repository->addToOrder($orderId, $orderTotal);
	}
	
	
	/**
	 * @dataProvider newOrderTotalIdsDataProvider
	 *
	 * @param $orderTotalId
	 */
	public function testAddToOrderMethodReturnsExpectedOrderTotalId($orderTotalId)
	{
		$orderTotal = $this->mockFactory->create('OrderTotal');
		$orderId    = $this->mockFactory->create('IdType', 1);
		
		$this->writer->method('insertIntoOrder')->willReturn($orderTotalId);
		
		$this->assertEquals($orderTotalId, $this->repository->addToOrder($orderId, $orderTotal));
	}
	
	
	// ------------------------------------------------------------------------
	// TEST STORE METHOD
	// ------------------------------------------------------------------------
	
	public function testStoreOrderTotalMethodReturnSameOrderTotalRepositoryInstance()
	{
		$storedOrderTotal = $this->mockFactory->create('StoredOrderTotal');
		
		$this->assertSame($this->repository, $this->repository->store($storedOrderTotal));
	}
	
	
	public function testStoreOrderTotalWillDelegateToUpdateMethodOfOrderTotalRepositoryWriter()
	{
		$storedOrderTotal = $this->mockFactory->create('StoredOrderTotal');
		$this->writer->expects($this->once())->method('update')->with($this->equalTo($storedOrderTotal));
		
		$this->repository->store($storedOrderTotal);
	}
	
	
	// ------------------------------------------------------------------------
	// TEST GET TOTAL BY ID METHOD
	// ------------------------------------------------------------------------
	
	public function testGetTotalByIdMethodReturnsAStoredOrderTotalInstance()
	{
		$storedOrderTotalId = $this->mockFactory->create('IdType', 1);
		$storedOrderTotal   = $this->mockFactory->create('StoredOrderTotal');
		
		$this->reader->method('getTotalById')->willReturn($storedOrderTotal);
		
		$this->assertInstanceOf('StoredOrderTotal', $this->repository->getTotalById($storedOrderTotalId));
	}
	
	
	public function testGetTotalByIdMethodDelegatesToOrderTotalRepositoryReader()
	{
		$storedOrderTotalId = $this->mockFactory->create('IdType', 1);
		$this->reader->expects($this->once())->method('getTotalById')->with($this->equalTo($storedOrderTotalId));
		
		$this->repository->getTotalById($storedOrderTotalId);
	}
	
	
	public function testGetTotalByIdMethodReturnsExpectedOrderTotalInstance()
	{
		$storedOrderTotalId = $this->mockFactory->create('IdType', 1);
		$storedOrderTotal   = $this->mockFactory->create('StoredOrderTotal');
		
		$this->reader->method('getTotalById')->willReturn($storedOrderTotal);
		
		$this->assertSame($storedOrderTotal, $this->repository->getTotalById($storedOrderTotalId));
	}
	
	
	// ------------------------------------------------------------------------
	// TEST GET TOTALS BY ORDER ID METHOD
	// ------------------------------------------------------------------------
	
	public function testGetTotalsByOrderIdMethodReturnsAStoredOrderTotalCollection()
	{
		$orderId                    = $this->mockFactory->create('IdType', 1);
		$storedOrderTotalCollection = $this->mockFactory->create('StoredOrderTotalCollection');
		
		$this->reader->method('getTotalsByOrderId')->willReturn($storedOrderTotalCollection);
		
		$this->assertInstanceOf('StoredOrderTotalCollection', $this->repository->getTotalsByOrderId($orderId));
	}
	
	
	public function testGetTotalsByOrderIdMethodDelegatesToOrderTotalRepositoryReader()
	{
		$orderId = $this->mockFactory->create('IdType', 1);
		$this->reader->expects($this->once())->method('getTotalsByOrderId')->with($this->equalTo($orderId));
		
		$this->repository->getTotalsByOrderId($orderId);
	}
	
	
	public function testGetTotalsByOrderIdMethodReturnsExpectedStoredOrderTotalCollectionInstance()
	{
		$orderId                    = $this->mockFactory->create('IdType', 1);
		$storedOrderTotalCollection = $this->mockFactory->create('StoredOrderTotalCollection');
		
		$this->reader->method('getTotalsByOrderId')->willReturn($storedOrderTotalCollection);
		
		$this->assertSame($storedOrderTotalCollection, $this->repository->getTotalsByOrderId($orderId));
	}
	
	
	// ------------------------------------------------------------------------
	// TEST DELETE TOTAL BY ID METHOD
	// ------------------------------------------------------------------------
	
	public function testDeleteTotalByIdMethodReturnsSameOrderTotalRepositoryInstance()
	{
		$storedOrderTotalId = $this->mockFactory->create('IdType', 1);
		
		$this->assertSame($this->repository, $this->repository->deleteTotalById($storedOrderTotalId));
	}
	
	
	public function testDeleteTotalByIdMethodDelegatesToOrderTotalRepositoryDeleter()
	{
		$storedOrderTotalId = $this->mockFactory->create('IdType', 1);
		$this->deleter->expects($this->once())->method('deleteTotalById')->with($this->equalTo($storedOrderTotalId));
		
		$this->repository->deleteTotalById($storedOrderTotalId);
	}
	
	
	public function testDeleteTotalsByOrderIdMethodReturnsSameOrderTotalRepositoryInstance()
	{
		$orderId = $this->mockFactory->create('IdType', 1);
		
		$this->assertSame($this->repository, $this->repository->deleteTotalsByOrderId($orderId));
	}
	
	
	// ------------------------------------------------------------------------
	// TEST DELETE TOTALS BY ORDER ID METHOD
	// ------------------------------------------------------------------------
	
	public function testDeleteTotalsByOrderIdMethodDelegatesToOrderTotalRepositoryDeleter()
	{
		$orderId = $this->mockFactory->create('IdType', 1);
		$this->deleter->expects($this->once())->method('deleteTotalsByOrderId')->with($this->equalTo($orderId));
		
		$this->repository->deleteTotalsByOrderId($orderId);
	}
	
	
	// ------------------------------------------------------------------------
	// TEST DATA PROVIDER METHOD
	// ------------------------------------------------------------------------
	
	public function newOrderTotalIdsDataProvider()
	{
		return array(array(1), array(5));
	}
}
