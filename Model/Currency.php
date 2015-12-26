<?php
App::uses('DataAppModel', 'Data.Model');
App::uses('CurrencyComponent', 'Data.Lib');

class Currency extends DataAppModel {

	public $order = ['Currency.base' => 'DESC', 'Currency.code' => 'ASC'];

	public $validate = [
		'name' => [
			'notEmpty' => [
				'rule' => ['notEmpty'],
				'message' => 'valErrMandatoryField',
				'last' => true
			],
			'isUnique' => [
				'rule' => ['isUnique'],
				'message' => 'key already exists',
			],
		],
		'code' => [
			'notEmpty' => [
				'rule' => ['notEmpty'],
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

	public function beforeValidate($options = []) {
		$ret = parent::beforeValidate($options);

		if (isset($this->data[$this->alias]['value'])) {
			$this->data[$this->alias]['value'] = (float)$this->data[$this->alias]['value'];
		}

		if (isset($this->data[$this->alias]['code'])) {
			$this->data[$this->alias]['code'] = mb_strtoupper($this->data[$this->alias]['code']);

			$code = $this->data[$this->alias]['code'];
			# intelligent autocomplete
			if (isset($this->data[$this->alias]['name']) && empty($this->data[$this->alias]['name'])) {
				if (!isset($this->CurrencyLib)) {
					$this->CurrencyLib = new CurrencyComponent();
				}
				$this->data[$this->alias]['name'] = $this->CurrencyLib->getName($code, '');
			}

			if (isset($this->data[$this->alias]['value']) && $this->data[$this->alias]['value'] == 0) {
				if (!isset($this->CurrencyLib)) {
					$this->CurrencyLib = new CurrencyComponent();
				}
				$currencies = $this->availableCurrencies();
				if (array_key_exists($code, $currencies)) {
					$this->data[$this->alias]['value'] = $currencies[$code];
				}
			}
		}

		return $ret;
	}

	public function beforeSave($options = []) {
		parent::beforeSave($options);
		if (isset($this->data[$this->alias]['name'])) {
			$this->data[$this->alias]['name'] = ucwords($this->data[$this->alias]['name']);

			# intelligent autocomplete
		}

		return true;
	}

	/**
	 * Model validation
	 */
	public function available() {
		if (empty($this->data[$this->alias]['code'])) {
			return false;
		}
		return $this->isAvailable($this->data[$this->alias]['code']);
	}

	/**
	 * If code/unit is available in xml file for value retrieval
	 */
	public function isAvailable($code) {
		$currencies = $this->availableCurrencies();
		return array_key_exists(mb_strtoupper($code), $currencies);
	}

	/** model functions **/

	public function updateValues() {
		//TODO: move to Data lib!?
		if (!isset($this->CurrencyLib)) {
			$this->CurrencyLib = new CurrencyComponent();
		}
		# make sure we have up to date values
		$this->CurrencyLib->reset();

		$base = $this->baseCurrency();
		$currencies = $this->foreignCurrencies();
		foreach ($currencies as $currency) {
			$value = $this->CurrencyLib->convert(1, $base[$this->alias]['code'], $currency[$this->alias]['code'], 4);
			if ($value !== false) {
				$id = $currency[$this->alias]['id'];
				$this->saveFieldById($id, 'value', $value);
			} else {
				$this->log('Invalid Currency ' . $currency[$this->alias]['code'], 'warning');
			}
		}
	}

	/**
	 * All except base one
	 */
	public function foreignCurrencies($type = 'all', $options = []) {
		$defaults = ['conditions' => [$this->alias . '.base' => 0]];
		$options = Hash::merge($defaults, $options);
		return $this->find($type, $options);
	}

	public function baseCurrency($options = []) {
		$defaults = ['conditions' => [$this->alias . '.base' => 1]];
		$options = Hash::merge($defaults, $options);
		return $this->find('first', $options);
	}

	/**
	 * For calculation etc
	 */
	public function availableCurrencies() {
		if (!isset($this->CurrencyLib)) {
			$this->CurrencyLib = new CurrencyComponent();
		}
		$base = $this->baseCurrency();
		if ($res = $this->CurrencyLib->table($base[$this->alias]['code'], 4)) {
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
