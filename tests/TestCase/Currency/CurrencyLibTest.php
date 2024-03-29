<?php

namespace Data\Test\TestCase\Currency;

use Shim\TestSuite\TestCase;
use TestApp\Lib\TestCurrencyLib;

class CurrencyLibTest extends TestCase {

	/**
	 * @var \Data\Currency\CurrencyLib|\PHPUnit\Framework\MockObject\MockObject
	 */
	protected $CurrencyLib;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->CurrencyLib = new TestCurrencyLib();
	}

	/**
	 * @return void
	 */
	public function testConvert() {
		//$this->out('<h2>30 EUR in USD</h2>', true);
		$is = $this->CurrencyLib->convert(30, 'EUR', 'USD');
		//$this->debug($is);
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
		$result = $this->CurrencyLib->reset();
		$this->assertTrue($result);
	}

}
