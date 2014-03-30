<?php

App::uses('CountriesController', 'Data.Controller');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

class CountriesControllerTest extends MyCakeTestCase {

	public $CountriesController;

	public function setUp() {
		parent::setUp();

		$this->CountriesController = new CountriesController();
	}

	public function testObject() {
		$this->assertTrue(is_object($this->CountriesController));
		$this->assertInstanceOf('CountriesController', $this->CountriesController);
	}

	//TODO
}
