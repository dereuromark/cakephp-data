<?php

namespace Data\Model\Table;

use ArrayObject;
use Cake\Event\EventInterface;
use Tools\Model\Table\Table;

/**
 * @property \Data\Model\Table\CitiesTable $Cities
 *
 * @deprecated Use only Countries => States => Cities
 */
class DistrictsTable extends Table {

	/**
	 * @var array<int|string, mixed>
	 */
	protected array $order = ['name' => 'ASC'];

	/**
	 * @var array
	 */
	public array $validate = [
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
	 * @param array $config
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		$this->addBehavior('Geo.Geocoder', [
			'min_accuracy' => 3,
			'address' => ['address'],
			'before' => 'save',
			'real' => false,
			'required' => false,
		]);
		$this->addBehavior('Tools.Slugged', ['mode' => 'ascii', 'case' => 'low']);

		$this->belongsTo('Cities', [
			'className' => 'Data.Cities',
			'foreignKey' => 'city_id',
		]);
	}

	/**
	 * @param \Cake\Event\EventInterface $event
	 * @param \ArrayObject $data
	 * @param \ArrayObject $options
	 *
	 * @return void
	 */
	public function beforeMarshal(EventInterface $event, ArrayObject $data, ArrayObject $options): void {
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
	 * @return \Cake\ORM\Query\SelectQuery
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

		return $this->find('all', ...$options)->first();
	}

}
