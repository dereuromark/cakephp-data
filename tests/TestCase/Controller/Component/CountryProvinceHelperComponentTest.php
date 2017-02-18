<?php

namespace Data\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Data\Controller\Component\CountryStateHelperComponent;
use Tools\TestSuite\TestCase;

class CountryProvinceHelperComponentTest extends TestCase {

	/**
	 * @var array
	 */
	public $fixtures = ['plugin.data.countries', 'plugin.data.states'];

	/**
	 * @var \App\Controller\AppController
	 */
	public $Controller;

	/**
	 * @var \Data\Controller\Component\CountryStateHelperComponent
	 */
	public $CountryStateHelperComponent;

	/**
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->Controller = new Controller();
		$this->CountryStateHelperComponent = new CountryStateHelperComponent(new ComponentRegistry($this->Controller));
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
		$this->CountryStateHelperComponent->startup($event);
		$this->CountryStateHelperComponent->provideData();

		$viewVars = $this->Controller->viewVars;
		$this->assertNotEmpty($viewVars['countries']);
		$this->assertNotEmpty($viewVars['countryProvinces']);
	}

}
