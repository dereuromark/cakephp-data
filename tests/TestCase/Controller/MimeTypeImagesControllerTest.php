<?php

namespace Data\Test\TestCase\Controller;

use Data\Controller\MimeTypeImagesController;
use Tools\TestSuite\TestCase;

class MimeTypeImagesControllerTest extends TestCase {

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