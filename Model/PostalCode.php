<?php
App::uses('DataAppModel', 'Data.Model');

class PostalCode extends DataAppModel {

	public $displayField = 'code';

	public $order = ['PostalCode.code' => 'ASC'];

	public $actsAs = ['Tools.Geocoder' => ['min_accuracy' => 2, 'address' => ['code', 'country_name'], 'formatted_address' => 'official_address', 'real' => false, 'before' => 'validate', 'allow_inconclusive' => true]];

	public $validate = [
		'code' => ['notEmpty'],
		'official_address' => [
			'notEmpty' => [
				'rule' => ['notEmpty'],
				'message' => 'valErrMandatoryField',
				'last' => true
			],
			'validateUnique' => [
				'rule' => ['validateUnique', ['country_id', 'code']],
				'message' => 'valErrRecordNameExists',
				'last' => true,
			],
		],
	];

	public $filterArgs = [
		'code' => ['type' => 'like', 'before' => false, 'after' => false],
		'country' => ['type' => 'value'],
	];

	public function findNearest($lat, $lng, $type = 'all', $options = []) {
		$this->virtualFields = ['distance' => $this->_latLng($lat, $lng)];
		$options['conditions']['OR'] = [$this->alias . '.lat<>0', $this->alias . '.lng<>0'];
		$options['order'] = ['distance' => 'ASC'];

		return $this->find($type, $options);
	}

	public function _latLng($lat, $lng) {
		return '6371.04 * ACOS( COS( PI()/2 - RADIANS(90 - ' . $this->alias . '.lat)) * ' .
			'COS( PI()/2 - RADIANS(90 - ' . $lat . ')) * ' .
			'COS( RADIANS(' . $this->alias . '.lng) - RADIANS(' . $lng . ')) + ' .
			'SIN( PI()/2 - RADIANS(90 - ' . $this->alias . '.lat)) * ' .
			'SIN( PI()/2 - RADIANS(90 - ' . $lat . '))) ';
	}

	public function searchLocation($code, $countryId = null, $options = []) {
		if (!empty($options['exact'])) {
			if (!empty($options['term'])) {
				$term = sprintf($options['term'], $code);
			} else {
				$term = $code . '%';
			}
			$search = ['PostalCode.code LIKE' => "$term"];
		} else {
			$search = ['PostalCode.code' => $code];
		}

		if ($countryId) {
			$search['PostalCode.country_id'] = (int)$country;
		}

		$options = [
			//'fields' => array('Company.*'),
			'conditions' => $search,
			'limit' => 15,
			//'order'=>'Company.name',
			'contain' => []
		];
		return $this->find('all', $options);
	}

	/**
	 * Postal codes per country
	 */
	public function stats() {
		$res = [];

		$list = $this->find('all', ['fields' => ['COUNT(*) as count', 'country_id'], 'group' => 'country_id']);

		foreach ($list as $x) {
			$res[$x[$this->alias]['country_id']] = $x[0]['count'];
		}

		return $res;
	}

}
