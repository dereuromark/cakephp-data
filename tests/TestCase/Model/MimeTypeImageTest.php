<?php

namespace Data\Test\TestCase\Model;
App::uses('MimeTypeImage', 'Data.Model');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

class MimeTypeImageTest extends MyCakeTestCase {

	public $fixtures = array('plugin.data.mime_type_image');

	public $MimeTypeImage;

	public function setUp() {
		parent::setUp();

		$this->MimeTypeImage = ClassRegistry::init('Data.MimeTypeImage');
	}

	public function testObject() {
		$this->assertTrue(is_object($this->MimeTypeImage));
		$this->assertInstanceOf('MimeTypeImage', $this->MimeTypeImage);
	}

	//TODO
}
