<?php

App::uses('LanguagesController', 'Data.Controller');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

class LanguagesControllerTest extends MyCakeTestCase {

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
