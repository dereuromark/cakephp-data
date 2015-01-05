<?php

namespace Data\Test\TestCase\Controller;

use Data\Controller\ContinentsController;
use Tools\TestSuite\TestCase;

class ContinentsControllerTest extends TestCase {

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
