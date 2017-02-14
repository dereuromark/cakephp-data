<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\TestCase;

class CurrenciesTableTest extends TestCase {

	/**
	 * @var array
	 */
	public $fixtures = [
		'plugin.data.currencies'
	];

	/**
	 * @var \Data\Model\Table\CurrenciesTable
	 */
	public $Currencies;

	/**
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->Currencies = TableRegistry::get('Data.Currencies');
		$this->Currencies->CurrencyLib = $this->getMockBuilder('Data\Lib\CurrencyLib')->getMock();
	}

	/**
	 * @return void
	 */
	public function testBasicFind() {
		$result = $this->Currencies->find()->first();
		$this->assertNotEmpty($result);
	}

	/**
	 * @return void
	 */
	public function testBasicSave() {
		$data = [
			'EUR' => []
		];
		$this->Currencies->CurrencyLib->method('table')->willReturn($data);

		$data = [
			'name' => 'Euro',
			'code' => 'EUR'
		];
		$this->Currencies->deleteAll($data);

		$currency = $this->Currencies->newEntity($data);
		$this->assertEmpty($currency->errors());

		$result = $this->Currencies->save($currency);
		$this->assertNotEmpty($result);
	}

}
