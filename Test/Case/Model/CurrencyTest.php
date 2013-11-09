<?php

App::uses('Currency', 'Data.Model');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

class CurrencyTest extends MyCakeTestCase {

	public $Currency;

	public function setUp() {
		parent::setUp();

		$this->Currency = new Currency();
	}

	public function testObject() {
		$this->assertTrue(is_object($this->Currency));
		$this->assertInstanceOf('Currency', $this->Currency);
	}

	//TODO
}
