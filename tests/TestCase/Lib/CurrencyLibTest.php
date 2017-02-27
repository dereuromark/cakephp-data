<?php
namespace Data\Test\TestCase\Lib;

use Cake\Core\Plugin;
use Data\Lib\CurrencyLib;
use Tools\TestSuite\TestCase;

class CurrencyLibTest extends TestCase {

	/**
	 * @var \Data\Lib\CurrencyLib|\PHPUnit_Framework_MockObject_MockObject
	 */
	protected $CurrencyLib;

	/**
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->CurrencyLib = new TestCurrencyLib();
	}

	/**
	 * @return void
	 */
	public function testStartReset() {
		$this->CurrencyLib->reset();
	}

	/**
	 * @return void
	 */
	public function testConvert() {
		//$this->out('<h2>30 EUR in USD</h2>', true);
		$is = $this->CurrencyLib->convert(30, 'EUR', 'USD');
		$this->debug($is);
		$this->assertTrue($is > 30 && $is < 60);

		$this->assertFalse($this->CurrencyLib->cacheFileUsed());
	}

	/**
	 * @return void
	 */
	public function testIsAvailable() {
		$is = $this->CurrencyLib->isAvailable('EUR');
		$this->assertTrue($is);

		$is = $this->CurrencyLib->isAvailable('XYZ');
		$this->assertFalse($is);
	}

	/**
	 * @return void
	 */
	public function testTable() {
		$is = $this->CurrencyLib->table();
		$this->assertTrue(is_array($is) && !empty($is));

		$is = $this->CurrencyLib->table('XYZ');
		$this->assertNull($is);

		$this->assertTrue($this->CurrencyLib->cacheFileUsed());
	}

	/**
	 * @return void
	 */
	public function testHistory() {
		$is = $this->CurrencyLib->history();
		$this->assertTrue(is_array($is) && !empty($is));
	}

	/**
	 * @return void
	 */
	public function testReset() {
		$this->CurrencyLib->reset();
	}

}

class TestCurrencyLib extends CurrencyLib {

	protected function _getBitcoin() {
		if (!empty($_SERVER['argv']) && in_array('--debug', $_SERVER['argv'], true)) {
			debug('Live Data!');
			return parent::_getBitcoin();
		}
		// Fake for now
		return 55;
	}

	protected function _loadXml($url) {
		if (!empty($_SERVER['argv']) && in_array('--debug', $_SERVER['argv'], true)) {
			debug('Live Data!');
			return parent::_loadXml($url);
		}

		$file = basename($url);
		$url = Plugin::path('Data') . 'tests' . DS . 'test_files' . DS . 'xml' . DS . $file;
		return parent::_loadXml($url);
	}

}
