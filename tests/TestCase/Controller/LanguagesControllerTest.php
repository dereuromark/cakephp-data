<?php

namespace Data\Test\TestCase\Controller;

use Data\Controller\LanguagesController;
use Tools\TestSuite\TestCase;

class LanguagesControllerTest extends TestCase {

	public $LanguagesController;

	public function setUp() {
		parent::setUp();

		$this->LanguagesController = new LanguagesController();
	}

	public function testObject() {
		$this->assertTrue(is_object($this->LanguagesController));
		$this->assertInstanceOf('LanguagesController', $this->LanguagesController);
	}

	//TODO
}
