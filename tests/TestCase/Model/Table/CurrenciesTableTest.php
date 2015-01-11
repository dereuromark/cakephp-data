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
	}

	/**
	 *
	 * @return void
	 */
	public function testBasicFind() {
		$result = $this->Currencies->find()->first();
		$this->assertNotEmpty($result);
	}

}
