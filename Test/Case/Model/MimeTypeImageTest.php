<?php

App::uses('MimeTypeImage', 'Data.Model');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

class MimeTypeImageTest extends MyCakeTestCase {

	public $MimeTypeImage;

	public function setUp() {
		parent::setUp();

		$this->MimeTypeImage = new MimeTypeImage();
	}

	public function testObject() {
		$this->assertTrue(is_object($this->MimeTypeImage));
		$this->assertInstanceOf('MimeTypeImage', $this->MimeTypeImage);
	}

	//TODO
}
