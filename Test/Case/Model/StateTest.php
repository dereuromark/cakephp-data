<?php

App::uses('State', 'Data.Model');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

class StateTest extends MyCakeTestCase {

	public $fixtures = array('plugin.data.state');

	public $State;

	public function setUp() {
		parent::setUp();

		$this->State = ClassRegistry::init('Data.State');
	}

	public function testObject() {
		$this->assertTrue(is_object($this->State));
		$this->assertInstanceOf('State', $this->State);
	}

	//TODO
}
