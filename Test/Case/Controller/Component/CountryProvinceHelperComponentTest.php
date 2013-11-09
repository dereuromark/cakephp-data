<?php

App::uses('CountryProvinceHelperComponent', 'Data.Controller/Component');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

class CountryProvinceHelperComponentTest extends MyCakeTestCase {

	public function setUp() {
		parent::setUp();

		$this->CountryProvinceHelper = new CountryProvinceHelperComponent(new ComponentCollection());
	}

	public function tearDown() {
		parent::tearDown();
	}

	public function testObject() {
		$this->assertInstanceOf('CountryProvinceHelperComponent', $this->CountryProvinceHelper);
	}

	public function testX() {
		//TODO
	}

}
