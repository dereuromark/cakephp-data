<?php
/**
 * Other webservices:
 * - http://www.webservicex.net/WS/WSDetails.aspx?WSID=10 (XML)
 * - http://www.webserviceshare.com/business/financial/currency/service/Noon-Foreign-Exchange-Rates.htm (XML)
 */

namespace Data\Currency;

use Cake\Cache\Cache;
use Cake\Utility\Xml;

/**
 * Component to retreive calculate currencies
 *
 * example:
 * $result = $this->Currency->convert(2.5, 'EUR', 'USD');
 *
 * from: http://www.studiocanaria.com/articles/cakephp_currency_conversion_component
 * alternativly: http://www.currencyserver.de/webservice/CurrencyServerWebService.asmx/getXmlStream?provider=AVERAGE
 *
 * @author Mark Scherer
 * @license MIT
 */
class CurrencyLib {

	/**
	 * @var string
	 */
	public const URL = 'http://www.ecb.int/stats/eurofxref/eurofxref-daily.xml';

	/**
	 * @var string
	 */
	public const URL_HISTORY = 'http://www.ecb.int/stats/eurofxref/eurofxref-hist.xml';

	//TODO: get information about a currency (name, ...)
	/**
	 * @var string
	 */
	public const URL_TABLE = 'http://www.ecb.int/rss/fxref-{currency}.html';

	/**
	 * @var string
	 */
	public $baseCurrency = 'EUR';

	/**
	 * @var bool
	 */
	public $includeBitcoin = true;

	/**
	 * @var bool
	 */
	public $cacheFileUsed = false;

	/**
	 * @var int
	 */
	public $cacheTime = DAY;

	/**
	 * Converts the $amount from $fromCurrency to $toCurrency, formatted to
	 * $decimals decimal places.
	 *
	 * @param float $amount
	 * @param string $fromCurrency
	 * @param string $toCurrency
	 * @param int $decimals [optional]default=2
	 * @return string|null [Converted Currency Amount] or boolean FALSE on failure
	 */
	public function convert($amount, $fromCurrency, $toCurrency, $decimals = 2) {
		//Get the rate table
		$rates = $this->_retrieveCurrencies();

		//Return result of conversion
		if (!array_key_exists($fromCurrency, $rates) || !array_key_exists($toCurrency, $rates)) {
			return null;
		}

		return number_format($amount / $rates[$fromCurrency] * $rates[$toCurrency], $decimals);
	}

	/**
	 * Returns an array of rates in comparison the the $base currency given to $decimals
	 * number of decimal places.
	 *
	 * @param string $base string[optional]default='EUR'
	 * @param int $decimals integer[optional]default=2
	 * @return array|null Table or null on failure
	 */
	public function table($base = 'EUR', $decimals = 2) {
		//Create array to holds rates
		$rateTable = [];
		//Get rate table array
		$rates = $this->_retrieveCurrencies();

		if (!array_key_exists($base, $rates)) {
			return null;
		}

		//Iterate throught each rate converting it against $base
		foreach ($rates as $key => $value) {
			$rate = 0;
			if ($value > 0) {
				$rate = 1 / $rates[$base] * $rates[$key];
			}
			$rateTable[$key] = number_format($rate, $decimals);
		}

		//Return result array
		return $rateTable;
	}

	/**
	 * @param string|null $date Date in Format XXXX-XX-XX
	 * @return array
	 */
	public function history($date = null) {
		$history = $this->_retrieveHistory();
		if ($date) {
			if (!empty($history[$date])) {
				return $history[$date];
			}

			return [];
		}

		return $history;
	}

	/**
	 * @param string $currency
	 * @return bool Success.
	 */
	public function isAvailable($currency) {
		$rates = $this->_retrieveCurrencies();

		return array_key_exists($currency, $rates);
	}

	/**
	 * @param string $name Name: "" (none), "history", "full" (both)
	 * @return bool Success.
	 */
	public function reset($name = 'full') {
		if ($name === 'full') {
			$name = '';
			Cache::delete('currencyListHistory');
		}

		return Cache::delete('currencyList' . ucfirst($name));
	}

	/**
	 * @return bool
	 */
	public function cacheFileUsed() {
		return $this->cacheFileUsed;
	}

	/**
	 * @param string $currency Code (3digit - e.g. EUR)
	 * @param mixed $default (defaults to bool false)
	 * @return mixed|bool
	 */
	public function getName($currency, $default = false) {
		if (empty($currency)) {
			return $default;
		}
		$currency = strtoupper($currency);
		$currencies = $this->currencies;
		if ($this->includeBitcoin) {
			$currencies['BTC'] = 'Bitcoin';
		}

		if (isset($currencies[$currency])) {
			return $currencies[$currency];
		}

		return $default;
	}

