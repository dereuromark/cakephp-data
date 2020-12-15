<?php

namespace Data\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Shim\TestSuite\IntegrationTestCase;

/**
 * @uses \Data\Controller\ContinentsController
 */
class ContinentsControllerTest extends IntegrationTestCase {

	/**
	 * @var array
	 */
	protected $fixtures = [
		'plugin.Data.Continents',
	];

	/**
	 * @return void
	 */
	public function tearDown(): void {
		parent::tearDown();

		TableRegistry::clear();
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
