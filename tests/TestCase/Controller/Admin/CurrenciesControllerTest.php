<?php

namespace Data\Test\TestCase\Controller\Admin;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\IntegrationTestCase;

/**
 * @uses \Data\Controller\Admin\CurrenciesController
 */
class CurrenciesControllerTest extends IntegrationTestCase {

	/**
	 * @var array
	 */
	public $fixtures = [
		'plugin.Data.Currencies',
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
		$this->get(['prefix' => 'admin', 'plugin' => 'Data', 'controller' => 'Currencies', 'action' => 'index']);
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
