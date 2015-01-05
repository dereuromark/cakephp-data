<?php

namespace Data\Test\TestCase\Model;

use Data\Model\State;
use Tools\TestSuite\TestCase;

class StateTest extends TestCase {

	public $fixtures = array(
		'plugin.data.states'
	);

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
