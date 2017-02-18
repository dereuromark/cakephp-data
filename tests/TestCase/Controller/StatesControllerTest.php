<?php

namespace Data\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\IntegrationTestCase;

/**
 */
class StatesControllerTest extends IntegrationTestCase {

	/**
	 * @var array
	 */
	public $fixtures = [
		'plugin.data.states',
		'plugin.data.Countries'
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
	public function testIndex() {
		$this->get(['plugin' => 'Data', 'controller' => 'States', 'action' => 'index']);
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testUpdateSelect() {
		$this->configRequest([
			'headers' => [
				'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest',
			],
		]);
		$_ENV['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';

		$this->post(['plugin' => 'Data', 'controller' => 'States', 'action' => 'updateSelect'], []);
		$this->assertResponseCode(200);

		//$content = $this->_response->body();
		$this->assertResponseContains('<option value="0">noOptionAvailable</option>');
	}

}
