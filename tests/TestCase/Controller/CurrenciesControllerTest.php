<?php

namespace Data\Test\TestCase\Controller;

use Data\Controller\CurrenciesController;
use Tools\TestSuite\MyCakeTestCase;

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
