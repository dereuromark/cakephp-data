<?php

namespace Data\Test\TestCase\Controller\Admin;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Data\Controller\Admin\AddressesController;
use PHPUnit\Framework\Attributes\UsesClass;

#[UsesClass(AddressesController::class)]
class AddressesControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.Data.Addresses',
	];

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->loadPlugins(['Data', 'Tools']);
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
