<?php

namespace Data\Test\TestCase\Controller;

use Data\Controller\MimeTypesController;
use Tools\TestSuite\MyCakeTestCase;

class MimeTypesControllerTest extends MyCakeTestCase {

	public $MimeTypesController;

	public function setUp() {
		parent::setUp();

		$this->MimeTypesController = new MimeTypesController();
	}

	public function testObject() {
		$this->assertTrue(is_object($this->MimeTypesController));
		$this->assertInstanceOf('MimeTypesController', $this->MimeTypesController);
	}

	//TODO
}
