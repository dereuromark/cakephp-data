<?php

App::uses('MimeTypeImagesController', 'Data.Controller');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

class MimeTypeImagesControllerTest extends MyCakeTestCase {

	public $MimeTypeImagesController;

	public function setUp() {
		parent::setUp();

		$this->MimeTypeImagesController = new MimeTypeImagesController();
	}

	public function testObject() {
		$this->assertTrue(is_object($this->MimeTypeImagesController));
		$this->assertInstanceOf('MimeTypeImagesController', $this->MimeTypeImagesController);
	}

	//TODO
}
