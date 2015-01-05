<?php

namespace Data\Test\TestCase\Model;

use Data\Model\MimeType;
use Tools\TestSuite\TestCase;
class MimeTypeTest extends TestCase {

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
