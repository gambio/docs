<?php

/* --------------------------------------------------------------
   ProductAttributeTest.php 2016-01-07
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2015 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

require_once __DIR__ . '/../../tests.bootstrap.inc.php';
require_once __DIR__ . '/../../tests-framework/Traits/AccessorTestTrait.inc.php'; 

class ProductAttributeTest extends GxTestCase
{
	use AccessorTestTrait;

	/**
	 * @var ProductAttribute
	 */
	protected $productAttribute;

	/**
	 * @var MockFactory
	 */
	protected $mockFactory;


	public function setUp()
	{
		$this->mockFactory = new MockFactory($this);

		$optionId = $this->mockFactory->create('IdType', mt_rand(1, 10));
		$valueId  = $this->mockFactory->create('IdType', mt_rand(1, 10));

		$this->productAttribute = new ProductAttribute($optionId, $valueId);
		$this->setUpAccessorTestTrait($this, $this->productAttribute, $this->mockFactory);
	}


	/**
	 * @dataProvider constructorValuesGetterDataProvider
	 *
	 * @param int              $expectedOptionId
	 * @param int              $expectedValueId
	 * @param ProductAttribute $productAttributeInstance
	 */
	public function testGetterOfConstructorValues($expectedOptionId, $expectedValueId, $productAttributeInstance)
	{
		$this->assertEquals($expectedOptionId, $productAttributeInstance->getOptionId());
		$this->assertEquals($expectedValueId, $productAttributeInstance->getOptionValueId());
	}


	public function testOptionAccessor()
	{
		$this->assertScalarAccessor('optionId', 'id', mt_rand(1, 10))
		     ->assertScalarAccessor('optionValueId', 'id', mt_rand(1, 10));
	}


	public function testPriceAccessor()
	{
		$price = (string)mt_rand(1, 10) . '.' . mt_rand(1, 99);
		$price = (float)$price;
		$this->assertScalarAccessor('price', 'float', $price)->assertScalarAccessor('priceType', 'string', 'someType');
	}


	public function testWeightAccessor()
	{
		$weight = (string)mt_rand(1, 10) . '.' . mt_rand(1, 99);
		$weight = (float)$weight;
		$this->assertScalarAccessor('weight', 'float', $weight)
		     ->assertScalarAccessor('weightType', 'string', 'someType');
	}


	public function testAttributeAccessor()
	{
		$this->assertScalarAccessor('attributeModel', 'string', 'someModel')
		     ->assertScalarAccessor('attributeEan', 'string', 'someEan');
	}


	public function testStockAccessor()
	{
		$stock = (string)mt_rand(1, 10) . '.' . mt_rand(1, 99);
		$stock = (float)$stock;
		$this->assertScalarAccessor('stock', 'float', $stock);
	}


	public function testSortOrderAccessor()
	{
		$this->assertScalarAccessor('sortOrder', 'int', mt_rand(1, 10));
	}


	public function testVpeAccessor()
	{
		$vpeValue = (string)mt_rand(1, 10) . '.' . mt_rand(1, 99);
		$vpeValue = (float)$vpeValue;
		$this->assertScalarAccessor('vpeId', 'id', mt_rand(1, 10))
		     ->assertScalarAccessor('vpeValue', 'float', $vpeValue);
	}


	public function constructorValuesGetterDataProvider()
	{
		$mockFactory = new MockFactory($this);

		return [
			[1, 2, new ProductAttribute($mockFactory->create('IdType', 1), $mockFactory->create('IdType', 2))],
			[3, 4, new ProductAttribute($mockFactory->create('IdType', 3), $mockFactory->create('IdType', 4))],
			[5, 6, new ProductAttribute($mockFactory->create('IdType', 5), $mockFactory->create('IdType', 6))],
			[7, 8, new ProductAttribute($mockFactory->create('IdType', 7), $mockFactory->create('IdType', 8))],
			[9, 10, new ProductAttribute($mockFactory->create('IdType', 9), $mockFactory->create('IdType', 10))],
		];
	}
}
