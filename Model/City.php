<?php
App::uses('DataAppModel', 'Data.Model');

class City extends DataAppModel {

	public $order = array('City.name' => 'ASC');

	public $validate = array(
		'name' => array(
			'notEmpty',
		)
	);

	public $actsAs = array('Tools.Slugged' => array('label' => 'name', 'mode' => 'ascii', 'case' => 'low', 'unique' => true, 'overwrite' => false));

	public $hasMany = array(
			'District' => array('className' => 'Data.District')
	);

	public $belongsTo = array(
		'County' => array('className' => 'Data.County'),
		'Country' => array('className' => 'Data.Country')
	);

	public function __construct($id = false, $table = false, $ds = null) {
		if (Configure::read('City.District') === false) {
			unset($this->hasMany['District']);
		}
		if (Configure::read('City.County') === false) {
			unset($this->belongsTo['County']);
		}

		parent::__construct($id, $table, $ds);
	}

	public function autoCompleteName($name) {
		$options = array(
			'conditions' => array(
				$this->alias . '.name LIKE' => $name . '%'
			),
			'fields' => array('id', 'postal_code', 'name')
		);
		return $this->find('all', $options);
	}

	public function largeCities($country, $limit = 0) {
		$options = array(
			'conditions' => array($this->alias . '.country_id' => $country),
			'order' => array($this->alias . '.citizens' => 'desc'),
			'limit' => $limit
		);

		return $this->find('all', $options);
	}

	public function getCitiesToPostalCode($postalCode) {
		preg_match("/\d+/", $postalCode, $matches);
		if (!isset($matches[0]) || strlen($matches[0]) !== 5) {
			return false;
		}
		return $this->find('all', array('conditions' => array('City.postal_code LIKE' => $matches[0])));
	}

	public function getCityToPostalCode($postalCode) {
		$result = $this->getCitiesToPostalCode($postalCode);
		if (!$result || count($result) !== 1) {
			return false;
		}
		return $result[0];
	}

}
