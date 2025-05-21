<?php

namespace Data\Test\TestCase\Currency;

use Cake\Core\Plugin;
use Data\Currency\CurrencyBitcoinLib;
use Shim\TestSuite\TestCase;

class CurrencyBitcoinLibTest extends TestCase {

	/**
	 * @var \Data\Currency\CurrencyBitcoinLib|\PHPUnit\Framework\MockObject\MockObject
	 */
	protected $CurrencyBitcoin;

	/**
	 * @var string
	 */
	protected $path;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		if ($this->isDebug()) {
			$this->CurrencyBitcoin = new CurrencyBitcoinLib();

			return;
		}

		$this->CurrencyBitcoin = $this->getMockBuilder('Data\Currency\CurrencyBitcoinLib')->onlyMethods(['_get'])->getMock();
		$this->path = Plugin::path('Data') . 'tests' . DS . 'test_files' . DS . 'json' . DS;
	}

	/**
	 * @return void
	 */
	public function testCoingecko() {
		if (!$this->isDebug()) {
			$this->CurrencyBitcoin->expects($this->once())
				->method('_get')
				->with('https://api.coingecko.com/api/v3/simple/price?ids=bitcoin&vs_currencies=eur')
				->willReturn(file_get_contents($this->path . 'coingecko.json'));
		}
		$result = $this->CurrencyBitcoin->coingecko();
		$this->assertTrue($result !== null && $result > 999);
	}

	/**
	 * @return void
	 */
	public function testRatio() {
		$is = $this->CurrencyBitcoin->ratio(95871);
		$this->assertTrue(is_numeric($is) && $is > 0 && $is < 1);

		$is = $this->CurrencyBitcoin->convert(42.32, 95871); // EUR
		// 0.00044142...
		$this->assertTrue(is_numeric($is) && $is > 0 && $is < 1);
	}

}
