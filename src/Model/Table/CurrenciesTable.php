<?php

namespace Data\Model\Table;

use ArrayObject;
use Cake\Core\Plugin;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\Utility\Hash;
use Data\Lib\CurrencyLib;
use Tools\Model\Table\Table;

/**
 * @mixin \Search\Model\Behavior\SearchBehavior
 * @method \Data\Model\Entity\Currency get($primaryKey, $options = [])
 * @method \Data\Model\Entity\Currency newEntity(array $data, array $options = [])
 * @method array<\Data\Model\Entity\Currency> newEntities(array $data, array $options = [])
 * @method \Data\Model\Entity\Currency|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Data\Model\Entity\Currency saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Data\Model\Entity\Currency patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\Data\Model\Entity\Currency> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Data\Model\Entity\Currency findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Data\Model\Entity\Currency newEmptyEntity()
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\Currency>|false saveMany(iterable $entities, $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\Currency> saveManyOrFail(iterable $entities, $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\Currency>|false deleteMany(iterable $entities, $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\Currency> deleteManyOrFail(iterable $entities, $options = [])
 */
class CurrenciesTable extends Table {

	/**
	 * @var array
	 */
	protected $order = ['base' => 'DESC', 'code' => 'ASC'];

	/**
	 * @var array
	 */
	public $validate = [
		'name' => [
			'notBlank' => [
				'rule' => ['notBlank'],
				'message' => 'valErrMandatoryField',
				'last' => true,
			],
			'isUnique' => [
				'rule' => ['isUnique'],
				'message' => 'key already exists',
				'provider' => 'table',
			],
		],
		'code' => [
			'notBlank' => [
				'rule' => ['notBlank'],
				'message' => 'valErrMandatoryField',
				'last' => true,
			],
			'isUnique' => [
				'rule' => ['isUnique'],
				'message' => 'key already exists',
				'last' => true,
				'provider' => 'table',
			],
			'available' => [
				'rule' => ['available'],
				'message' => 'this currency is not available',
				'provider' => 'table',
			],
		],
		'value' => ['numeric'],
		'base' => ['numeric'],
		'decimal_places' => ['numeric'],
	];

	/**
	 * @var \Data\Lib\CurrencyLib
	 */
	public $CurrencyLib;

	/**
	 * @param array $config
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		if (!Plugin::isLoaded('Search')) {
			return;
		}

		$this->addBehavior('Search.Search');
		$this->searchManager()
			->like('search', ['fields' => ['name', 'code']])
			->value('active');
	}

	/**
	 * @param \Cake\Event\EventInterface $event
	 * @param \ArrayObject $data
	 * @param \ArrayObject $options
	 * @return void
	 */
	public function beforeMarshal(EventInterface $event, ArrayObject $data, ArrayObject $options) {
		if (isset($data['value'])) {
			$data['value'] = (float)$data['value'];
		}

		if (isset($data['code'])) {
			$data['code'] = mb_strtoupper($data['code']);

			$code = $data['code'];
			# intelligent autocomplete
			if (isset($data['name']) && empty($data['name'])) {
				if (!isset($this->CurrencyLib)) {
					$this->CurrencyLib = new CurrencyLib();
				}
				$data['name'] = $this->CurrencyLib->getName($code, '');
			}

			if (isset($data['value']) && $data['value'] == 0) {
				if (!isset($this->CurrencyLib)) {
					$this->CurrencyLib = new CurrencyLib();
				}
				$currencies = $this->availableCurrencies();
				if (array_key_exists($code, $currencies)) {
					$data['value'] = $currencies[$code];
				}
			}
		}
	}

	/**
	 * @param \Cake\Event\EventInterface $event
	 * @param \Data\Model\Entity\Currency $entity
	 * @param \ArrayObject $options
	 *
	 * @return void
	 */
	public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options): void {
		if (isset($entity['name'])) {
			$entity['name'] = ucwords($entity['name']);
		}
	}

	/**
	 * Model validation
	 *
	 * @param string $value
	 * @param array $context
	 * @return bool
	 */
	public function available($value, array $context) {
		if (empty($value)) {
			return false;
		}

		return $this->isAvailable($value);
	}

	/**
	 * If code/unit is available in xml file for value retrieval
	 *
	 * @param string $code
	 * @return bool
	 */
	public function isAvailable($code) {
		$currencies = $this->availableCurrencies();

		return array_key_exists(mb_strtoupper($code), $currencies);
	}

	/**
	 * @return void
	 */
	public function updateValues() {
		if (!isset($this->CurrencyLib)) {
			$this->CurrencyLib = new CurrencyLib();
		}
		# make sure we have up to date values
		$this->CurrencyLib->reset();

		$base = $this->baseCurrency();
		$currencies = $this->foreignCurrencies()->all();
		foreach ($currencies as $currency) {
			$value = $this->CurrencyLib->convert(1, $base['code'], $currency['code'], 4);
			if ($value !== false) {
				$id = $currency['id'];
				$this->updateAll(['value' => $value], ['id' => $id]);
			} else {
				//$this->log('Invalid Currency ' . $currency['code'], 'warning');
			}
		}
	}

	/**
	 * All except base one
	 *
	 * @param array<string, mixed> $options
	 * @return \Cake\ORM\Query
	 */
	public function foreignCurrencies($options = []) {
		$defaults = ['conditions' => [$this->getAlias() . '.base' => 0]];
		$options = Hash::merge($defaults, $options);

		return $this->find('all', $options);
	}

	/**
	 * @param array<string, mixed> $options
	 *
	 * @return \Data\Model\Entity\Currency|null
	 */
	public function baseCurrency($options = []) {
		$defaults = ['conditions' => [$this->getAlias() . '.base' => 1]];
		$options = Hash::merge($defaults, $options);

		return $this->find('all', $options)->first();
	}

	/**
	 * For calculation etc
	 *
	 * @return array
	 */
	public function availableCurrencies() {
		if (!isset($this->CurrencyLib)) {
			$this->CurrencyLib = new CurrencyLib();
		}

		$base = $this->baseCurrency();
		$res = $this->CurrencyLib->table($base ? $base->code : 'EUR', 4);
		if (!$res) {
			return [];
		}

		return $res;
	}

	/**
	 * For user selection
	 *
	 * @return array<string>
	 */
	public function currencyList() {
		$res = $this->availableCurrencies();
		foreach ($res as $key => $val) {
			$val = $key;

			$valExt = $this->CurrencyLib->getName($key);
			if ($valExt) {
				$val .= ' - ' . $valExt;
			}

			$res[$key] = $val;
		}

		return $res;
	}

}
