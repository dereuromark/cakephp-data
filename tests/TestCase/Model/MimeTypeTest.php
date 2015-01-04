<?php

namespace Data\Test\TestCase\Model;
App::uses('MimeType', 'Data.Model');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

class MimeTypeTest extends MyCakeTestCase {

	public $MimeType;

	public function setUp() {
		parent::setUp();

		$this->MimeType = ClassRegistry::init('Data.MimeType');
	}

	public function testObject() {
		$this->assertTrue(is_object($this->MimeType));
		$this->assertInstanceOf('MimeType', $this->MimeType);
	}

	//TODO
}
