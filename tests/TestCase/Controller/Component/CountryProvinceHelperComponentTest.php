<?php

namespace Data\Test\TestCase\Controller\Component;

use Data\Controller\Component\CountryProvinceHelperComponent;
use Tools\TestSuite\MyCakeTestCase;

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
