<?php

namespace Data\Test\TestCase\Controller;

use Data\Controller\AddressesController;
use Tools\TestSuite\MyCakeTestCase;

class AddressesControllerTest extends MyCakeTestCase {

	public $AddressesController;

	public function setUp() {
		parent::setUp();

		$this->AddressesController = new AddressesController();
	}

	public function testObject() {
		$this->assertTrue(is_object($this->AddressesController));
		$this->assertInstanceOf('AddressesController', $this->AddressesController);
	}

	//TODO
}
