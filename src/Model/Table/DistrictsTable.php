<?php

namespace Data\Model\Table;

use ArrayObject;
use Cake\Event\EventInterface;
use Tools\Model\Table\Table;

/**
 * @property \Data\Model\Table\CitiesTable|\Cake\ORM\Association\BelongsTo $Cities
 *
 * @deprecated Use only Countries => States => Cities
 */
class DistrictsTable extends Table {

	/**
	 * @var array
	 */
	public $actsAs = ['Geo.Geocoder' => [
		'min_accuracy' => 3, 'address' => ['address'], 'before' => 'save', 'real' => false, 'required' => false,
	], 'Tools.Slugged' => ['mode' => 'ascii', 'case' => 'low']];

	/**
	 * @var array
	 */
	protected $order = ['name' => 'ASC'];

	/**
	 * @var array
	 */
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

	/**
	 * @var array
	 */
	public $belongsTo = [
		'City' => [
			'className' => 'Data.City',
			'foreignKey' => 'city_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
		],
	];

	/**
	 * @param \Cake\Event\EventInterface $event
	 * @param \ArrayObject $data
	 * @param \ArrayObject $options
	 *
	 * @return void
	 */
	public function beforeMarshal(EventInterface $event, ArrayObject $data, ArrayObject $options) {
		if (!empty($data['name']) && !empty($data['city_id'])) {
			$city = $this->Cities->fieldByConditions('name', ['id' => $data['city_id']]);
			$data['address'] = $data['name'] . ', ' . $city;
		}
	}

	/**
	 * For start page
	 *
	 * @param string $citySlug
	 * @param string $type
	 * @return \Cake\ORM\Query
	 */
	public function getDistrictsByCity($citySlug, $type = 'all') {
		$options = [
			'contain' => ['Cities'],
			'conditions' => [
				//$this->alias.'.lat <>' => 0,
				//$this->alias.'.lng <>' => 0,
				$this->Cities->getAlias() . '.slug' => $citySlug,
			],
			'fields' => [$this->getAlias() . '.slug', $this->getAlias() . '.name'],
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
				$this->getAlias() . '.slug' => $slug,
			],
		];
		if (!empty($customOptions)) {
			$options = array_merge($options, $customOptions);
		}

		return $this->find('all', $options)->first();
	}

}
