<?php

App::uses('CountryProvince', 'Data.Model');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

class CountryProvinceTest extends MyCakeTestCase {

	public $CountryProvince;

	public function setUp() {
		parent::setUp();

		$this->CountryProvince = new CountryProvince();
	}

	public function testObject() {
		$this->assertTrue(is_object($this->CountryProvince));
		$this->assertInstanceOf('CountryProvince', $this->CountryProvince);
	}

	//TODO
}
