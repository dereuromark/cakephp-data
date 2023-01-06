<?php

namespace Data\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * @uses \Data\Controller\CountriesController
 */
class CountriesControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * @var array
	 */
	protected array $fixtures = [
		'plugin.Data.Countries',
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
		$this->get(['plugin' => 'Data', 'controller' => 'Countries', 'action' => 'index']);
		$this->assertResponseCode(200);
	}

}
