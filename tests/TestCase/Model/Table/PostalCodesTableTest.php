<?php

namespace Data\Test\TestCase\Model\Table;

use Data\Model\PostalCode;
use Tools\TestSuite\TestCase;
class PostalCodesTableTest extends TestCase {

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
