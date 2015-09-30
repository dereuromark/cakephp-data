<?php

namespace Data\Test\TestCase\Controller\Component;

use Data\Controller\Component\CountryProvinceHelperComponent;
use Tools\TestSuite\TestCase;
use Cake\Controller\ComponentRegistry;
use Cake\Event\Event;
use Cake\Controller\Controller;

class CountryProvinceHelperComponentTest extends TestCase {

	public $fixtures = ['plugin.data.countries', 'plugin.data.country_provinces'];

	public function setUp() {
		parent::setUp();

		$this->Controller = new Controller();
		$this->CountryProvinceHelper = new CountryProvinceHelperComponent(new ComponentRegistry($this->Controller));
	}

	public function tearDown() {
		parent::tearDown();
	}

	/**
	 * CountryProvinceHelperComponentTest::testProvideData()
	 *
	 * @return void
	 */
	public function testProvideData() {
		$event = new Event('Controller.startup', $this->Controller);
		$this->CountryProvinceHelper->startup($event);
		$result = $this->CountryProvinceHelper->provideData();
		//debug($result);
	}

}
