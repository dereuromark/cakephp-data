<?php

App::uses('AddressesController', 'Data.Controller');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

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
