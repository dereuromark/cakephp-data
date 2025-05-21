<?php

namespace Data\Currency;

use Cake\Core\InstanceConfigTrait;
use Cake\Http\Client;

/**
 * Use Webservices to get current rates etc
 *
 * @author Mark Scherer
 * @license MIT
 */
class CurrencyBitcoinLib {

	use InstanceConfigTrait;

	/**
	 * @var array<string, mixed>
	 */
	protected $_defaultConfig = [
		'currency' => 'EUR', # set to NULL or empty for all
		'api' => 'coingecko',
	];

	/**
	 * @param array<string, mixed> $config
	 */
	public function __construct(array $config = []) {
		$this->setConfig($config);
	}

	/**
	 * @return int|null
	 */
	public function coingecko(): ?int {
		$currency = strtolower($this->getConfig('currency'));
		$url = 'https://api.coingecko.com/api/v3/simple/price?ids=bitcoin&vs_currencies=' . $currency;

		/*
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		*/
		$response = $this->_get($url);

		$data = json_decode($response, true);

		return $data['bitcoin'][$currency] ?? null;
	}

	/**
	 * Calc BTC relative to 1 baseCurrency
	 *
	 * @param string|float|int $current Value of 1 BTC
	 * @return float
	 */
	public function ratio(string|float|int $current) {
		return 1.0 / (float)$current;
	}

	/**
	 * @param string|float|int $value
	 * @param string|float|int $current
	 * @return float
	 */
	public function convert(string|float|int $value, string|float|int $current): float {
		return (float)$value * $this->ratio($current);
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
	 * @return string|null
	 */
	protected function _get(string $url): ?string {
		$http = new Client();
		$res = $http->get($url);
		if (!$res->isOk()) {
			return null;
		}

		return (string)$res->getBody()->getContents();
	}

}
