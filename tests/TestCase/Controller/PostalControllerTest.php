<?php

namespace Data\Test\TestCase\Controller;

use Cake\Database\Driver\Mysql;
use Cake\ORM\TableRegistry;
use Tools\TestSuite\IntegrationTestCase;

class PostalControllerTest extends IntegrationTestCase {

	/**
	 * @var array
	 */
	public $fixtures = [
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
		$connectionConfig = TableRegistry::get('Data.PostalCodes')->connection()->config();
		$this->skipIf($connectionConfig['driver'] !== Mysql::class, 'Only for MySQL');

		$this->get(['plugin' => 'Data', 'controller' => 'PostalCodes', 'action' => 'map']);
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
