<?php

namespace Data\Test\TestCase\Controller;

use Data\Controller\ContinentsController;
use Tools\TestSuite\MyCakeTestCase;

class ContinentsControllerTest extends MyCakeTestCase {

	public $ContinentsController;

	public function setUp() {
		parent::setUp();

		$this->ContinentsController = new ContinentsController();
	}

	public function testObject() {
		$this->assertTrue(is_object($this->ContinentsController));
		$this->assertInstanceOf('ContinentsController', $this->ContinentsController);
	}

	//TODO
}