	/**
	 * @return array
	 */
	protected function _retrieveHistory() {
		$historyList = $this->_retrieve('history');
		if ($historyList) {
			return $historyList;
		}

		$currencies = $this->_loadXml(static::URL_HISTORY);

		// Filter down to just the rates
		$dates = $currencies['Envelope']['Cube']['Cube'];

		$historyList = [];
		foreach ($dates as $date) {
			$time = $date['@time'];
			foreach ($date['Cube'] as $currency) {
				$historyList[$time][$currency['@currency']] = $currency['@rate'];
				// European Central bank gives us everything against Euro so add this manually
				$historyList[$time][$this->baseCurrency] = 1;
			}
		}

		$this->_store($historyList, 'history');

		return $historyList;
	}

	/**
	 * @return array
	 */
	protected function _retrieveCurrencies() {
		$currencyList = $this->_retrieve();
		if ($currencyList) {
			return $currencyList;
		}

		// Retrieve rates as an XML object
		$currencies = $this->_loadXml(static::URL);

		//Filter down to just the rates
		$currencies = $currencies['Envelope']['Cube']['Cube']['Cube'];

		//Create an array to hold the rates
		$currencyList = [];
		//European Central bank gives us everything against Euro so add this manually
		$currencyList[$this->baseCurrency] = 1;
		//Now iterate through and add the rates provided
		foreach ($currencies as $currency) {
			$currencyList[$currency['@currency']] = $currency['@rate'];
		}

		if ($this->includeBitcoin) {
			$res = $this->_getBitcoin();
			if ($res) {
				$currencyList['BTC'] = $res;
			}
		}

		//Cache
		$this->_store($currencyList);

		return $currencyList;
	}

	/**
	 * @return float
	 */
	protected function _getBitcoin() {
		$Btc = new CurrencyBitcoinLib(['currency' => $this->baseCurrency]);
		$current = $Btc->coingecko();

		return $Btc->ratio($current);
	}

	/**
	 * @param array $currencyList
	 * @param string $name Name: "" (none), "history", "full" (both)
	 * @return void
	 */
	protected function _store($currencyList, $name = '') {
		$this->cacheFileUsed = false;
		Cache::write('currencyList' . ucfirst($name), serialize($currencyList));
	}

	/**
	 * @param string $name Name: "" (none), "history", "full" (both)
	 * @return mixed|bool
	 */
	protected function _retrieve($name = '') {
		$res = Cache::read('currencyList' . ucfirst($name));
		if ($res !== false) {
			$this->cacheFileUsed = true;

			return unserialize((string)$res);
		}

		return false;
	}

	/**
	 * @param string $url
	 * @return array
	 */
	protected function _loadXml($url) {
		$CurrencyXml = Xml::build($url, ['readFile' => true]);

		return Xml::toArray($CurrencyXml);
	}

