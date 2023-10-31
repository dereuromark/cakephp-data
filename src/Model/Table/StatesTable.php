<?php

namespace Data\Model\Table;

use ArrayObject;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Event\EventInterface;
use Cake\Http\Exception\InternalErrorException;
use Data\Model\Entity\State;
use Geo\Geocoder\Geocoder;
use Tools\Model\Table\Table;

/**
 * @mixin \Search\Model\Behavior\SearchBehavior
 * @method \Data\Model\Entity\State get($primaryKey, $options = [])
 * @method \Data\Model\Entity\State newEntity(array $data, array $options = [])
 * @method array<\Data\Model\Entity\State> newEntities(array $data, array $options = [])
 * @method \Data\Model\Entity\State|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Data\Model\Entity\State saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Data\Model\Entity\State patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\Data\Model\Entity\State> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Data\Model\Entity\State findOrCreate($search, ?callable $callback = null, $options = [])
 * @mixin \Tools\Model\Behavior\SluggedBehavior
 * @property \Data\Model\Table\CountriesTable&\Cake\ORM\Association\BelongsTo $Countries
 * @method \Data\Model\Entity\State newEmptyEntity()
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\State>|false saveMany(iterable $entities, $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\State> saveManyOrFail(iterable $entities, $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\State>|false deleteMany(iterable $entities, $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\State> deleteManyOrFail(iterable $entities, $options = [])
 * @property \Cake\ORM\Table&\Cake\ORM\Association\HasMany $Counties
 */
class StatesTable extends Table {

	/**
	 * @var array<int|string, mixed>
	 */
	protected array $order = ['name' => 'ASC'];

	/**
	 * @var array
	 */
	public $validate = [
		'country_id' => ['numeric'],
		'code' => [
			'validateUnique' => [
				'rule' => ['validateUnique', ['scope' => ['country_id']]],
				'message' => 'valErrRecordNameExists',
				'allowEmpty' => true,
				'provider' => 'table',
			],
		],
		'name' => [
			'notBlank' => [
				'rule' => ['notBlank'],
				'message' => 'valErrMandatoryField',
				'last' => true,
			],
			'isUnique' => [
				'rule' => ['validateUnique', ['scope' => ['country_id']]],
				'message' => 'valErrRecordNameExists',
				'provider' => 'table',
			],
		],
	];

	/**
	 * @var array
	 */
	public $belongsTo = [
		'Country' => [
			'className' => 'Data.Country',
			'foreignKey' => 'country_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
		],
	];

	/**
	 * @param array $config
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		$this->addBehavior('Tools.Slugged', ['case' => 'low', 'mode' => 'ascii', 'unique' => false, 'overwrite' => false]);

		if (Configure::read('Data.State.County') !== false) {
			$this->hasMany('Counties', [
				'className' => 'Data.County',
			]);
		}

		if (!Plugin::isLoaded('Search')) {
			return;
		}

		$this->addBehavior('Search.Search');
		$this->searchManager()
			->value('country_id')
			->like('search', ['fields' => ['name', 'code']]);
	}

	/**
	 * @param \Cake\Event\EventInterface $event
	 * @param \ArrayObject $data
	 * @param \ArrayObject $options
	 * @return void
	 */
	public function beforeMarshal(EventInterface $event, ArrayObject $data, ArrayObject $options) {
		if (isset($data['code'])) {
			$data['code'] = mb_strtoupper($data['code']);
		}
	}

	/**
	 * @param array $conditions
	 *
	 * @throws \Cake\Http\Exception\InternalErrorException
	 *
	 * @return int
	 */
	public function getStateId(array $conditions) {
		$id = $this->fieldByConditions('id', $conditions);
		if ($id) {
			return $id;
		}

		$state = $this->newEntity($conditions);

		if ($this->save($state)) {
			return $state->id;
		}

		throw new InternalErrorException(json_encode($state->getErrors()) ?: 'Unknown error');
	}

	/**
	 * @param int $cid
	 *
	 * @return array
	 */
	public function getListByCountry($cid) {
		if (empty($cid)) {
			return [];
		}

		return $this->find('list', [
			'conditions' => [$this->getAlias() . '.country_id' => $cid],
			'order' => [$this->getAlias() . '.name' => 'ASC'],
		])->toArray();
	}

	/**
	 * Lat and lng + code if available!
	 *
	 * @param \Data\Model\Entity\State $state
	 *
	 * @return \Data\Model\Entity\State|int|null
	 */
	public function updateCoordinates(State $state) {
		$geocoder = new Geocoder();

		$override = false;
		if ($state->id == -1) {
			$id = '';
			$override = true;
		}

		if (!empty($id)) {
			/** @var \Data\Model\Entity\State|null $res */
			$res = $this->find('all', ['conditions' => [$this->getAlias() . '.id' => $id], 'contain' => ['Countries']])->first();
			if ($res && $res->name && $res->country && $res->country->name) {
				$data = $geocoder->geocode($res['name'] . ', ' . $res->country->name);
				$data = $data->first();
				$coordinates = $data->getCoordinates();
				if ($coordinates) {
					$saveArray = ['lat' => $coordinates->getLatitude(), 'lng' => $coordinates->getLongitude(), 'country_id' => $res['country_id']];

					if (!empty($data['country_province_code']) && mb_strlen($data['country_province_code']) <= 3 && preg_match('/^([A-Z])*$/', $data['country_province_code'])) {
						$saveArray['code'] = $data['country_province_code'];
					}

					$state = $this->patchEntity($res, $saveArray);
					if (!$this->save($state)) {
						if ($data->getCountry()?->getCode() !== 'DC') {
							//fixme
						}
					}
				}

				return $state;
			}
		} else {

			$conditions = [];
			if (!$override) {
				$conditions = [$this->getAlias() . '.lat' => 0, $this->getAlias() . '.lng' => 0];
			}

			/** @var \Data\Model\Entity\State[] $results */
			$results = $this->find('all', ['conditions' => $conditions, 'contain' => ['Countries.name'], 'order' => [
			'modified' =>
				'ASC']]);
			$count = 0;

			foreach ($results as $res) {
				if ($res->name && $res->country && !empty($res->country->name)) {
					$result = $geocoder->geocode($res->name . ', ' . $res->country->name);
					$data = $result->first();
					$coordinates = $data->getCoordinates();

					$saveArray = ['country_id' => $res->country_id];
					if ($coordinates) {
						$saveArray = ['lat' => $coordinates->getLatitude(), 'lng' => $coordinates->getLongitude()] + $saveArray;
					}

					//FIXME
					/*
					if (!empty($data['country_province_code']) && mb_strlen($data['country_province_code']) <= 3 && preg_match('/^([A-Z])*$/', $data['country_province_code'])) {
						$saveArray['code'] = $data['country_province_code'];
					}
					*/

					$state = $this->patchEntity($res, $saveArray);
					if ($this->save($state)) {
						$count++;

						/*
						if (!empty($saveArray['code']) && $saveArray['code'] !== $res->code) {
							//$this->log('Code for state \'' . $data['country_province'] . '\' changed from \'' . $res['code'] . '\' to \'' . $saveArray['code'] .'\'', LOG_NOTICE);
						}
						*/

					} else {
						//pr($data); pr($geocoder->debug()); die();

						if ($data->getCountry()?->getCode() !== 'DC') { // ['country_province_code']
							//echo returns($this->id);
							//pr($res);
							//pr($data);
							//pr($saveArray);
							//die(returns($this->validationErrors));
						}
					}
				}
			}

			return $count;
		}

		return null;
	}

}
