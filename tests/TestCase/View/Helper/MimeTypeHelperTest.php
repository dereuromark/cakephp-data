<?php

App::uses('MimeTypeHelper', 'Data.View/Helper');
App::uses('MyCakeTestCase', 'Tools.TestSuite');
App::uses('View', 'View');

class MimeTypeHelperTest extends MyCakeTestCase {

	public $MimeTypeHelper;

	public function setUp() {
		parent::setUp();

		$this->MimeTypeHelper = new MimeTypeHelper(new View(null));
	}

	public function testObject() {
		$this->assertTrue(is_object($this->MimeTypeHelper));
		$this->assertInstanceOf('MimeTypeHelper', $this->MimeTypeHelper);
	}

	//TODO
}
