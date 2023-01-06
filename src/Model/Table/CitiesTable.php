<?php

namespace Data\Model\Table;

use Cake\Core\Configure;
use Tools\Model\Table\Table;

/**
 * @property \Data\Model\Table\CountriesTable&\Cake\ORM\Association\BelongsTo $Countries
 *
 * @method \Data\Model\Entity\City newEmptyEntity()
 * @method \Data\Model\Entity\City newEntity(array $data, array $options = [])
 * @method array<\Data\Model\Entity\City> newEntities(array $data, array $options = [])
 * @method \Data\Model\Entity\City get($primaryKey, $options = [])
 * @method \Data\Model\Entity\City findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Data\Model\Entity\City patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\Data\Model\Entity\City> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Data\Model\Entity\City|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Data\Model\Entity\City saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\City>|false saveMany(iterable $entities, $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\City> saveManyOrFail(iterable $entities, $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\City>|false deleteMany(iterable $entities, $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\City> deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Tools\Model\Behavior\SluggedBehavior
 */
class CitiesTable extends Table {

	/**
	 * @var array<int|string, mixed>
	 */
	protected array $order = ['name' => 'ASC'];

	/**
	 * @var array
	 */
	public $validate = [
		'name' => [
			'notBlank',
		],
	];

	/**
	 * @param array $config
	 *
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		$this->addBehavior('Tools.Slugged', ['label' => 'name', 'mode' => 'ascii', 'case' => 'low', 'unique' => true, 'overwrite' => false]);

		if (Configure::read('Data.City.District') !== false) {
			$this->hasMany('District', [
				'className' => 'Data.District',
			]);
		}

		$this->belongsTo('Countries', [
			'className' => 'Data.Countries',
		]);

		if (Configure::read('Data.City.County') !== false) {
			$this->belongsTo('Counties', [
				'className' => 'Data.District',
			]);
		}
	}

	/**
	 * @param string $name
	 *
	 * @return \Cake\ORM\Query\SelectQuery
	 */
	public function autoCompleteName($name) {
		$options = [
			'conditions' => [
				$this->getAlias() . '.name LIKE' => $name . '%',
			],
			'fields' => ['id', 'postal_code', 'name'],
		];

		return $this->find('all', $options);
	}

	/**
	 * @param int $country
	 * @param int $limit
	 *
	 * @return \Cake\ORM\Query\SelectQuery
	 */
	public function largeCities($country, $limit = 0) {
		$options = [
			'conditions' => [$this->getAlias() . '.country_id' => $country],
			'order' => [$this->getAlias() . '.citizens' => 'desc'],
			'limit' => $limit,
		];

		return $this->find('all', $options);
	}

	/**
	 * @param string $postalCode
	 *
	 * @return \Cake\ORM\Query\SelectQuery|null
	 */
	public function getCitiesToPostalCode($postalCode) {
		preg_match("/\d+/", $postalCode, $matches);
		if (!isset($matches[0]) || strlen($matches[0]) !== 5) {
			return null;
		}

		return $this->find('all', ['conditions' => ['Cities.postal_code LIKE' => $matches[0]]]);
	}

	/**
	 * @param string $postalCode
	 *
	 * @return \Cake\Datasource\EntityInterface|null
	 */
	public function getCityToPostalCode($postalCode) {
		$result = $this->getCitiesToPostalCode($postalCode);

		return $result ? $result->first() : null;
	}

}
