<?php

App::uses('PostalCode', 'Data.Model');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

class PostalCodeTest extends MyCakeTestCase {

	public $PostalCode;

	public function setUp() {
		parent::setUp();

		$this->PostalCode = new PostalCode();
	}

	public function testObject() {
		$this->assertTrue(is_object($this->PostalCode));
		$this->assertInstanceOf('PostalCode', $this->PostalCode);
	}

	//TODO
}
