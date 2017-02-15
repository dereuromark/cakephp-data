<?php

namespace Data\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Data\Controller\Component\CountryProvinceHelperComponent;
use Tools\TestSuite\TestCase;

class CountryProvinceHelperComponentTest extends TestCase {

	/**
	 * @var array
	 */
	public $fixtures = ['plugin.data.countries', 'plugin.data.country_provinces'];

	/**
	 * @var \App\Controller\AppController
	 */
	public $Controller;

	/**
	 * @var \Data\Controller\Component\CountryProvinceHelperComponent
	 */
	public $CountryProvinceHelper;

	/**
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->Controller = new Controller();
		$this->CountryProvinceHelper = new CountryProvinceHelperComponent(new ComponentRegistry($this->Controller));
	}

	/**
	 * @return void
	 */
	public function tearDown() {
		parent::tearDown();
	}

	/**
	 * @return void
	 */
	public function testProvideData() {
		$event = new Event('Controller.startup', $this->Controller);
		$this->CountryProvinceHelper->startup($event);
		$this->CountryProvinceHelper->provideData();

		$viewVars = $this->Controller->viewVars;
		$this->assertNotEmpty($viewVars['countries']);
		$this->assertNotEmpty($viewVars['countryProvinces']);
	}

}
