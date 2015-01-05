<?php

namespace Data\Test\TestCase\Model;

use Data\Model\Address;
use Tools\TestSuite\MyCakeTestCase;

class AddressTest extends MyCakeTestCase {

	public $fixtures = array(
		'plugin.data.addresses'
	);

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
