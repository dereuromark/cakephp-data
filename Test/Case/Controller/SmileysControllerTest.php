<?php

App::uses('SmileysController', 'Data.Controller');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

class SmileysControllerTest extends MyCakeTestCase {

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
