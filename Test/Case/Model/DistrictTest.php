<?php

App::uses('District', 'Data.Model');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

class DistrictTest extends MyCakeTestCase {

	public $District;

	public function setUp() {
		parent::setUp();

		$this->District = new District();
	}

	public function testObject() {
		$this->assertTrue(is_object($this->District));
		$this->assertInstanceOf('District', $this->District);
	}

	//TODO
}
