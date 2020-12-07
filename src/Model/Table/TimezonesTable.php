<?php
declare(strict_types = 1);

namespace Data\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Timezones Model
 *
 * @method \Data\Model\Entity\Timezone newEmptyEntity()
 * @method \Data\Model\Entity\Timezone newEntity(array $data, array $options = [])
 * @method \Data\Model\Entity\Timezone[] newEntities(array $data, array $options = [])
 * @method \Data\Model\Entity\Timezone get($primaryKey, $options = [])
 * @method \Data\Model\Entity\Timezone findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Data\Model\Entity\Timezone patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Data\Model\Entity\Timezone[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Data\Model\Entity\Timezone|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Data\Model\Entity\Timezone saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Data\Model\Entity\Timezone[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Data\Model\Entity\Timezone[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Data\Model\Entity\Timezone[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Data\Model\Entity\Timezone[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
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
	}

	/**
	 * Default validation rules.
	 *
	 * @param \Cake\Validation\Validator $validator Validator instance.
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(Validator $validator): Validator {
		$validator
			->integer('id')
			->allowEmptyString('id', null, 'create');

		$validator
			->scalar('name')
			->maxLength('name', 100)
			->requirePresence('name', 'create')
			->notEmptyString('name');

		$validator
			->scalar('country_code')
			->maxLength('country_code', 2)
			->requirePresence('country_code', 'create')
			->notEmptyString('country_code');

		$validator
			->scalar('offset')
			->maxLength('offset', 10)
			->requirePresence('offset', 'create')
			->notEmptyString('offset');

		$validator
			->scalar('offset_dst')
			->maxLength('offset_dst', 10)
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

}
