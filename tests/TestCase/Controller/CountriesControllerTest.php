<?php

namespace Data\Test\TestCase\Controller;

use Data\Controller\CountriesController;
use Tools\TestSuite\TestCase;

class CountriesControllerTest extends TestCase {

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
