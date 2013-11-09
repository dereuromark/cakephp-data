<?php

App::uses('City', 'Data.Model');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

class CityTest extends MyCakeTestCase {

	public $fixtures = array('plugin.data.city');

	public $City;

	public function setUp() {
		parent::setUp();

		$this->City = ClassRegistry::init('Data.City');
	}

	public function testObject() {
		$this->assertTrue(is_object($this->City));
		$this->assertInstanceOf('City', $this->City);
	}

	//TODO
}
