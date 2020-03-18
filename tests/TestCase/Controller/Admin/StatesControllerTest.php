<?php

namespace Data\Test\TestCase\Controller\Admin;

use Cake\ORM\TableRegistry;
use Shim\TestSuite\IntegrationTestCase;

/**
 * @uses \Data\Controller\Admin\StatesController
 */
class StatesControllerTest extends IntegrationTestCase {

	/**
	 * @var array
	 */
	public $fixtures = [
		'plugin.Data.Countries',
		'plugin.Data.States',
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
		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'States', 'action' => 'index']);
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
