<?php
App::uses('DataAppModel', 'Data.Model');

class Continent extends DataAppModel {

	public $actsAs = ['Tree'];

	public $order = ['Continent.name' => 'ASC'];

	public $validate = [
		'name' => [
			'notEmpty' => [
				'rule' => ['notEmpty'],
				'message' => 'valErrMandatoryField',
			],
		],
		'ori_name' => [
			'notEmpty' => [
				'rule' => ['notEmpty'],
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

	public $belongsTo = [
		'ParentContinent' => [
			'className' => 'Continent',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		]
	];

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
		]
	];

}
