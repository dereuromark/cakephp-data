<?php

App::uses('County', 'Data.Model');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

class CountyTest extends MyCakeTestCase {

	public $fixtures = array('plugin.data.county');

	public $County;

	public function setUp() {
		parent::setUp();

		$this->County = ClassRegistry::init('Data.County');
	}

	public function testObject() {
		$this->assertTrue(is_object($this->County));
		$this->assertInstanceOf('County', $this->County);
	}

	//TODO
}
