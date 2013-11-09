<?php

App::uses('MimeType', 'Data.Model');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

class MimeTypeTest extends MyCakeTestCase {

	public $MimeType;

	public function setUp() {
		parent::setUp();

		$this->MimeType = new MimeType();
	}

	public function testObject() {
		$this->assertTrue(is_object($this->MimeType));
		$this->assertInstanceOf('MimeType', $this->MimeType);
	}

	//TODO
}
