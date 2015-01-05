<?php
namespace Data\Test\TestCase\Controller;

use Cake\Network\Request;
use Cake\Network\Response;
use Data\Controller\CitiesController;

/**
 * CitiesController Test Case
 *
 */
class CitiesControllerTest extends ControllerTestCase {

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

		$this->CitiesController = new CitiesController(new Request, new Response);
	}

	public function testObject() {
		$this->assertTrue(is_object($this->CitiesController));
		$this->assertInstanceOf('CitiesController', $this->CitiesController);
	}

}
