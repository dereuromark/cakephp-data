<?php

namespace Data\Test\TestCase\Model\Table;

use Data\Model\Currency;
use Tools\TestSuite\TestCase;

class CurrenciesTableTest extends TestCase {

	public $fixtures = array(
		'plugin.data.currencies'
	);

	public $Currency;

	public function setUp() {
		parent::setUp();

		$this->Currency = ClassRegistry::init('Data.Currency');
	}

	public function testObject() {
		$this->assertTrue(is_object($this->Currency));
		$this->assertInstanceOf('Currency', $this->Currency);
	}

	//TODO
}
