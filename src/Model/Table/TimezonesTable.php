<?php
declare(strict_types = 1);

namespace Data\Model\Table;

use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\ORM\Table;
use Cake\Utility\Hash;
use Cake\Validation\Validator;
use Data\Model\Entity\Timezone;
use RuntimeException;

/**
 * Timezones Model
 *
 * @method \Data\Model\Entity\Timezone newEmptyEntity()
 * @method \Data\Model\Entity\Timezone newEntity(array $data, array $options = [])
 * @method array<\Data\Model\Entity\Timezone> newEntities(array $data, array $options = [])
 * @method \Data\Model\Entity\Timezone get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \Data\Model\Entity\Timezone findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \Data\Model\Entity\Timezone patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\Data\Model\Entity\Timezone> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Data\Model\Entity\Timezone|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \Data\Model\Entity\Timezone saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\Timezone>|false saveMany(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\Timezone> saveManyOrFail(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\Timezone>|false deleteMany(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\Timezone> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Search\Model\Behavior\SearchBehavior
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @property \Data\Model\Table\TimezonesTable|\Cake\ORM\Association\BelongsTo $CanonicalTimezones
 * @property \Data\Model\Table\CountriesTable|\Cake\ORM\Association\BelongsTo $Countries
 */
class TimezonesTable extends Table {

	/**
	 * Initialize method
	 *
	 * @param array $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('timezones');
		$this->setDisplayField('name');
		$this->setPrimaryKey('id');

		$this->addBehavior('Timestamp');

		$this->belongsTo('CanonicalTimezones', [
			'className' => 'Data.Timezones',
			'foreignKey' => 'linked_id',
		]);
		if (Configure::read('Data.Timezone.Country') !== false) {
			$this->belongsTo('Countries', [
				'className' => 'Data.Countries',
				'foreignKey' => false,
				'conditions' => ['Timezones.country_code = Countries.iso2'],
			]);
		}

		if (!Plugin::isLoaded('Search')) {
			return;
		}

		$this->addBehavior('Search.Search');
		/** @var \Search\Model\Behavior\SearchBehavior $searchBehavior */
		$searchBehavior = $this->getBehavior('Search');
		$searchBehavior->searchManager()
			->value('linked_id')
			->value('type')
			->value('active')
			->value('offset')
			->value('offset_dst')
			->like('search', ['fields' => ['name', 'country_code']]);
	}

	/**
	 * Default validation rules.
	 *
	 * @param \Cake\Validation\Validator $validator Validator instance.
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(Validator $validator): Validator {
		$validator
			->scalar('name')
			->maxLength('name', 100)
			->requirePresence('name', 'create')
			->notEmptyString('name');

		$validator
			->scalar('country_code')
			->maxLength('country_code', 2)
			->allowEmptyString('country_code');

		$validator
			->numeric('offset')
			->requirePresence('offset', 'create')
			->notEmptyString('offset');

		$validator
			->numeric('offset_dst')
			->requirePresence('offset_dst', 'create')
			->notEmptyString('offset_dst');

		$validator
			->scalar('type')
			->maxLength('type', 100)
			->requirePresence('type', 'create')
			->notEmptyString('type');

		$validator
			->boolean('active')
			->notEmptyString('active');

		$validator
			->numeric('lat')
			->allowEmptyString('lat');

		$validator
			->numeric('lng')
			->allowEmptyString('lng');

		$validator
			->scalar('covered')
			->maxLength('covered', 190)
			->allowEmptyString('covered');

		$validator
			->scalar('notes')
			->maxLength('notes', 190)
			->allowEmptyString('notes');

		return $validator;
	}

	/**
	 * @param \Data\Model\Entity\Timezone $timezone
	 * @param array<\Data\Model\Entity\Timezone> $allTimezones
	 *
	 * @return \Data\Model\Entity\Timezone|null
	 */
	public function findCanonical(Timezone $timezone, array $allTimezones = []) {
		if (!$allTimezones) {
			$allTimezones = $this->find()->all()->toArray();
			$allTimezones = Hash::combine($allTimezones, '{n}.name', '{n}');
		}

		if (strpos($timezone->notes, 'Link to [[') === false) {
			return null;
		}

		preg_match('/Link to \[\[(.+?)\]\]/', $timezone->notes, $matches);
		if (!$matches) {
			return null;
		}

		$exploded = explode('|', $matches[1]);
		$timezoneName = array_pop($exploded);

		if (!isset($allTimezones[$timezoneName])) {
			throw new RuntimeException('`' . $timezoneName . '` cannot be found in given timezones.');
		}

		return $allTimezones[$timezoneName];
	}

}
