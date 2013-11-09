<?php

App::uses('Country', 'Data.Model');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

class CountryTest extends MyCakeTestCase {

	public $fixtures = array('plugin.data.country');

	public $Country;

	public function setUp() {
		parent::setUp();

		$this->Country = ClassRegistry::init('Data.Country');
	}

	public function testObject() {
		$this->assertTrue(is_object($this->Country));
		$this->assertInstanceOf('Country', $this->Country);
	}

	//TODO
}
