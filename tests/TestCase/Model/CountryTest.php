<?php

namespace Data\Test\TestCase\Model;

use Data\Model\Country;
use Tools\TestSuite\TestCase;

class CountryTest extends TestCase {

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
