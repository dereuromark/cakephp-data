<?php

namespace Data\Test\TestCase\Controller;

use Cake\Database\Driver\Mysql;
use Cake\ORM\TableRegistry;
use Shim\TestSuite\IntegrationTestCase;

/**
 * @uses \Data\Controller\PostalCodesController
 */
class PostalCodesControllerTest extends IntegrationTestCase {

	/**
	 * @var array
	 */
	protected $fixtures = [
		'plugin.Data.PostalCodes',
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
	public function testMap() {
		$connectionConfig = TableRegistry::get('Data.PostalCodes')->getConnection()->config();
		$this->skipIf($connectionConfig['driver'] !== Mysql::class, 'Only for MySQL');

		$this->get(['plugin' => 'Data', 'controller' => 'PostalCodes', 'action' => 'map']);
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
