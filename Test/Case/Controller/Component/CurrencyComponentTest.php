<?php
App::uses('CurrencyComponent', 'Data.Controller/Component');
App::uses('Controller', 'Controller');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

/**
 * Short description for class.
 */
class CurrencyComponentTest extends CakeTestCase {

	/**
	 * SetUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->skipIf(true, 'deprecated');

		$this->Controller = new CurrencyTestController();
		$this->Controller->Currency = new CurrencyComponent(new ComponentCollection());
	}

	/**
	 * Tear-down method. Resets environment state.
	 *
	 * @return void
	 */
	public function tearDown() {
		parent::tearDown();

		unset($this->Controller->Currency);
		unset($this->Controller->Component);
		unset($this->Controller);
	}

	public function testStartReset() {
		$this->Controller->Currency->reset();
	}

	/**
	 * test
	 */
	public function testConvert() {
		echo '<h2>30 EUR in USD</h2>';
		$is = $this->Controller->Currency->convert(30, 'EUR', 'USD');
		pr($is);
		$this->assertTrue($is > 30 && $is < 60);

		$this->assertFalse($this->Controller->Currency->cacheFileUsed());
	}

	public function testIsAvailable() {
		$is = $this->Controller->Currency->isAvailable('EUR');
		$this->assertTrue($is);

		$is = $this->Controller->Currency->isAvailable('XYZ');
		$this->assertFalse($is);
	}

	public function testTable() {
		echo '<h2>Currency Table</h2>';
		$is = $this->Controller->Currency->table();
		pr($is);
		$this->assertTrue(is_array($is) && !empty($is));

		$is = $this->Controller->Currency->table('XYZ');
		$this->assertFalse($is);

		$this->assertTrue($this->Controller->Currency->cacheFileUsed());
	}

	public function testReset() {
		$res = $this->Controller->Currency->reset();
		$this->assertTrue($res === null || $res === true);
	}

}

/**
 * Short description for class.
 *
 */
class TestCurrencyComponent extends CurrencyComponent {

}

/**
 * Short description for class.
 *
 */
class CurrencyTestController extends Controller {

	/**
	 * Components property
	 *
	 * @var array
	 */
	public $components = array('TestCurrency');

	/**
	 * Failed property
	 *
	 * @var boolean
	 */
	public $failed = false;

	/**
	 * Used for keeping track of headers in test
	 *
	 * @var array
	 */
	public $testHeaders = array();

	/**
	 * Fail method
	 *
	 * @return void
	 */
	public function fail() {
		$this->failed = true;
	}

	/**
	 * Redirect method
	 *
	 * @param mixed $option
	 * @param mixed $code
	 * @param mixed $exit
	 * @return void
	 */
	public function redirect($url, $status = null, $exit = true) {
		return $status;
	}

	/**
	 * Conveinence method for header()
	 *
	 * @param string $status
	 * @return void
	 */
	public function header($status) {
		$this->testHeaders[] = $status;
	}
}
