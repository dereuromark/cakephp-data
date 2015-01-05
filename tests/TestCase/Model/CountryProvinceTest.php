<?php

namespace Data\Test\TestCase\Model;

use Data\Model\CountryProvince;
use Tools\TestSuite\TestCase;

class CountryProvinceTest extends TestCase {

	public $fixtures = array(
		'plugin.data.country_provinces'
	);

	public $CountryProvince;

	public function setUp() {
		parent::setUp();

		$this->CountryProvince = ClassRegistry::init('Data.CountryProvince');
	}

	public function testObject() {
		$this->assertTrue(is_object($this->CountryProvince));
		$this->assertInstanceOf('CountryProvince', $this->CountryProvince);
	}

	//TODO
}
