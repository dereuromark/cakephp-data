<?php

namespace Data\Test\TestCase\Controller;

use Data\Controller\MimeTypesController;
use Tools\TestSuite\TestCase;

class MimeTypesControllerTest extends TestCase {

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
