<?php

namespace Data\Test\TestCase\Controller;

use Data\Controller\CountryProvincesController;
use Tools\TestSuite\MyCakeTestCase;

class CountryProvincesControllerTest extends MyCakeTestCase {

	public $CountryProvincesController;

	public function setUp() {
		parent::setUp();

		$this->CountryProvincesController = new CountryProvincesController();
	}

	public function testObject() {
		$this->assertTrue(is_object($this->CountryProvincesController));
		$this->assertInstanceOf('CountryProvincesController', $this->CountryProvincesController);
	}

	//TODO
}
