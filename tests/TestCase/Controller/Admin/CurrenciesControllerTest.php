<?php

namespace Data\Test\TestCase\Controller\Admin;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * @uses \Data\Controller\Admin\CurrenciesController
 */
class CurrenciesControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.Data.Currencies',
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
		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'Currencies', 'action' => 'index']);
		$this->assertResponseCode(200);
	}

	/**
	 * @return void
	 */
	public function testView() {
		$this->disableErrorHandlerMiddleware();

		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'Currencies', 'action' => 'view', 1]);
		$this->assertResponseCode(200);
	}

}
