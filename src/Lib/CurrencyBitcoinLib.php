<?php
namespace Data\Lib;

use Cake\Network\Http\Client;

/**
 * Use Webservices to get current rates etc
 *
 * @author Mark Scherer
 * @license MIT
 */
class CurrencyBitcoinLib {

	public $settings = [
		'currency' => 'EUR', # set to NULL or empty for all
		'api' => 'bitmarket', # bitmarket or bitcoincharts
	];

	/**
	 * @see https://bitmarket.eu/api
	 */
	public function bitmarket($options = []) {
		$options += $this->settings;
		$url = 'https://bitmarket.eu/api/ticker';
		$res = $this->_getBitmarket($url);

		if (!$res) {
			return false;
		}
		if (empty($options['currency'])) {
			return $res['currencies'];
		}
		if (empty($res['currencies'][$options['currency']])) {
			return false;
		}
		return $res['currencies'][$options['currency']];
	}

	/**
	 * Working
	 *
	 * @see http://bitcoincharts.com/about/markets-api/
	 */
	public function bitcoincharts($options = []) {
		$options += $this->settings;
		$url = 'http://api.bitcoincharts.com/v1/markets.json';
		$res = $this->_getBitcoincharts($url);
		if (!$res) {
			return false;
		}
		$array = [];
		foreach ($res as $val) {
			$array[$val['currency']] = $val;
			unset($array[$val['currency']]['currency']);
		}

		if (empty($options['currency'])) {
			return $array;
		}
		if (empty($array[$options['currency']])) {
			return false;
		}
		return $array[$options['currency']];
	}

	/**
	 * @param array $options
	 * - currency
	 * - api
	 */
	public function rate($options = []) {
		$options += $this->settings;
		$res = $this->{$options['api']}($options);

		if ($res && isset($res['sell'])) {
			// bitmarket
			$current = $res['sell'];
		} elseif ($res && isset($res['ask'])) {
			// bitcoincharts
			$current = $res['ask'];
		}
		if (isset($current)) {
			return $this->calcRate($current);
		}
		return false;
	}

	/**
	 * Calc BTC relative to 1 baseCurrency
	 *
	 * @param float $value
	 * @return float relativeValue
	 */
	public function calcRate($current) {
		return 1.0 / (float)$current;
	}

	/**
	 * Historic trade data
	 *
	 * @see http://bitcoincharts.com/about/markets-api/
	 * @return void
	 */
	public function trades() {
		//TODO
	}

	/**
	 * CurrencyBitcoinLib::_getBitmarket()
	 *
	 * @param mixed $url
	 * @return string|bool
	 */
	protected function _getBitmarket($url) {
		if (!($res = $this->_get($url))) {
			return false;
		}
		if (!($res = json_decode($res, true))) {
			return false;
		}
		return $res;
	}

	/**
	 * CurrencyBitcoinLib::_getBitcoincharts()
	 *
	 * @param mixed $url
	 * @return string|bool
	 */
	protected function _getBitcoincharts($url) {
		if (!($res = $this->_get($url))) {
			return false;
		}
		if (!($res = json_decode($res, true))) {
			return false;
		}
		return $res;
	}

	/**
	 * CurrencyBitcoinLib::_get()
	 *
	 * @param mixed $url
	 * @return string|bool
	 */
	protected function _get($url) {
		$http = new Client();
		if (!($res = $http->get($url))) {
			return false;
		}
		return $res->body;
	}

}
