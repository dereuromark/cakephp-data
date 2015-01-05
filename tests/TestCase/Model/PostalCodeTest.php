<?php

namespace Data\Test\TestCase\Model;

use Data\Model\PostalCode;
use Tools\TestSuite\TestCase;
class PostalCodeTest extends TestCase {

	public $fixtures = array(
		'plugin.data.postal_codes'
	);

	public $PostalCode;

	public function setUp() {
		parent::setUp();

		$this->PostalCode = ClassRegistry::init('Data.PostalCode');
	}

	public function testObject() {
		$this->assertTrue(is_object($this->PostalCode));
		$this->assertInstanceOf('PostalCode', $this->PostalCode);
	}

	//TODO
}
