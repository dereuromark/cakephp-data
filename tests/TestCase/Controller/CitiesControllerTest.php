<?php
App::uses('CitiesController', 'Data.Controller');
App::uses('CakeRequest', 'Network');
App::uses('CakeResponse', 'Network');

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
		'plugin.data.city'
	);

	/**
	 * SetUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->CitiesController = new CitiesController(new CakeRequest, new CakeResponse);
	}

	public function testObject() {
		$this->assertTrue(is_object($this->CitiesController));
		$this->assertInstanceOf('CitiesController', $this->CitiesController);
	}

}
