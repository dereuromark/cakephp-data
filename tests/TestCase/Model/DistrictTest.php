<?php

namespace Data\Test\TestCase\Model;

use Data\Model\District;
use Tools\TestSuite\TestCase;

class DistrictTest extends TestCase {

	public $fixtures = array(
		'plugin.data.districts'
	);

	public $District;

	public function setUp() {
		parent::setUp();

		$this->District = ClassRegistry::init('Data.District');
	}

	public function testObject() {
		$this->assertTrue(is_object($this->District));
		$this->assertInstanceOf('District', $this->District);
	}

}
