<?php

App::uses('CurrencyBitcoinLib', 'Data.Lib');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

class CurrencyBitcoinLibTest extends MyCakeTestCase {

	public function setUp() {
		parent::setUp();

		$this->CurrencyBitcoin = new CurrencyBitcoinLib();
	}

	/**
	 */
	public function testBitmarket() {
		$is = $this->CurrencyBitcoin->bitmarket();
		//$this->debug($is);
		$this->assertTrue(!empty($is['last']));
	}

	/**
	 */
	public function testBitcoincharts() {
		$is = $this->CurrencyBitcoin->bitcoincharts();
		//$this->debug($is);
		$this->assertFalse($is);
	}

	/**
	 */
	public function testRate() {
		$this->skipIf(true, 'TODO!');

		$this->debug($this->_header('rate - bitmarket - ' . $this->CurrencyBitcoin->settings['currency']), true);
		$is = $this->CurrencyBitcoin->rate();
		$this->debug($is);
		$this->assertTrue(is_numeric($is) && $is > 0 && $is < 100);

		$this->debug($this->_header('rate - bitcoincharts - ' . $this->CurrencyBitcoin->settings['currency']), true);
		$is = $this->CurrencyBitcoin->rate(array('api' => 'bitcoincharts'));
		$this->debug($is);
		$this->assertTrue(is_numeric($is) && $is > 0 && $is < 100);
	}

}
