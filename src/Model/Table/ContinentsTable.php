<?php

namespace Data\Model\Table;

use ArrayObject;
use Cake\Event\EventInterface;
use Tools\Model\Table\Table;

/**
 * @extends \Tools\Model\Table\Table<array{Tree: \Cake\ORM\Behavior\TreeBehavior}, \Data\Model\Entity\Continent>
 * @property \Cake\ORM\Association\BelongsTo<\Data\Model\Table\ContinentsTable> $ParentContinents
 * @property \Cake\ORM\Association\HasMany<\Data\Model\Table\ContinentsTable> $ChildContinents
 * @property \Cake\ORM\Association\HasMany<\Data\Model\Table\CountriesTable> $Countries
 * @method \Data\Model\Entity\Continent newEmptyEntity()
 * @method \Data\Model\Entity\Continent newEntity(array $data, array $options = [])
 * @method array<\Data\Model\Entity\Continent> newEntities(array $data, array $options = [])
 * @method \Data\Model\Entity\Continent get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \Data\Model\Entity\Continent findOrCreate(\Cake\ORM\Query\SelectQuery|callable|array $search, ?callable $callback = null, array $options = [])
 * @method \Data\Model\Entity\Continent patchEntity(\Data\Model\Entity\Continent $entity, array $data, array $options = [])
 * @method array<\Data\Model\Entity\Continent> patchEntities(iterable<\Data\Model\Entity\Continent> $entities, array $data, array $options = [])
 * @method \Data\Model\Entity\Continent|false save(\Data\Model\Entity\Continent $entity, array $options = [])
 * @method \Data\Model\Entity\Continent saveOrFail(\Data\Model\Entity\Continent $entity, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\Continent>|false saveMany(iterable<\Data\Model\Entity\Continent> $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\Continent> saveManyOrFail(iterable<\Data\Model\Entity\Continent> $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\Continent>|false deleteMany(iterable<\Data\Model\Entity\Continent> $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\Continent> deleteManyOrFail(iterable<\Data\Model\Entity\Continent> $entities, array $options = [])
 * @method bool delete(\Data\Model\Entity\Continent $entity, array $options = [])
 * @method bool deleteOrFail(\Data\Model\Entity\Continent $entity, array $options = [])
 * @method \Data\Model\Entity\Continent|array<\Data\Model\Entity\Continent> loadInto(\Data\Model\Entity\Continent|array<\Data\Model\Entity\Continent> $entities, array $contain)
 * @mixin \Cake\ORM\Behavior\TreeBehavior
 */
class ContinentsTable extends Table {

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
		'ori_name' => [
			'notBlank' => [
				'rule' => ['notBlank'],
				'message' => 'valErrMandatoryField',
			],
		],
		'status' => [
			'numeric' => [
				'rule' => ['numeric'],
				'message' => 'valErrMandatoryField',
			],
		],
	];

	/**
	 * @param array $config
	 *
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		$this->addBehavior('Tree');

		$this->belongsTo('ParentContinents', [
			'className' => 'Data.Continents',
			'foreignKey' => 'parent_id',
		]);

		$this->hasMany('ChildContinents', [
			'className' => 'Data.Continents',
			'foreignKey' => 'parent_id',
			'dependent' => false,
		]);

		$this->hasMany('Countries', [
			'className' => 'Data.Countries',
			'foreignKey' => 'continent_id',
			'dependent' => false,
		]);
	}

	/**
	 * @param \Cake\Event\EventInterface $event
	 * @param \ArrayObject $data
	 * @param \ArrayObject $options
	 * @return void
	 */
	public function beforeMarshal(EventInterface $event, ArrayObject $data, ArrayObject $options): void {
		if (isset($data['code'])) {
			$data['code'] = mb_strtoupper((string)$data['code']);
		}
	}

}
