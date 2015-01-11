<?php

namespace Data\Test\TestCase\Model\Table;

use Data\Model\Location;
use Tools\TestSuite\TestCase;
class LocationsTableTest extends TestCase {

	public $fixtures = array(
		'plugin.data.locations'
	);

	public $Location;

	public function setUp() {
		parent::setUp();

		$this->Location = TableRegistry::get('Data.Location');
	}

	public function testObject() {
		$this->assertTrue(is_object($this->Location));
		$this->assertInstanceOf('Location', $this->Location);
	}

	//TODO
}
