<?php

namespace Data\Model\Table;

use ArrayObject;
use Cake\Event\EventInterface;
use Tools\Model\Table\Table;

/**
 * @property \Data\Model\Table\ContinentsTable|\Cake\ORM\Association\BelongsTo $ParentContinents
 * @property \Cake\ORM\Table|\Cake\ORM\Association\HasMany $ChildContinents
 * @property \Cake\ORM\Table|\Cake\ORM\Association\HasMany $Countries
 *
 * @mixin \Cake\ORM\Behavior\TreeBehavior
 * @method \Data\Model\Entity\Continent newEmptyEntity()
 * @method \Data\Model\Entity\Continent newEntity(array $data, array $options = [])
 * @method array<\Data\Model\Entity\Continent> newEntities(array $data, array $options = [])
 * @method \Data\Model\Entity\Continent get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \Data\Model\Entity\Continent findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \Data\Model\Entity\Continent patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\Data\Model\Entity\Continent> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Data\Model\Entity\Continent|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \Data\Model\Entity\Continent saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\Continent>|false saveMany(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\Continent> saveManyOrFail(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\Continent>|false deleteMany(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\Continent> deleteManyOrFail(iterable $entities, array $options = [])
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
			$data['code'] = mb_strtoupper($data['code']);
		}
	}

}
