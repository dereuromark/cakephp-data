<?php
namespace Data\Model\Table;

use Cake\Core\Plugin;
use Tools\Model\Table\Table;

class SmileysTable extends Table {

	public $order = array('is_base' => 'DESC', 'sort' => 'DESC');

	public $validate = array(
		'smiley_cat_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'valErrMandatoryField'
			),
		),
		'smiley_path' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'valErrMandatoryField'
			),
		),
		'title' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'valErrMandatoryField',
			),
		),
		'prim_code' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'valErrMandatoryField',
				'last' => true,
			),
			'uniqueCode' => array(
				'rule' => array('validateUniqueCode'),
				'message' => 'This code already exists'
			),
		),
		'sec_code' => array(
			'uniqueCode' => array(
				'rule' => array('validateUniqueCode'),
				'message' => 'This code already exists'
			),
		),
		'is_base' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				'message' => 'valErrMandatoryField'
			),
		),
		'sort' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'valErrMandatoryField'
			),
		),
		'active' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				'message' => 'valErrMandatoryField'
			),
		),
	);

	public $belongsTo = array(
		/*
		'SmileyCat' => array(
			'className' => 'SmileyCat',
			'foreignKey' => 'smiley_cat_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
		*/
	);

	/**
	 * Export list of smileys for textarea fields etc
	 * note: cache it!
	 * category not yet supported
	 */
	public function getList($category = null) {
		$conditions = array($this->alias() . '.active' => 1);
		if (!empty($category)) {
			$conditions['category_id'] = $category;
		}

		$res = $this->find('all', array(
			'fields' => array('prim_code', 'sec_code', 'smiley_path', 'title', 'is_base'),
			'conditions' => $conditions
		));
		return $res;
	}

	/**
	 * Export list of smileys for textarea fields etc
	 * flattet result:
	 * - code, image, path, url, title, base
	 */
	public function export($category = null) {
		$smileys = $this->getList($category);
		$res = array();

		$path = '/Data/img/smileys/default/';
		foreach ($smileys as $smiley) {
			if (!empty($smiley['prim_code'])) {
				$res[] = array(
					'code' => $smiley['prim_code'],
					'path' => Plugin::path('Data') . 'webroot' . DS . 'img' . DS . 'smileys' . DS . 'default' . DS . $smiley['smiley_path'],
					'url' => $path . $smiley['smiley_path'],
					'title' => $smiley['title'],
					'base' => $smiley['is_base']
				);
			}
			if (!empty($smiley['sec_code'])) {
				$res[] = array(
					'code' => $smiley['sec_code'],
					'path' => Plugin::path('Data') . 'webroot' . DS . 'img' . DS . 'smileys' . DS . 'default' . DS . $smiley['smiley_path'],
					'url' => $path . $smiley['smiley_path'],
					'title' => $smiley['title'],
					'base' => $smiley['is_base']
				);
			}
		}
		return $res;
	}

	public function validateUniqueCode($code, $allowEmpty = true) {
		$code = array_shift($code);
		if (empty($code)) {
			return true;
		}
		if ($this->find('first', array(
			'fields' => array('id'),
			'conditions' => array('OR' => array(array($this->alias() . '.prim_code' => $code, array($this->alias() . '.sec_code' => $code))))
		))) {
			return false;
		}
		return true;
	}

}
