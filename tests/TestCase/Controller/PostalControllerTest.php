<?php

namespace Data\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\IntegrationTestCase;

/**
 */
class PostalControllerTest extends IntegrationTestCase {

	/**
	 * @var array
	 */
	public $fixtures = [
		'plugin.data.postal_codes'
	];

	/**
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
	}

	/**
	 * @return void
	 */
	public function tearDown() {
		parent::tearDown();

		TableRegistry::clear();
	}

	/**
	 * @return void
	 */
	public function testMap() {
		$this->get(['plugin' => 'Data', 'controller' => 'PostalCodes', 'action' => 'map']);
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
