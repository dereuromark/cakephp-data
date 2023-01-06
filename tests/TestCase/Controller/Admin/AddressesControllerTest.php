<?php

namespace Data\Test\TestCase\Controller\Admin;

use Cake\ORM\TableRegistry;

/**
 * @uses \Data\Controller\Admin\AddressesController
 */
class AddressesControllerTest extends TestCase {

	/**
	 * @var array
	 */
	protected array $fixtures = [
		'plugin.Data.Addresses',
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

		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'Addresses', 'action' => 'index']);
		$this->assertResponseCode(200);
	}

}
