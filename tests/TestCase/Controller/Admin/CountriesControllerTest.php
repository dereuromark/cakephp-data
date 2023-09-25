<?php

namespace Data\Test\TestCase\Controller\Admin;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * @uses \Data\Controller\Admin\CountriesController
 */
class CountriesControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * @var array
	 */
	protected array $fixtures = [
		'plugin.Data.Countries',
		'plugin.Data.Timezones',
	];

	/**
	 * @return void
	 */
	public function tearDown(): void {
		parent::tearDown();

		//TableRegistry::clear();
	}

	/**
	 * @return void
	 */
	public function testIndex() {
		$this->disableErrorHandlerMiddleware();

		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'Countries', 'action' => 'index']);
		$this->assertResponseCode(200);
	}

	/**
	 * @return void
	 */
	public function testSync(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'Countries', 'action' => 'sync']);
		$this->assertResponseCode(200);
	}

	/**
	 * @return void
	 */
	public function testView() {
		$this->disableErrorHandlerMiddleware();

		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'Countries', 'action' => 'view', 1]);
		$this->assertResponseCode(200);
	}

}
