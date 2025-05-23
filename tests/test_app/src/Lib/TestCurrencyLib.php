<?php

namespace TestApp\Lib;

use Cake\Core\Plugin;
use Data\Currency\CurrencyLib;

class TestCurrencyLib extends CurrencyLib {

	/**
	 * @return float
	 */
	protected function _getBitcoin() {
		if (!empty($_SERVER['argv']) && in_array('--debug', $_SERVER['argv'], true)) {
			//debug('Live Data!');
			return parent::_getBitcoin();
		}

		// Fake for now
		return 9.99;
	}

	/**
	 * @param string $url
	 *
	 * @return array
	 */
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
