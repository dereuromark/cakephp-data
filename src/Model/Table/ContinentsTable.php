<?php

namespace Data\Model\Table;

use Tools\Model\Table\Table;

/**
 * @property \Cake\ORM\Table|\Cake\ORM\Association\BelongsTo $ParentContinents
 * @property \Cake\ORM\Table|\Cake\ORM\Association\HasMany $ChildContinents
 * @property \Cake\ORM\Table|\Cake\ORM\Association\HasMany $Countries
 *
 * @mixin \Cake\ORM\Behavior\TreeBehavior
 */
class ContinentsTable extends Table {

	/**
	 * @var array
	 */
	public $actsAs = ['Tree'];

	/**
	 * @var array
	 */
	public $order = ['name' => 'ASC'];

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
		'ori_name' => [
			'notBlank' => [
				'rule' => ['notBlank'],
				'message' => 'valErrMandatoryField',
			],
		],
		'parent_id' => [
			'numeric' => [
				'rule' => ['numeric'],
				'message' => 'valErrMandatoryField',
			],
		],
		'lft' => [
			'numeric' => [
				'rule' => ['numeric'],
				'message' => 'valErrMandatoryField',
			],
		],
		'rgt' => [
			'numeric' => [
				'rule' => ['numeric'],
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
	 * @var array
	 */
	public $belongsTo = [
		'ParentContinent' => [
			'className' => 'Continent',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
		],
	];

	/**
	 * @var array
	 */
	public $hasMany = [
		'ChildContinent' => [
			'className' => 'Continent',
			'foreignKey' => 'parent_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
		],
		'Country' => [
			'className' => 'Country',
			'foreignKey' => 'continent_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
		],
	];

}
