<?php
declare(strict_types = 1);

namespace Data\Test\TestCase\Controller\Admin;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * @uses \Data\Controller\Admin\TimezonesController
 */
class TimezonesControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * @var string[]
	 */
	protected $fixtures = [
		'plugin.Data.Timezones',
	];

	/**
	 * @return void
	 */
	public function testIndex(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'Timezones', 'action' => 'index']);
		$this->assertResponseCode(200);
	}

	/**
	 * @return void
	 */
	public function testSync(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'Timezones', 'action' => 'sync']);
		$this->assertResponseCode(200);
	}

	/**
	 * @return void
	 */
	public function testView(): void {
		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'Timezones', 'action' => 'view', 1]);
		$this->assertResponseCode(200);
	}

	/**
	 * @return void
	 */
	public function testAdd(): void {
		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'Timezones', 'action' => 'add']);
		$this->assertResponseCode(200);
	}

	/**
	 * @return void
	 */
	public function testEdit(): void {
		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'Timezones', 'action' => 'edit', 1]);
		$this->assertResponseCode(200);
	}

	/**
	 * @return void
	 */
	public function testDelete(): void {
		$this->post(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'Timezones', 'action' => 'delete', 1]);
		$this->assertResponseCode(302);
	}

}
