<?php

App::uses('Continent', 'Data.Model');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

class ContinentTest extends MyCakeTestCase {

	public $fixtures = array('plugin.data.continent');

	public $Continent;

	public function setUp() {
		parent::setUp();

		$this->Continent = ClassRegistry::init('Data.Continent');
	}

	public function testObject() {
		$this->assertTrue(is_object($this->Continent));
		$this->assertInstanceOf('Continent', $this->Continent);
	}

	//TODO
}
