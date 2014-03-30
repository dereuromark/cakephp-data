<?php

App::uses('MimeTypesController', 'Data.Controller');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

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
