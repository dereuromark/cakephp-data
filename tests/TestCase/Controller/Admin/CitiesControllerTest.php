<?php

namespace Data\Test\TestCase\Controller\Admin;

use Cake\ORM\TableRegistry;

/**
 * @uses \Data\Controller\Admin\CitiesController
 */
class CitiesControllerTest extends TestCase {

	/**
	 * @var array
	 */
	protected array $fixtures = [
		'plugin.Data.Cities',
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
		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'Cities', 'action' => 'index']);
		$this->assertResponseCode(200);
	}

}
