<?php

namespace Data\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * @uses \Data\Controller\ContinentsController
 */
class ContinentsControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * @var array
	 */
	protected array $fixtures = [
		'plugin.Data.Continents',
	];

	/**
	 * @return void
	 */
	public function tearDown(): void {
		parent::tearDown();

		//TableRegistry::getTableLocator()->clear();
	}

	/**
	 * @return void
	 */
	public function testIndex() {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Data', 'controller' => 'Continents', 'action' => 'index']);
		$this->assertResponseCode(200);
	}

}
