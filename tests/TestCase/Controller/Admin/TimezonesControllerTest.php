<?php
declare(strict_types = 1);

namespace Data\Test\TestCase\Controller\Admin;

use Cake\Database\Driver\Postgres;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * @uses \Data\Controller\Admin\TimezonesController
 */
class TimezonesControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.Data.Timezones',
		'plugin.Data.Countries',
	];

	/**
	 * @return void
	 */
	public function testIndex(): void {
		$connectionConfig = $this->getTableLocator()->get('Data.Timezones')->getConnection()->config();
		$this->skipIf($connectionConfig['driver'] === Postgres::class, 'Does not work for postgres right now');

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
	public function testLink(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'Timezones', 'action' => 'link']);
		$this->assertResponseCode(200);
	}

	/**
	 * @return void
	 */
	public function testView(): void {
		$connectionConfig = $this->getTableLocator()->get('Data.Timezones')->getConnection()->config();
		$this->skipIf($connectionConfig['driver'] === Postgres::class, 'Does not work for postgres right now');

		$this->disableErrorHandlerMiddleware();

		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'Timezones', 'action' => 'view', 1]);
		$this->assertResponseCode(200);
	}

	/**
	 * @return void
	 */
	public function testAdd(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'Timezones', 'action' => 'add']);
		$this->assertResponseCode(200);
	}

	/**
	 * @return void
	 */
	public function testEdit(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'Timezones', 'action' => 'edit', 1]);
		$this->assertResponseCode(200);
	}

	/**
	 * @return void
	 */
	public function testDelete(): void {
		$this->disableErrorHandlerMiddleware();

		$this->post(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'Timezones', 'action' => 'delete', 1]);
		$this->assertResponseCode(302);
	}

}
