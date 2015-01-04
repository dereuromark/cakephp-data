<?php

namespace Data\Test\TestCase\Model;

App::uses('Currency', 'Data.Model');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

class CurrencyTest extends MyCakeTestCase {

	public $fixtures = array('plugin.data.currency');

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
