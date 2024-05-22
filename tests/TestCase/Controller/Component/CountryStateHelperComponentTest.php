<?php

namespace Data\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Http\ServerRequest;
use Data\Controller\Component\CountryStateHelperComponent;
use Shim\TestSuite\TestCase;

class CountryStateHelperComponentTest extends TestCase {

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.Data.Countries',
		'plugin.Data.States',
	];

	/**
	 * @var \App\Controller\AppController
	 */
	protected $Controller;

	/**
	 * @var \Data\Controller\Component\CountryStateHelperComponent
	 */
	protected $CountryStateHelperComponent;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->Controller = new Controller(new ServerRequest());
		$this->CountryStateHelperComponent = new CountryStateHelperComponent(new ComponentRegistry($this->Controller));
	}

	/**
	 * @return void
	 */
	public function testProvideData() {
		$event = new Event('Controller.startup', $this->Controller);
		$this->CountryStateHelperComponent->startup($event);
		$this->CountryStateHelperComponent->provideData();

		$viewVars = $this->Controller->viewBuilder()->getVars();
		$this->assertNotEmpty($viewVars['countries']);
		$this->assertNotEmpty($viewVars['states']);
	}

}
