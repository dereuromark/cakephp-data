<?php
namespace Data\Model\Table;

use Data\Model\DataAppModel;

class CountiesTable extends Table {

	public $actsAs = array('Tools.Slugged' => array('case' => 'low', 'mode' => 'ascii', 'unique' => false, 'overwrite' => false));

	public $hasMany = array(
		'City' => array('className' => 'Data.City')
	);

	public $belongsTo = array(
		'State' => array('className' => 'Data.State')
	);

	public function initCounty($data) {
		$this->create();

		$this->set($data);
		return $this->save(null, false);
	}

	/*
	public function beforeSave($options = array()) {
		parent::beforeSave($options);

		//debug($this->data);
	}
	*/
}
