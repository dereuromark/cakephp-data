<?php

namespace Data\Test\TestCase\Controller;

use Cake\Database\Driver\Mysql;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * @uses \Data\Controller\PostalCodesController
 */
class PostalCodesControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.Data.PostalCodes',
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
	public function testMap() {
		$this->disableErrorHandlerMiddleware();

		$connectionConfig = TableRegistry::getTableLocator()->get('Data.PostalCodes')->getConnection()->config();
		$this->skipIf($connectionConfig['driver'] !== Mysql::class, 'Only for MySQL');

		$this->get(['plugin' => 'Data', 'controller' => 'PostalCodes', 'action' => 'map']);
		$this->assertResponseCode(200);
	}

}
