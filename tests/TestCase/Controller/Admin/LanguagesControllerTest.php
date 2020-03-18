<?php

namespace Data\Test\TestCase\Controller\Admin;

use Cake\ORM\TableRegistry;
use Shim\TestSuite\IntegrationTestCase;

/**
 * @uses \Data\Controller\Admin\LanguagesController
 */
class LanguagesControllerTest extends IntegrationTestCase {

	/**
	 * @var array
	 */
	public $fixtures = [
		'plugin.Data.Languages',
	];

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();
	}

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

		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'Languages', 'action' => 'index']);
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
