<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\TestCase;

class CurrenciesTableTest extends TestCase {

	public $fixtures = array(
		'plugin.data.currencies'
	);

	public $Currencies;

	public function setUp() {
		parent::setUp();

		$this->Currencies = TableRegistry::get('Data.Currencies');
		$this->Currencies->CurrencyLib = $this->getMock('Data\Lib\CurrencyLib');
	}

	/**
	 *
	 * @return void
	 */
	public function testBasicFind() {
		$result = $this->Currencies->find()->first();
		$this->assertNotEmpty($result);
	}

	/**
	 *
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
