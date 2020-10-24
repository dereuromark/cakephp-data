<?php

namespace Data\Model\Table;

use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Http\Exception\InternalErrorException;
use Data\Model\Entity\State;
use Geo\Geocoder\Geocoder;
use Tools\Model\Table\Table;

/**
 * @mixin \Search\Model\Behavior\SearchBehavior
 * @method \Data\Model\Entity\State get($primaryKey, $options = [])
 * @method \Data\Model\Entity\State newEntity(array $data, array $options = [])
 * @method \Data\Model\Entity\State[] newEntities(array $data, array $options = [])
 * @method \Data\Model\Entity\State|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Data\Model\Entity\State saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Data\Model\Entity\State patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Data\Model\Entity\State[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Data\Model\Entity\State findOrCreate($search, ?callable $callback = null, $options = [])
 * @mixin \Tools\Model\Behavior\SluggedBehavior
 * @property \Data\Model\Table\CountriesTable&\Cake\ORM\Association\BelongsTo $Countries
 * @method \Data\Model\Entity\State newEmptyEntity()
 * @method \Data\Model\Entity\State[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Data\Model\Entity\State[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Data\Model\Entity\State[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Data\Model\Entity\State[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class StatesTable extends Table {

	/**
	 * @var array
	 */
	public $order = ['name' => 'ASC'];

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
	 * @param array $conditions
	 *
	 * @throws \Cake\Http\Exception\InternalErrorException
	 *
	 * @return int
	 */
	public function getStateId($conditions) {
		$id = $this->fieldByConditions('id', $conditions);
		if ($id) {
			return $id;
		}

		$state = $this->newEntity($conditions);

		if ($this->save($state)) {
			return $state->id;
		}

		throw new InternalErrorException(json_encode($state->getErrors()));
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
			$res = $this->find('all', ['conditions' => [$this->getAlias() . '.id' => $id], 'contain' => ['Countries']])->first();
			if (!empty($res['name']) && !empty($res->country->name) && $geocoder->geocode($res['name'] .
				', ' . $res->country->name)) {

				$data = $geocoder->getResult();
				$saveArray = ['lat' => $data['lat'], 'lng' => $data['lng'], 'country_id' => $res['country_id']];

				if (!empty($data['country_province_code']) && mb_strlen($data['country_province_code']) <= 3 && preg_match('/^([A-Z])*$/', $data['country_province_code'])) {
					$saveArray['code'] = $data['country_province_code'];
				}

				$state = $this->patchEntity($res, $saveArray);
				if (!$this->save($state)) {
					if ($data['country_province_code'] !== 'DC') {
						//fixme
					}
				}

				return $state;
			}
		} else {

			$conditions = [];
			if (!$override) {
				$conditions = [$this->getAlias() . '.lat' => 0, $this->getAlias() . '.lng' => 0];
			}

			$results = $this->find('all', ['conditions' => $conditions, 'contain' => ['Country.name'], 'order' => [
'modified' =>
				'ASC']]);
			$count = 0;

			foreach ($results as $res) {
				if (!empty($res['name']) && !empty($res->country->name) && $geocoder->geocode($res['name'] .
					', ' . $res->country->name)) {

					$data = $geocoder->getResult();
					//pr($data); die();
					//pr ($geocoder->debug());
					$saveArray = ['country_id' => $res['country_id']];
					if (isset($data['lat']) && isset($data['lng'])) {
						$saveArray = ['lat' => $data['lat'], 'lng' => $data['lng']] + $saveArray;
					}

					if (!empty($data['country_province_code']) && mb_strlen($data['country_province_code']) <= 3 && preg_match('/^([A-Z])*$/', $data['country_province_code'])) {
						$saveArray['code'] = $data['country_province_code'];
					}

					$state = $this->patchEntity($res, $saveArray);
					if ($this->save($state)) {
						$count++;

						if (!empty($saveArray['code']) && $saveArray['code'] !== $res['code']) {
							//$this->log('Code for state \'' . $data['country_province'] . '\' changed from \'' . $res['code'] . '\' to \'' . $saveArray['code'] .'\'', LOG_NOTICE);
						}

					} else {
						//pr($data); pr($geocoder->debug()); die();

						if ($data['country_province_code'] !== 'DC') {
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
