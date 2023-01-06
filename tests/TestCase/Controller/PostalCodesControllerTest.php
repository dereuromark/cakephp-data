<?php

namespace Data\Test\TestCase\Controller;

use Cake\Database\Driver\Mysql;
use Cake\ORM\TableRegistry;

/**
 * @uses \Data\Controller\PostalCodesController
 */
class PostalCodesControllerTest extends TestCase {

	/**
	 * @var array
	 */
	protected array $fixtures = [
		'plugin.Data.PostalCodes',
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
	public function testMap() {
		$connectionConfig = TableRegistry::getTableLocator()->get('Data.PostalCodes')->getConnection()->config();
		$this->skipIf($connectionConfig['driver'] !== Mysql::class, 'Only for MySQL');

		$this->get(['plugin' => 'Data', 'controller' => 'PostalCodes', 'action' => 'map']);
		$this->assertResponseCode(200);
	}

}
