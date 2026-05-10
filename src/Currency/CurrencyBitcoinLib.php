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
	 * Returns the current price of 1 BTC in the configured fiat currency.
	 *
	 * Coingecko returns the price as a JSON number with decimal precision
	 * (e.g. 95871.42), so the return type must be float — coercing to int
	 * silently drops the fractional part and skews any downstream ratio.
	 *
	 * @return float|null
	 */
	public function coingecko(): ?float {
		$currency = strtolower($this->getConfig('currency'));
		$url = 'https://api.coingecko.com/api/v3/simple/price?ids=bitcoin&vs_currencies=' . $currency;

		$response = $this->_get($url);
		if ($response === null) {
			return null;
		}

		$data = json_decode($response, true);
		$value = $data['bitcoin'][$currency] ?? null;

		return $value !== null ? (float)$value : null;
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
