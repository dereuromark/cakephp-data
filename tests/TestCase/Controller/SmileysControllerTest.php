<?php

namespace Data\Test\TestCase\Controller;

use Data\Controller\SmileysController;
use Tools\TestSuite\TestCase;

class SmileysControllerTest extends TestCase {

	public $SmileysController;

	public function setUp() {
		parent::setUp();

		$this->SmileysController = new SmileysController();
	}

	public function testObject() {
		$this->assertTrue(is_object($this->SmileysController));
		$this->assertInstanceOf('SmileysController', $this->SmileysController);
	}

	//TODO
}
