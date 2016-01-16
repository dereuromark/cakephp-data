<?php
App::uses('DataAppModel', 'Data.Model');

class County extends DataAppModel {

	public $actsAs = ['Tools.Slugged' => ['case' => 'low', 'mode' => 'ascii', 'unique' => false, 'overwrite' => false]];

	public $hasMany = [
		'City' => ['className' => 'Data.City']
	];

	public $belongsTo = [
		'State' => ['className' => 'Data.State']
	];

	public function initCounty($data) {
		$this->create();

		$this->set($data);
		return $this->save(null, ['validate' => false]);
	}

	/*
	public function beforeSave($options = array()) {
		parent::beforeSave($options);

		//debug($this->data);
	}
	*/
}
