<?php
namespace Data\Model\Table;

//use Tools\Lib\GeocodeLib;
use Tools\Model\Table\Table;

/**
 * @deprecated - use State instead
 */
class CountryProvincesTable extends Table {

	public $order = ['name' => 'ASC'];

	public $validate = [
		'country_id' => ['numeric'],
		'abbr' => [
			'validateUnique' => [
				'rule' => ['validateUnique', ['country_id']],
				'message' => 'this kind of record already exists for this country',
				'allowEmpty' => true
			],
		],
		'name' => [
			'notBlank' => [
				'rule' => ['notBlank'],
				'message' => 'valErrMandatoryField',
				'last' => true
			],
			'isUnique' => [
				'rule' => ['validateUnique', ['country_id']],
				'message' => 'this kind of record already exists for this country',
			],
		],
	];

	public $belongsTo = [
		'Country' => [
			'className' => 'Data.Country',
			'foreignKey' => 'country_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		]
	];

	public function getListByCountry($cid = null) {
		if (empty($cid)) {
			return [];
		}
		return $this->find('list', [
			'conditions' => ['country_id' => $cid],
			//'order' => array($this->alias.'.name'=>'ASC')
		]);
	}

	public $filterArgs = [
		'search' => ['type' => 'like', 'field' => ['name', 'code']],
		'active' => ['type' => 'value'],
		'country_id'=> ['type' => 'value']
	];

	/**
	 * Lat and lng + abbr if available!
	 *
	 * @param id
	 * - NULL: update all records with missing coordinates only
	 * - otherwise: specific update
	 */
	public function updateCoordinates($id = null) {
		$geocoder = new GeocodeLib();

		$override = false;
		if ($id == -1) {
			$id = '';
			$override = true;
		}

		if (!empty($id)) {
			$res = $this->find('first', ['conditions' => [$this->alias() . '.id' => $id], 'contain' => ['Country.name']]);
			if (!empty($res['name']) && !empty($res[$this->Country->alias]['name']) && $geocoder->geocode($res['name'] .
				', ' . $res[$this->Country->alias]['name'])) {

				$data = $geocoder->getResult();
				//pr($data); die();
				$saveArray = ['id' => $id, 'lat' => $data['lat'], 'lng' => $data['lng'], 'country_id' => $res['country_id']];

				if (!empty($data['country_province_code']) && mb_strlen($data['country_province_code']) <= 3 && preg_match('/^([A-Z])*$/', $data['country_province_code'])) {
					$saveArray['abbr'] = $data['country_province_code'];
				}

				$this->id = $id;
				if (!$this->save($saveArray, true, ['id', 'lat', 'lng', 'abbr', 'country_id'])) {
					if ($data['country_province_code'] !== 'DC') {
						/*
						echo returns($this->id);
						pr($res);
						pr($data);
						pr($saveArray);
						die(returns($this->validationErrors));
						*/
						throw new \Exception('Update Error');
					}
				}
				return true;
			}
		} else {

			$conditions = [];
			if (!$override) {
				$conditions = [$this->alias() . '.lat' => 0, $this->alias() . '.lng' => 0];
			}

			$results = $this->find('all', ['conditions' => $conditions, 'contain' => ['Country.name'], 'order' => ['CountryProvince.modified' =>
				'ASC']]);
			$count = 0;

			foreach ($results as $res) {
				if (!empty($res['name']) && !empty($res[$this->Country->alias]['name']) && $geocoder->geocode($res['name'] .
					', ' . $res[$this->Country->alias]['name'])) {

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
							$this->log('Abbr for country province \'' . $data['country_province'] . '\' changed from \'' . $res['abbr'] . '\' to \'' . $saveArray['abbr'] .
								'\'', LOG_NOTICE);
						}

					} else {
						//pr($data); pr($geocoder->debug()); die();

						if ($data['country_province_code'] !== 'DC') {
							echo returns($this->id);
							pr($res);
							pr($data);
							pr($saveArray);
							die(returns($this->validationErrors));
						}
					}
					$geocoder->pause();
				}
			}

			return $count;
		}

		return false;
	}

	public function afterSave($created, $options = []) {
		if ($created) {
			$this->updateCoordinates($this->id);
		}
	}

}
