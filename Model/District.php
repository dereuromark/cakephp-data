<?php
App::uses('DataAppModel', 'Data.Model');

class District extends DataAppModel {

	public $actsAs = ['Tools.Geocoder' => [
		'min_accuracy' => 3, 'address' => ['address'], 'before' => 'save', 'real' => false, 'required' => false
	], 'Data.Slugged' => ['mode' => 'ascii', 'case' => 'low']];

	public $order = ['District.name' => 'ASC'];

	public $validate = [
		'name' => [
			'notEmpty' => [
				'rule' => ['notEmpty'],
				'message' => 'valErrMandatoryField',
			],
		],
		'city_id' => [
			'numeric' => [
				'rule' => ['numeric'],
				'message' => 'valErrMandatoryField',
			],
		],
	];

	public $belongsTo = [
		'City' => [
			'className' => 'Data.City',
			'foreignKey' => 'city_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		]
	];

	/**
	 * District::beforeValidate()
	 *
	 * @param array $options
	 * @return bool Success
	 */
	public function beforeValidate($options = []) {
		parent::beforeValidate($options);

		if (!empty($this->data[$this->alias]['name']) && !empty($this->data[$this->alias]['city_id'])) {
			$city = $this->City->fieldByConditions('name', ['id' => $this->data[$this->alias]['city_id']]);
			$this->data[$this->alias]['address'] = $this->data[$this->alias]['name'] . ', ' . $city;
		}

		return true;
	}

	/**
	 * For start page
	 *
	 * @return array
	 */
	public function getDistrictsByCity($citySlug, $type = 'all') {
		$options = [
			'contain' => ['City.slug'],
			'conditions' => [
				//$this->alias.'.lat <>' => 0,
				//$this->alias.'.lng <>' => 0,
				$this->City->alias . '.slug' => $citySlug,
			],
			'fields' => [$this->alias . '.slug', $this->alias . '.name'],
		];
		return $this->find($type, $options);
	}

	/**
	 * District::getIdBySlug()
	 *
	 * @param string $slug
	 * @param array $customOptions
	 * @return array
	 */
	public function getIdBySlug($slug, $customOptions = []) {
		$options = [
			'conditions' => [
				$this->alias . '.slug' => $slug,
			]
		];
		if (!empty($customOptions)) {
			$options = array_merge($options, $customOptions);
		}
		return $this->find('first', $options);
	}

}
