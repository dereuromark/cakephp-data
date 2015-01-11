<?php

namespace Data\Test\TestCase\Model\Table;

use Data\Model\CountryProvince;
use Tools\TestSuite\TestCase;

class CountryProvincesTableTest extends TestCase {

	public $fixtures = array(
		'plugin.data.country_provinces'
	);

	public $CountryProvince;

	public function setUp() {
		parent::setUp();

		$this->CountryProvince = TableRegistry::get('Data.CountryProvince');
	}

	public function testObject() {
		$this->assertTrue(is_object($this->CountryProvince));
		$this->assertInstanceOf('CountryProvince', $this->CountryProvince);
	}

	//TODO
}
