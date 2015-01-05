<?php

namespace Data\Test\TestCase\Model;

use Data\Model\Country;
use Tools\TestSuite\MyCakeTestCase;

class CountryTest extends MyCakeTestCase {

	public $fixtures = array(
		'plugin.data.countries'
	);

	public $Country;

	public function setUp() {
		parent::setUp();

		$this->Country = ClassRegistry::init('Data.Country');
	}

	public function testObject() {
		$this->assertTrue(is_object($this->Country));
		$this->assertInstanceOf('Country', $this->Country);
	}

	//TODO
}
