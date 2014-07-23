<?php

App::uses('Location', 'Data.Model');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

class LocationTest extends MyCakeTestCase {

	public $fixtures = array('plugin.data.location');

	public $Location;

	public function setUp() {
		parent::setUp();

		$this->Location = ClassRegistry::init('Data.Location');
	}

	public function testObject() {
		$this->assertTrue(is_object($this->Location));
		$this->assertInstanceOf('Location', $this->Location);
	}

	//TODO
}
