<?php
App::uses('PostalCodesController', 'Data.Controller');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

/**
 * PostalCodesController Test Case
 *
 */
class PostalCodesControllerTest extends MyCakeTestCase {

	public $PostalCodes;

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = array('plugin.data.postal_code');

	/**
	 * SetUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->PostalCodes = new PostalCodesController();
	}

	/**
	 * TearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->PostalCodes);

		parent::tearDown();
	}

	/**
	 * TestIndex method
	 *
	 * @return void
	 */
	public function testIndex() {
	}

	/**
	 * TestView method
	 *
	 * @return void
	 */
	public function testView() {
	}

	/**
	 * TestAdd method
	 *
	 * @return void
	 */
	public function testAdd() {
	}

	/**
	 * TestEdit method
	 *
	 * @return void
	 */
	public function testEdit() {
	}

	/**
	 * TestDelete method
	 *
	 * @return void
	 */
	public function testDelete() {
	}

	/**
	 * TestAdminIndex method
	 *
	 * @return void
	 */
	public function testAdminIndex() {
	}

	/**
	 * TestAdminView method
	 *
	 * @return void
	 */
	public function testAdminView() {
	}

	/**
	 * TestAdminAdd method
	 *
	 * @return void
	 */
	public function testAdminAdd() {
	}

	/**
	 * TestAdminEdit method
	 *
	 * @return void
	 */
	public function testAdminEdit() {
	}

	/**
	 * TestAdminDelete method
	 *
	 * @return void
	 */
	public function testAdminDelete() {
	}

}

/**
 * TestPostalCodesController *
 */
class TestPostalCodesController extends PostalCodesController {

	/**
	 * Auto render
	 *
	 * @var boolean
	 */
	public $autoRender = false;

	/**
	 * Redirect action
	 *
	 * @param mixed $url
	 * @param mixed $status
	 * @param boolean $exit
	 * @return void
	 */
	public function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}
