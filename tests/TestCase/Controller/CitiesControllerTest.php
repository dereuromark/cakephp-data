<?php
namespace Data\Test\TestCase\Controller;

use Cake\Network\Request;
use Cake\Network\Response;
use Data\Controller\CitiesController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * CitiesController Test Case
 *
 */
class CitiesControllerTest extends IntegrationTestCase {

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = array(
		'plugin.data.cities'
	);

	/**
	 * SetUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		//$this->CitiesController = new CitiesController(new Request, new Response);
	}

	public function testIndex() {
		$this->get(array('plugin' => 'Data', 'controller' => 'Cities', 'prefix' => 'admin', 'action' => 'index'));
		$this->assertResponseCode(200);
	}

}
