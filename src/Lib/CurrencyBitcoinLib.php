<?php

namespace Data\Lib;

use Cake\Http\Client;

/**
 * Use Webservices to get current rates etc
 *
 * @author Mark Scherer
 * @license MIT
 */
class CurrencyBitcoinLib {

	/**
	 * @var array
	 */
	public $settings = [
		'currency' => 'EUR', # set to NULL or empty for all
		'api' => 'bitmarket', # bitmarket or bitcoincharts
	];

	/**
	 * @see https://bitmarket.eu/api
	 * @param array $options
	 * @return bool
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
	 * @param array $options
	 * @return array|bool
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
	 * @return float|bool
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
	 * @param float $current
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
	 * @param string $url
	 * @return string|bool
	 */
	protected function _getBitmarket($url) {
		$res = $this->_get($url);
		if (!$res) {
			return false;
		}
		$res = json_decode($res, true);
		if (!$res) {
			return false;
		}

		return $res;
	}

	/**
	 * @param string $url
	 * @return string|bool
	 */
	protected function _getBitcoincharts($url) {
		$res = $this->_get($url);
		if (!$res) {
			return false;
		}
		$res = json_decode($res, true);
		if (!$res) {
			return false;
		}

		return $res;
	}

	/**
	 * @param string $url
	 * @return string|null
	 */
	protected function _get($url) {
		$http = new Client();
		$res = $http->get($url);
		if (!$res->isOk()) {
			return null;
		}

		return (string)$res->getBody()->getContents();
	}

}
