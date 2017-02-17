<?php
namespace Data\Model\Table;

use Tools\Model\Table\Table;

class DistrictsTable extends Table {

	public $actsAs = ['Geo.Geocoder' => [
		'min_accuracy' => 3, 'address' => ['address'], 'before' => 'save', 'real' => false, 'required' => false
	], 'Tools.Slugged' => ['mode' => 'ascii', 'case' => 'low']];

	public $order = ['name' => 'ASC'];

	public $validate = [
		'name' => [
			'notBlank' => [
				'rule' => ['notBlank'],
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

		if (!empty($this->data['name']) && !empty($this->data['city_id'])) {
			$city = $this->Cities->fieldByConditions('name', ['id' => $this->data['city_id']]);
			$this->data['address'] = $this->data['name'] . ', ' . $city;
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
			'contain' => ['Cities'],
			'conditions' => [
				//$this->alias.'.lat <>' => 0,
				//$this->alias.'.lng <>' => 0,
				$this->Cities->alias() . '.slug' => $citySlug,
			],
			'fields' => [$this->alias() . '.slug', $this->alias() . '.name'],
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
				$this->alias() . '.slug' => $slug,
			]
		];
		if (!empty($customOptions)) {
			$options = array_merge($options, $customOptions);
		}
		return $this->find('first', $options);
	}

}
