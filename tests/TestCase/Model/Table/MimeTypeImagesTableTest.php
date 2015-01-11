<?php

namespace Data\Test\TestCase\Model\Table;

use Data\Model\MimeTypeImage;
use Tools\TestSuite\TestCase;
class MimeTypeImagesTableTest extends TestCase {

	public $fixtures = array(
		'plugin.data.mime_type_images'
	);

	public $MimeTypeImage;

	public function setUp() {
		parent::setUp();

		$this->MimeTypeImage = TableRegistry::get('Data.MimeTypeImage');
	}

	public function testObject() {
		$this->assertTrue(is_object($this->MimeTypeImage));
		$this->assertInstanceOf('MimeTypeImage', $this->MimeTypeImage);
	}

	//TODO
}
