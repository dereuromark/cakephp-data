<?php

namespace Data\Model\Table;

use Tools\Model\Table\Table;

/**
 * @deprecated Use only Countries => States => Cities
 */
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
	 * @return \Cake\Datasource\EntityInterface|bool
	 */
	public function initCounty($data) {
		$entity = $this->newEntity($data);

		return $this->save($entity);
	}

}
