<?php

namespace Data\Test\TestCase\Lib;

use Cake\Core\Plugin;
use Data\Lib\CurrencyBitcoinLib;
use Shim\TestSuite\TestCase;

class CurrencyBitcoinLibTest extends TestCase {

	/**
	 * @var \Data\Lib\CurrencyBitcoinLib|\PHPUnit\Framework\MockObject\MockObject
	 */
	protected $CurrencyBitcoin;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		if ($this->isDebug()) {
			$this->CurrencyBitcoin = new CurrencyBitcoinLib();
			return;
		}

		$this->CurrencyBitcoin = $this->getMockBuilder('Data\Lib\CurrencyBitcoinLib')->setMethods(['_get'])->getMock();
		$this->path = Plugin::path('Data') . 'tests' . DS . 'test_files' . DS . 'json' . DS;
	}

	/**
	 * @return void
	 */
	public function testBitmarket() {
		if (!$this->isDebug()) {
			$this->CurrencyBitcoin->expects($this->once())
				->method('_get')
				->with('https://bitmarket.eu/api/ticker')
				->will($this->returnValue(file_get_contents($this->path . 'bitmarket.json')));
		}
		$is = $this->CurrencyBitcoin->bitmarket();
		//debug($is);
		$this->assertTrue(!empty($is['last']));
	}

	/**
	 * @return void
	 */
	public function testBitcoincharts() {
		if (!$this->isDebug()) {
			$this->CurrencyBitcoin->expects($this->once())
				->method('_get')
				->with('http://api.bitcoincharts.com/v1/markets.json')
				->will($this->returnValue(file_get_contents($this->path . 'bitcoincharts.json')));
		}
		$is = $this->CurrencyBitcoin->bitcoincharts();
		//debug($is);
		$this->assertTrue(!empty($is['close']));
	}

	/**
	 * @return void
	 */
	public function testRate() {
		$this->skipIf(true, 'TODO!');

		$this->debug($this->_header('rate - bitmarket - ' . $this->CurrencyBitcoin->settings['currency']), true);
		$is = $this->CurrencyBitcoin->rate();
		$this->debug($is);
		$this->assertTrue(is_numeric($is) && $is > 0 && $is < 100);

		$this->debug($this->_header('rate - bitcoincharts - ' . $this->CurrencyBitcoin->settings['currency']), true);
		$is = $this->CurrencyBitcoin->rate(['api' => 'bitcoincharts']);
		$this->debug($is);
		$this->assertTrue(is_numeric($is) && $is > 0 && $is < 100);
	}

}
