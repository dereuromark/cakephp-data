<?php
namespace Data\Model\Table;

use Cake\Utility\Hash;
use Data\Lib\CurrencyLib;
use Tools\Model\Table\Table;

class CurrenciesTable extends Table {

	public $order = ['base' => 'DESC', 'code' => 'ASC'];

	public $validate = [
		'name' => [
			'notBlank' => [
				'rule' => ['notBlank'],
				'message' => 'valErrMandatoryField',
				'last' => true
			],
			'isUnique' => [
				'rule' => ['isUnique'],
				'message' => 'key already exists',
			],
		],
		'code' => [
			'notBlank' => [
				'rule' => ['notBlank'],
				'message' => 'valErrMandatoryField',
				'last' => true
			],
			'isUnique' => [
				'rule' => ['isUnique'],
				'message' => 'key already exists',
				'last' => true
			],
			'available' => [
				'rule' => ['available'],
				'message' => 'this currency is not available',
				'provider' => 'table'
			],
		],
		'value' => ['numeric'],
		'base' => ['numeric'],
		'decimal_places' => ['numeric'],
	];

	public $filterArgs = [
		'search' => ['type' => 'like', 'field' => ['name', 'code']],
		'active' => ['type' => 'value']
	];

	/**
	 * @var \Data\Lib\CurrencyLib
	 */
	public $CurrencyLib;

	public function beforeValidate($options = []) {
		$ret = parent::beforeValidate($options);

		if (isset($this->data['value'])) {
			$this->data['value'] = (float)$this->data['value'];
		}

		if (isset($this->data['code'])) {
			$this->data['code'] = mb_strtoupper($this->data['code']);

			$code = $this->data['code'];
			# intelligent autocomplete
			if (isset($this->data['name']) && empty($this->data['name'])) {
				if (!isset($this->CurrencyLib)) {
					//App::import('Component', 'Data.Currency');
					$this->CurrencyLib = new CurrencyLib();
				}
				$this->data['name'] = $this->CurrencyLib->getName($code, '');
			}

			if (isset($this->data['value']) && $this->data['value'] == 0) {
				if (!isset($this->CurrencyLib)) {
					$this->CurrencyLib = new CurrencyLib();
				}
				$currencies = $this->availableCurrencies();
				if (array_key_exists($code, $currencies)) {
					$this->data['value'] = $currencies[$code];
				}
			}
		}

		return $ret;
	}

	/*
	public function beforeSave($options = array()) {
		parent::beforeSave($options);
		if (isset($this->data['name'])) {
			$this->data['name'] = ucwords($this->data['name']);

			# intelligent autocomplete
		}

		return true;
	}
	*/

	/**
	 * Model validation
	 */
	public function available($value, $context) {
		if (empty($value)) {
			return false;
		}
		return $this->isAvailable($value);
	}

	/**
	 * If code/unit is available in xml file for value retrieval
	 */
	public function isAvailable($code) {
		$currencies = $this->availableCurrencies();
		return array_key_exists(mb_strtoupper($code), $currencies);
	}

	/**
	 * model functions
	 **/

	public function updateValues() {
		if (!isset($this->CurrencyLib)) {
			$this->CurrencyLib = new CurrencyLib();
		}
		# make sure we have up to date values
		$this->CurrencyLib->reset();

		$base = $this->baseCurrency();
		$currencies = $this->foreignCurrencies();
		foreach ($currencies as $currency) {
			$value = $this->CurrencyLib->convert(1, $base['code'], $currency['code'], 4);
			if ($value !== false) {
				$id = $currency['id'];
				$this->saveField($id, 'value', $value);
			} else {
				//$this->log('Invalid Currency ' . $currency['code'], 'warning');
			}
		}
	}

	/**
	 * All except base one
	 */
	public function foreignCurrencies($type = 'all', $options = []) {
		$defaults = ['conditions' => [$this->alias() . '.base' => 0]];
		$options = Hash::merge($defaults, $options);
		return $this->find($type, $options);
	}

	public function baseCurrency($options = []) {
		$defaults = ['conditions' => [$this->alias() . '.base' => 1]];
		$options = Hash::merge($defaults, $options);
		return $this->find('first', $options);
	}

	/**
	 * For calculation etc
	 */
	public function availableCurrencies() {
		if (!isset($this->CurrencyLib)) {
			$this->CurrencyLib = new CurrencyLib();
		}
		$base = $this->baseCurrency();
		if ($res = $this->CurrencyLib->table($base['code'], 4)) {
			return $res;
		}
		return [];
	}

	/**
	 * For user selection
	 */
	public function currencyList() {
		$res = $this->availableCurrencies();
		foreach ($res as $key => $val) {
			$val = $key;

			if ($valExt = $this->CurrencyLib->getName($key)) {
				$val .= ' - ' . $valExt;
			}

			$res[$key] = $val;
		}
		return $res;
	}

}
