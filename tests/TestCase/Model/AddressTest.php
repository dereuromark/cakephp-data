<?php

App::uses('Address', 'Data.Model');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

class AddressTest extends MyCakeTestCase {

	public $fixtures = array('plugin.data.address');

	public $Address;

	public function setUp() {
		parent::setUp();

		$this->Address = ClassRegistry::init('Data.Address');
	}

	public function testObject() {
		$this->assertTrue(is_object($this->Address));
		$this->assertInstanceOf('Address', $this->Address);
	}

	//TODO
}
