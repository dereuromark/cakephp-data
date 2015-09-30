<?php
namespace Data\Model\Table;

use Cake\Core\Configure;
use Tools\Model\Table\Table;

class CitiesTable extends Table {

	public $order = ['name' => 'ASC'];

	public $validate = [
		'name' => [
			'notEmpty',
		]
	];

	public $actsAs = ['Tools.Slugged' => ['label' => 'name', 'mode' => 'ascii', 'case' => 'low', 'unique' => true, 'overwrite' => false]];

	public $hasMany = [
			'District' => ['className' => 'Data.District']
	];

	public $belongsTo = [
		'County' => ['className' => 'Data.County'],
		'Country' => ['className' => 'Data.Country']
	];

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
		$options = [
			'conditions' => [
				$this->alias() . '.name LIKE' => $name . '%'
			],
			'fields' => ['id', 'postal_code', 'name']
		];
		return $this->find('all', $options);
	}

	public function largeCities($country, $limit = 0) {
		$options = [
			'conditions' => [$this->alias() . '.country_id' => $country],
			'order' => [$this->alias() . '.citizens' => 'desc'],
			'limit' => $limit
		];

		return $this->find('all', $options);
	}

	public function getCitiesToPostalCode($postalCode) {
		preg_match("/\d+/", $postalCode, $matches);
		if (!isset($matches[0]) || strlen($matches[0]) !== 5) {
			return false;
		}
		return $this->find('all', ['conditions' => ['City.postal_code LIKE' => $matches[0]]]);
	}

	public function getCityToPostalCode($postalCode) {
		$result = $this->getCitiesToPostalCode($postalCode);
		if (!$result || count($result) !== 1) {
			return false;
		}
		return $result[0];
	}

}
