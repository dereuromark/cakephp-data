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
		$this->assertNotNull($result);
		$this->assertIsFloat($result);
		$this->assertGreaterThan(999, $result);
	}

	/**
	 * Decimal precision must round-trip; coingecko returns floats like 95871.42 and
	 * the previous int-typed return silently truncated the fractional part.
	 *
	 * @return void
	 */
	public function testCoingeckoPreservesDecimalPrecision() {
		if ($this->isDebug()) {
			$this->markTestSkipped('Live mode: cannot pin a deterministic float for assertion.');
		}
		$this->CurrencyBitcoin->expects($this->once())
			->method('_get')
			->willReturn(file_get_contents($this->path . 'coingecko.json'));

		$result = $this->CurrencyBitcoin->coingecko();
		$this->assertSame(95871.42, $result);
	}

	/**
	 * Network failure path: _get() returns null and coingecko() must propagate null.
	 *
	 * @return void
	 */
	public function testCoingeckoReturnsNullOnNetworkFailure() {
		if ($this->isDebug()) {
			$this->markTestSkipped('Live mode skips the failure injection.');
		}
		$this->CurrencyBitcoin->expects($this->once())
			->method('_get')
			->willReturn(null);

		$this->assertNull($this->CurrencyBitcoin->coingecko());
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
