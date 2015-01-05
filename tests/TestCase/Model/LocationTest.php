<?php

namespace Data\Test\TestCase\Model;

use Data\Model\Location;
use Tools\TestSuite\TestCase;
class LocationTest extends TestCase {

	public $fixtures = array(
		'plugin.data.locations'
	);

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
