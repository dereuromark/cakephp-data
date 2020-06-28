<?php

namespace Data\Model\Table;

use Tools\Model\Table\Table;

class CountiesTable extends Table {

	/**
	 * @var array
	 */
	public $actsAs = [
		'Tools.Slugged' => ['case' => 'low', 'mode' => 'ascii', 'unique' => false, 'overwrite' => false],
	];

	/**
	 * @var array
	 */
	public $hasMany = [
		'City' => ['className' => 'Data.City'],
	];

	/**
	 * @var array
	 */
	public $belongsTo = [
		'State' => ['className' => 'Data.State'],
	];

	/**
	 * @param mixed $data
	 * @return bool|\Cake\Datasource\EntityInterface
	 */
	public function initCounty($data) {
		$entity = $this->newEntity($data);

		return $this->save($entity);
	}

}
