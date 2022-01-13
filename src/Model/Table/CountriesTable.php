<?php

namespace Data\Model\Table;

use ArrayObject;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Data\Model\Entity\Country;
use Geo\Geocoder\Geocoder;
use InvalidArgumentException;
use Tools\Model\Table\Table;

/**
 * @mixin \Search\Model\Behavior\SearchBehavior
 * @method \Data\Model\Entity\Country get($primaryKey, $options = [])
 * @method \Data\Model\Entity\Country newEntity(array $data, array $options = [])
 * @method array<\Data\Model\Entity\Country> newEntities(array $data, array $options = [])
 * @method \Data\Model\Entity\Country|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Data\Model\Entity\Country patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\Data\Model\Entity\Country> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Data\Model\Entity\Country findOrCreate($search, ?callable $callback = null, $options = [])
 * @property \Data\Model\Table\StatesTable&\Cake\ORM\Association\HasMany $States
 * @method \Data\Model\Entity\Country saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Data\Model\Entity\Country newEmptyEntity()
 * @method \Data\Model\Entity\Country[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Data\Model\Entity\Country[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Data\Model\Entity\Country[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Data\Model\Entity\Country[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @property \Data\Model\Table\ContinentsTable&\Cake\ORM\Association\BelongsTo $Continents
 * @property \Data\Model\Table\TimezonesTable&\Cake\ORM\Association\HasMany $Timezones
 */
class CountriesTable extends Table {

	/**
	 * @var array
	 */
	protected $order = ['sort' => 'DESC', 'name' => 'ASC'];

	/**
	 * @var array
	 */
	public $validate = [
		'name' => [
			'notBlank' => [
				'rule' => ['notBlank'],
				'message' => 'Mandatory field',
				'last' => true,
			],
			'isUnique' => [
				'rule' => ['isUnique'],
				'message' => 'record (with this name) already exists',
				'provider' => 'table',
			],
		],
		'ori_name' => [
			'notBlank' => [
				'rule' => ['notBlank'],
				'message' => 'Mandatory field',
				'last' => true,
			],
			'isUnique' => [
				'rule' => ['isUnique'],
				'message' => 'record (with this name) already exists',
				'provider' => 'table',
			],
		],
		'iso2' => [
			'isUnique' => [
				'rule' => ['isUnique'],
				'allowEmpty' => true,
				'message' => 'record (with this name) already exists',
				'provider' => 'table',
			],
		],
		'iso3' => [
			'isUnique' => [
				'rule' => ['isUnique'],
				'allowEmpty' => true,
				'message' => 'record (with this name) already exists',
				'provider' => 'table',
			],
		],
		//'phone_code' => ['numeric'],
		//'special' => array('notBlank'),
		//'sort' => array('numeric')
	];

	/**
	 * @param array $config
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		if (Configure::read('Data.Country.State') !== false) {
			$this->hasMany('States', [
				'className' => 'Data.States',
				'dependent' => true,
			]);
		}
		if (Configure::read('Data.Country.Continent') !== false) {
			$this->belongsTo('Continents', [
				'className' => 'Data.Continents',
			]);
		}
		if (Configure::read('Data.Country.Timezone') !== false) {
			$this->hasMany('Timezones', [
				'className' => 'Data.Timezones',
				'foreignKey' => 'country_code',
				'bindingKey' => 'iso2',
				'conditions' => ['Timezones.type' => 'Canonical', 'Timezones.active' => true],
			]);
		}

		if (!Plugin::isLoaded('Search')) {
			return;
		}

		$this->addBehavior('Search.Search');
		$this->searchManager()
			->like('search', ['fields' => ['name', 'ori_name', 'iso2', 'iso3']]);
	}

	/**
	 * @param \Cake\Event\EventInterface $event
	 * @param \ArrayObject $data
	 * @param \ArrayObject $options
	 * @return void
	 */
	public function beforeMarshal(EventInterface $event, ArrayObject $data, ArrayObject $options) {
		if (isset($data['iso2'])) {
			$data['iso2'] = mb_strtoupper($data['iso2']);
		}
		if (isset($data['iso3'])) {
			$data['iso3'] = mb_strtoupper($data['iso3']);
		}
	}

