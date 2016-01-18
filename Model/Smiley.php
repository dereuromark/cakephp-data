<?php
App::uses('DataAppModel', 'Data.Model');

class Smiley extends DataAppModel {

	public $order = ['is_base' => 'DESC', 'sort' => 'DESC'];

	public $validate = [
		'smiley_cat_id' => [
			'numeric' => [
				'rule' => ['numeric'],
				'message' => 'valErrMandatoryField'
			],
		],
		'smiley_path' => [
			'notEmpty' => [
				'rule' => ['notEmpty'],
				'message' => 'valErrMandatoryField'
			],
		],
		'title' => [
			'notEmpty' => [
				'rule' => ['notEmpty'],
				'message' => 'valErrMandatoryField',
			],
		],
		'prim_code' => [
			'notEmpty' => [
				'rule' => ['notEmpty'],
				'message' => 'valErrMandatoryField',
				'last' => true,
			],
			'uniqueCode' => [
				'rule' => ['validateUniqueCode'],
				'message' => 'This code already exists'
			],
		],
		'sec_code' => [
			'uniqueCode' => [
				'rule' => ['validateUniqueCode'],
				'message' => 'This code already exists'
			],
		],
		'is_base' => [
			'boolean' => [
				'rule' => ['boolean'],
				'message' => 'valErrMandatoryField'
			],
		],
		'sort' => [
			'numeric' => [
				'rule' => ['numeric'],
				'message' => 'valErrMandatoryField'
			],
		],
		'active' => [
			'boolean' => [
				'rule' => ['boolean'],
				'message' => 'valErrMandatoryField'
			],
		],
	];

	public $belongsTo = [
		/*
		'SmileyCat' => array(
			'className' => 'SmileyCat',
			'foreignKey' => 'smiley_cat_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
		*/
	];

	/**
	 * Export list of smileys for textarea fields etc
	 * note: cache it!
	 * category not yet supported
	 */
	public function getList($category = null) {
		$conditions = [$this->alias . '.active' => 1];
		if (!empty($category)) {
			$conditions['category_id'] = $category;
		}

		$res = $this->find('all', [
			'fields' => ['prim_code', 'sec_code', 'smiley_path', 'title', 'is_base'],
			'conditions' => $conditions
		]);
		return $res;
	}

	/**
	 * Export list of smileys for textarea fields etc
	 * flattet result:
	 * - code, image, path, url, title, base
	 */
	public function export($category = null) {
		$smileys = $this->getList($category);
		$res = [];

		$path = '/Data/img/smileys/default/';
		foreach ($smileys as $smiley) {
			if (!empty($smiley[$this->alias]['prim_code'])) {
				$res[] = [
					'code' => $smiley[$this->alias]['prim_code'],
					'path' => CakePlugin::path('Data') . 'webroot' . DS . 'img' . DS . 'smileys' . DS . 'default' . DS . $smiley[$this->alias]['smiley_path'],
					'url' => $path . $smiley[$this->alias]['smiley_path'],
					'title' => $smiley[$this->alias]['title'],
					'base' => $smiley[$this->alias]['is_base']
				];
			}
			if (!empty($smiley[$this->alias]['sec_code'])) {
				$res[] = [
					'code' => $smiley[$this->alias]['sec_code'],
					'path' => CakePlugin::path('Data') . 'webroot' . DS . 'img' . DS . 'smileys' . DS . 'default' . DS . $smiley[$this->alias]['smiley_path'],
					'url' => $path . $smiley[$this->alias]['smiley_path'],
					'title' => $smiley[$this->alias]['title'],
					'base' => $smiley[$this->alias]['is_base']
				];
			}
		}
		return $res;
	}

	public function validateUniqueCode($code, $allowEmpty = true) {
		$code = array_shift($code);
		if (empty($code)) {
			return true;
		}
		if ($this->find('first', [
			'fields' => ['id'],
			'conditions' => ['OR' => [[$this->alias . '.prim_code' => $code, [$this->alias . '.sec_code' => $code]]]]
		])) {
			return false;
		}
		return true;
	}

}
