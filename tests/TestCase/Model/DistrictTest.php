<?php

namespace Data\Test\TestCase\Model;

use Data\Model\District;
use Tools\TestSuite\MyCakeTestCase;

class DistrictTest extends MyCakeTestCase {

	public $fixtures = array('plugin.data.district');

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
