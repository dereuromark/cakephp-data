<?php

namespace Data\Test\TestCase\Controller;

use Data\Controller\CurrenciesController;
use Tools\TestSuite\TestCase;

class CurrenciesControllerTest extends TestCase {

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