	/**
	 * @var array<string>
	 */
	protected array $currencies = [
		'AFA' => 'Afghanistan Afghani',
		'ALL' => 'Albanian Lek',
		'DZD' => 'Algerian Dinar',
		'ARS' => 'Argentine Peso',
		'AWG' => 'Aruba Florin',
		'AUD' => 'Australian Dollar',
		'BSD' => 'Bahamian Dollar',
		'BHD' => 'Bahraini Dinar',
		'BDT' => 'Bangladesh Taka',
		'BBD' => 'Barbados Dollar',
		'BZD' => 'Belize Dollar',
		'BMD' => 'Bermuda Dollar',
		'BTN' => 'Bhutan Ngultrum',
		'BOB' => 'Bolivian Boliviano',
		'BWP' => 'Botswana Pula',
		'BRL' => 'Brazilian Real',
		'GBP' => 'British Pound',
		'BND' => 'Brunei Dollar',
		'BIF' => 'Burundi Franc',
		'XOF' => 'CFA Franc (BCEAO)',
		'XAF' => 'CFA Franc (BEAC)',
		'KHR' => 'Cambodia Riel',
		'CAD' => 'Canadian Dollar',
		'CVE' => 'Cape Verde Escudo',
		'KYD' => 'Cayman Islands Dollar',
		'CLP' => 'Chilean Peso',
		'CNY' => 'Chinese Yuan',
		'COP' => 'Colombian Peso',
		'KMF' => 'Comoros Franc',
		'CRC' => 'Costa Rica Colon',
		'HRK' => 'Croatian Kuna',
		'CUP' => 'Cuban Peso',
		'CYP' => 'Cyprus Pound',
		'CZK' => 'Czech Koruna',
		'DKK' => 'Danish Krone',
		'DJF' => 'Dijibouti Franc',
		'DOP' => 'Dominican Peso',
		'XCD' => 'East Caribbean Dollar',
		'EGP' => 'Egyptian Pound',
		'SVC' => 'El Salvador Colon',
		'EEK' => 'Estonian Kroon',
		'ETB' => 'Ethiopian Birr',
		'EUR' => 'Euro',
		'FKP' => 'Falkland Islands Pound',
		'GMD' => 'Gambian Dalasi',
		'GHC' => 'Ghanian Cedi',
		'GIP' => 'Gibraltar Pound',
		'XAU' => 'Gold Ounces',
		'GTQ' => 'Guatemala Quetzal',
		'GNF' => 'Guinea Franc',
		'GYD' => 'Guyana Dollar',
		'HTG' => 'Haiti Gourde',
		'HNL' => 'Honduras Lempira',
		'HKD' => 'Hong Kong Dollar',
		'HUF' => 'Hungarian Forint',
		'ISK' => 'Iceland Krona',
		'INR' => 'Indian Rupee',
		'IDR' => 'Indonesian Rupiah',
		'IQD' => 'Iraqi Dinar',
		'ILS' => 'Israeli Shekel',
		'JMD' => 'Jamaican Dollar',
		'JPY' => 'Japanese Yen',
		'JOD' => 'Jordanian Dinar',
		'KZT' => 'Kazakhstan Tenge',
		'KES' => 'Kenyan Shilling',
		'KRW' => 'Korean Won',
		'KWD' => 'Kuwaiti Dinar',
		'LAK' => 'Lao Kip',
		'LVL' => 'Latvian Lat',
		'LBP' => 'Lebanese Pound',
		'LSL' => 'Lesotho Loti',
		'LRD' => 'Liberian Dollar',
		'LYD' => 'Libyan Dinar',
		'LTL' => 'Lithuanian Lita',
		'MOP' => 'Macau Pataca',
		'MKD' => 'Macedonian Denar',
		'MGF' => 'Malagasy Franc',
		'MWK' => 'Malawi Kwacha',
		'MYR' => 'Malaysian Ringgit',
		'MVR' => 'Maldives Rufiyaa',
		'MTL' => 'Maltese Lira',
		'MRO' => 'Mauritania Ougulya',
		'MUR' => 'Mauritius Rupee',
		'MXN' => 'Mexican Peso',
		'MDL' => 'Moldovan Leu',
		'MNT' => 'Mongolian Tugrik',
		'MAD' => 'Moroccan Dirham',
		'MZM' => 'Mozambique Metical',
		'MMK' => 'Myanmar Kyat',
		'NAD' => 'Namibian Dollar',
		'NPR' => 'Nepalese Rupee',
		'ANG' => 'Neth Antilles Guilder',
		'NZD' => 'New Zealand Dollar',
		'NIO' => 'Nicaragua Cordoba',
		'NGN' => 'Nigerian Naira',
		'KPW' => 'North Korean Won',
		'NOK' => 'Norwegian Krone',
		'OMR' => 'Omani Rial',
		'XPF' => 'Pacific Franc',
		'PKR' => 'Pakistani Rupee',
		'XPD' => 'Palladium Ounces',
		'PAB' => 'Panama Balboa',
		'PGK' => 'Papua New Guinea Kina',
		'PYG' => 'Paraguayan Guarani',
		'PEN' => 'Peruvian Nuevo Sol',
		'PHP' => 'Philippine Peso',
		'XPT' => 'Platinum Ounces',
		'PLN' => 'Polish Zloty',
		'QAR' => 'Qatar Rial',
		'ROL' => 'Romanian Leu',
		'RUB' => 'Russian Rouble',
		'WST' => 'Samoa Tala',
		'STD' => 'Sao Tome Dobra',
		'SAR' => 'Saudi Arabian Riyal',
		'SCR' => 'Seychelles Rupee',
		'SLL' => 'Sierra Leone Leone',
		'XAG' => 'Silver Ounces',
		'SGD' => 'Singapore Dollar',
		'SKK' => 'Slovak Koruna',
		'SIT' => 'Slovenian Tolar',
		'SBD' => 'Solomon Islands Dollar',
		'SOS' => 'Somali Shilling',
		'ZAR' => 'South African Rand',
		'LKR' => 'Sri Lanka Rupee',
		'SHP' => 'St Helena Pound',
		'SDD' => 'Sudanese Dinar',
		'SRG' => 'Surinam Guilder',
		'SZL' => 'Swaziland Lilageni',
		'SEK' => 'Swedish Krona',
		'TRY' => 'Turkey Lira',
		'CHF' => 'Swiss Franc',
		'SYP' => 'Syrian Pound',
		'TWD' => 'Taiwan Dollar',
		'TZS' => 'Tanzanian Shilling',
		'THB' => 'Thai Baht',
		'TOP' => 'Tonga Pa\'anga',
		'TTD' => 'Trinidad & Tobago Dollar',
		'TND' => 'Tunisian Dinar',
		'TRL' => 'Turkish Lira',
		'USD' => 'U.S. Dollar',
		'AED' => 'UAE Dirham',
		'UGX' => 'Ugandan Shilling',
		'UAH' => 'Ukraine Hryvnia',
		'UYU' => 'Uruguayan New Peso',
		'VUV' => 'Vanuatu Vatu',
		'VEB' => 'Venezuelan Bolivar',
		'VND' => 'Vietnam Dong',
		'YER' => 'Yemen Riyal',
		'YUM' => 'Yugoslav Dinar',
		'ZMK' => 'Zambian Kwacha',
		'ZWD' => 'Zimbabwe Dollar',
	];

}
