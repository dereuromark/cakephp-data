<?php
namespace Data\Model\Table;

use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Network\Exception\InternalErrorException;
use Geo\Geocoder\Geocoder;
use Tools\Model\Table\Table;

/**
 * @mixin \Search\Model\Behavior\SearchBehavior
 * @method \Data\Model\Entity\State get($primaryKey, $options = [])
 * @method \Data\Model\Entity\State newEntity($data = null, array $options = [])
 * @method \Data\Model\Entity\State[] newEntities(array $data, array $options = [])
 * @method \Data\Model\Entity\State|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Data\Model\Entity\State|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Data\Model\Entity\State patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Data\Model\Entity\State[] patchEntities($entities, array $data, array $options = [])
 * @method \Data\Model\Entity\State findOrCreate($search, callable $callback = null, $options = [])
 * @mixin \Tools\Model\Behavior\SluggedBehavior
 */
class StatesTable extends Table {

	/**
	 * @var array
	 */
	public $actsAs = ['Tools.Slugged' => ['case' => 'low', 'mode' => 'ascii', 'unique' => false, 'overwrite' => false]];

	/**
	 * @var array
	 */
	public $order = ['name' => 'ASC'];

	/**
	 * @var array
	 */
	public $validate = [
		'country_id' => ['numeric'],
		'abbr' => [
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
				'last' => true
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
	public $hasMany = [
		'County' => [
			'className' => 'Data.County',
			'foreignKey' => 'state_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
		]
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
			'order' => ''
		]
	];

	/**
	 * @param array $config
	 */
	public function __construct(array $config = []) {
		if (Configure::read('Data.State.County') === false) {
			unset($this->hasMany['County']);
		}

		parent::__construct($config);
	}

	/**
	 * @param array $config
	 * @return void
	 */
	public function initialize(array $config) {
		parent::initialize($config);

		if (!Plugin::loaded('Search')) {
			return;
		}

		$this->addBehavior('Search.Search');
		$this->searchManager()
			->value('country_id')
			->like('search', ['field' => ['name', 'abbr']]);
	}

	/**
	 * @param array $conditions
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

		throw new InternalErrorException(returns($state->errors()));
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
			'conditions' => [$this->alias() . '.country_id' => $cid],
			'order' => [$this->alias() . '.name' => 'ASC']
		])->toArray();
	}

	/**
	 * Lat and lng + abbr if available!
	 *
	 * @param int|null $id
	 * @return int|bool
	 */
	public function updateCoordinates($id = null) {
		$geocoder = new Geocoder();

		$override = false;
		if ($id == -1) {
			$id = '';
			$override = true;
		}

		if (!empty($id)) {
			$res = $this->find('first', ['conditions' => [$this->alias() . '.id' => $id], 'contain' => ['Country.name']]);
			if (!empty($res['name']) && !empty($res->countries['name']) && $geocoder->geocode($res['name'] .
				', ' . $res->countries['name'])) {

				$data = $geocoder->getResult();
				//pr($data); die();
				$saveArray = ['id' => $id, 'lat' => $data['lat'], 'lng' => $data['lng'], 'country_id' => $res['country_id']];

				if (!empty($data['country_province_code']) && mb_strlen($data['country_province_code']) <= 3 && preg_match('/^([A-Z])*$/', $data['country_province_code'])) {
					$saveArray['abbr'] = $data['country_province_code'];
				}

				$this->id = $id;
				if (!$this->save($saveArray, true, ['id', 'lat', 'lng', 'abbr', 'country_id'])) {
					if ($data['country_province_code'] !== 'DC') {
						echo returns($this->id);
						pr($res);
						pr($data);
						pr($saveArray);
						exit(returns($this->validationErrors));
					}
				}
				return true;
			}
		} else {

			$conditions = [];
			if (!$override) {
				$conditions = [$this->alias() . '.lat' => 0, $this->alias() . '.lng' => 0];
			}

			$results = $this->find('all', ['conditions' => $conditions, 'contain' => ['Country.name'], 'order' => ['modified' =>
				'ASC']]);
			$count = 0;

			foreach ($results as $res) {
				if (!empty($res['name']) && !empty($res->countries['name']) && $geocoder->geocode($res['name'] .
					', ' . $res->countries['name'])) {

					$data = $geocoder->getResult();
					//pr($data); die();
					//pr ($geocoder->debug());
					$saveArray = ['id' => $res['id'], 'country_id' => $res['country_id']];
					if (isset($data['lat']) && isset($data['lng'])) {
						$saveArray = array_merge($saveArray, ['lat' => $data['lat'], 'lng' => $data['lng']]);
					}

					if (!empty($data['country_province_code']) && mb_strlen($data['country_province_code']) <= 3 && preg_match('/^([A-Z])*$/', $data['country_province_code'])) {
						$saveArray['abbr'] = $data['country_province_code'];
					}

					$this->id = $res['id'];
					if ($this->save($saveArray, true, ['lat', 'lng', 'abbr', 'country_id'])) {
						$count++;

						if (!empty($saveArray['abbr']) && $saveArray['abbr'] != $res['abbr']) {
							//$this->log('Abbr for country province \'' . $data['country_province'] . '\' changed from \'' . $res['abbr'] . '\' to \'' . $saveArray['abbr'] .'\'', LOG_NOTICE);
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
					$geocoder->pause();
				}
			}

			return $count;
		}

		return false;
	}

}
