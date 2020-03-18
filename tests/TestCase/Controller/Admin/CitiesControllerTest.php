<?php

namespace Data\Test\TestCase\Controller\Admin;

use Cake\ORM\TableRegistry;
use Shim\TestSuite\IntegrationTestCase;

/**
 * @uses \Data\Controller\Admin\CitiesController
 */
class CitiesControllerTest extends IntegrationTestCase {

	/**
	 * @var array
	 */
	public $fixtures = [
		'plugin.Data.Cities',
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
		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'Cities', 'action' => 'index']);
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
