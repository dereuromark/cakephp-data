<?php
declare(strict_types = 1);

namespace Data\Test\TestCase\Controller\Admin;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * @uses \Data\Controller\Admin\MimeTypesController
 */
class MimeTypesControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.Data.MimeTypes',
		'plugin.Data.MimeTypeImages',
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
	public function testIndex(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'MimeTypes', 'action' => 'index']);
		$this->assertResponseCode(200);
	}

	/**
	 * @return void
	 */
	public function testView(): void {
		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'MimeTypes', 'action' => 'view', 1]);
		$this->assertResponseCode(200);
	}

	/**
	 * @return void
	 */
	public function testAdd(): void {
		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'MimeTypes', 'action' => 'add']);
		$this->assertResponseCode(200);
	}

	/**
	 * @return void
	 */
	public function testEdit(): void {
		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'MimeTypes', 'action' => 'edit', 1]);
		$this->assertResponseCode(200);
	}

	/**
	 * @return void
	 */
	public function testDelete(): void {
		$this->post(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'MimeTypes', 'action' => 'delete', 1]);
		$this->assertResponseCode(302);
	}

}
