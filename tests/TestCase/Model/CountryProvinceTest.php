<?php

namespace Data\Test\TestCase\Model;

App::uses('CountryProvince', 'Data.Model');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

class CountryProvinceTest extends MyCakeTestCase {

	public $fixtures = array('plugin.data.country_province');

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
