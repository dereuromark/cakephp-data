<?php

App::uses('CurrenciesController', 'Data.Controller');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

class CurrenciesControllerTest extends MyCakeTestCase {

	public $CurrenciesController;

	public function setUp() {
		parent::setUp();

		$this->CurrenciesController = new CurrenciesController();
	}

	public function testObject() {
		$this->assertTrue(is_object($this->CurrenciesController));
		$this->assertInstanceOf('CurrenciesController', $this->CurrenciesController);
	}

	//TODO
}
