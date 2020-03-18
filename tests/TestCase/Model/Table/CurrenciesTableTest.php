<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Data\Lib\CurrencyLib;
use Shim\TestSuite\TestCase;

class CurrenciesTableTest extends TestCase {

	/**
	 * @var array
	 */
	public $fixtures = [
		'plugin.Data.Currencies',
	];

	/**
	 * @var \Data\Model\Table\CurrenciesTable
	 */
	protected $Currencies;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->Currencies = TableRegistry::get('Data.Currencies');
		$this->Currencies->CurrencyLib = $this->getMockBuilder(CurrencyLib::class)->getMock();
	}

	/**
	 * @return void
	 */
	public function tearDown(): void {
		parent::tearDown();

		TableRegistry::clear();
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
			'EUR' => [],
		];
		$this->Currencies->CurrencyLib->method('table')->willReturn($data);

		$data = [
			'name' => 'Euro',
			'code' => 'EUR',
		];
		$this->Currencies->deleteAll($data);

		$currency = $this->Currencies->newEntity($data);
		$this->assertEmpty($currency->getErrors(), print_r($currency->getErrors(), true));

		$result = $this->Currencies->save($currency);
		$this->assertNotEmpty($result, print_r($currency->getErrors(), true));
	}

	/**
	 * @return void
	 */
	public function testBeforeMarshal() {
		$data = [
			'USD' => [],
		];
		$this->Currencies->CurrencyLib->method('table')->willReturn($data);

		$this->Currencies->truncate();

		$data = [
			'name' => 'Dollar',
			'code' => 'usd',
		];
		$currency = $this->Currencies->newEntity($data);
		$result = $this->Currencies->save($currency);
		$this->assertNotEmpty($result, print_r($currency->getErrors(), true));

		$this->assertSame('USD', $result->code);

		$currency = $this->Currencies->newEntity($data);
		$result = $this->Currencies->save($currency);
		$this->assertFalse($result);
	}

}
