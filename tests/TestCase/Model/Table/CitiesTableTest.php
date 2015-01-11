<?php

namespace Data\Test\TestCase\Model\Table;

use Data\Model\City;
use Tools\TestSuite\TestCase;

class CitiesTableTest extends TestCase {

	public $fixtures = array(
		'plugin.data.cities'
	);

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
