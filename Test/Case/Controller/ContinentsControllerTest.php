<?php

App::uses('ContinentsController', 'Data.Controller');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

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