	/**
	 * @param array $options
	 * @return \Cake\ORM\Query
	 */
	public function findActive(array $options = []) {
		return $this->find('all', $options)->where([$this->getAlias() . '.status' => Country::STATUS_ACTIVE]);
	}

	/**
	 * @param int|null $id
	 *
	 * @return int|false
	 */
	public function updateCode($id = null) {
		$Geocoder = new Geocoder();

		$override = false;
		if ($id == -1) {
			$id = 0;
			$override = true;
		}

		if ($id) {
			//$res = $this->find('first', ['conditions' => [$this->getAlias() . '.id' => $id], 'contain' => []]);
		} else {
			$conditions = [];
			if (!$override) {
				$conditions = [$this->getAlias() . '.iso2' => '']; # right now only iso2
			}

			/** @var array<\Data\Model\Entity\Country> $countries */
			$countries = $this->find('all', ['conditions' => $conditions, 'contain' => []]);

			$count = 0;
			foreach ($countries as $country) {
				$data = $country->ori_name ? $Geocoder->geocode($country->ori_name) : null;
				if (!$data && $country->name !== $country->ori_name) {
					$data = $Geocoder->geocode($country->name);
				}
				if (!$data) {
					continue;
				}

				if (!empty($data['country_code']) && mb_strlen($data['country_code']) === 3 && preg_match('/^([A-Z])*$/', $data['country_code'])) {
					$country['iso3'] = $data['country_code'];

				} elseif (!empty($data['country_code']) && mb_strlen($data['country_code']) === 2 && preg_match('/^([A-Z])*$/', $data['country_code'])) {
					$country['iso2'] = $data['country_code'];
				}

				$dirtyFields = $country->getDirty();

				if ($this->save($country, ['fields' => ['iso2', 'iso3']])) {
					$count++;
				}

				if (isset($dirtyFields['iso2'])) {
					//$this->log('Iso2 for country \'' . $data['country'] . '\' changed from \'' . $country['iso2'] . '\' to \'' . $saveArray['iso2'] . '\'', LOG_NOTICE);
				}
				if (isset($dirtyFields['iso3'])) {
					//$this->log('Iso3 for country \'' . $data['country'] . '\' changed from \'' . $country['iso3'] . '\' to \'' . $saveArray['iso3'] . '\'', LOG_NOTICE);
				}
			}

			return $count;
		}

		return false;
	}

	/**
	 * @param \Cake\Event\EventInterface $event
	 * @param \Data\Model\Entity\Country $entity
	 * @param \ArrayObject $options
	 * @return void
	 */
	public function afterSave(EventInterface $event, EntityInterface $entity, ArrayObject $options) {
		if ($entity->isNew()) {
			//$this->updateCoordinates($entity);
		}
	}

	/**
	 * @param string $isoCode
	 *
	 * @throws \InvalidArgumentException
	 *
	 * @return int
	 */
	public function getIdByIso($isoCode) {
		$match = ['DE' => 1, 'AT' => 2, 'CH' => 3];

		$isoCode = strtoupper($isoCode);
		if (array_key_exists($isoCode, $match)) {
			return $match[$isoCode];
		}

		throw new InvalidArgumentException('ISO code not valid: ' . $isoCode);
	}

	/**
	 * @param int $id
	 * @param string $default
	 *
	 * @return mixed|string
	 */
	public function getIsoById($id, $default = '') {
		$match = [1 => 'DE', 2 => 'AT', 3 => 'CH'];

		if (array_key_exists($id, $match)) {
			return $match[$id];
		}

		return $default;
	}

	/**
	 * @return int
	 */
	public function getDefaultCountry() {
		return $this->getIdByIso(Configure::read('Data.defaultCountryCode', 'DE'));
	}

	/**
	 * @var int
	 */
	public const STATUS_ACTIVE = 1;

	/**
	 * @var int
	 */
	public const STATUS_INACTIVE = 0;

}
