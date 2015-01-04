<?php

App::uses('PostalCode', 'Data.Model');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

class PostalCodeTest extends MyCakeTestCase {

	public $fixtures = array('plugin.data.postal_code');

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
