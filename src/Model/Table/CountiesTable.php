<?php
namespace Data\Model\Table;

use Tools\Model\Table\Table;

class CountiesTable extends Table {

	public $actsAs = ['Tools.Slugged' => ['case' => 'low', 'mode' => 'ascii', 'unique' => false, 'overwrite' => false]];

	public $hasMany = [
		'City' => ['className' => 'Data.City']
	];

	public $belongsTo = [
		'State' => ['className' => 'Data.State']
	];

	/**
	 * CountiesTable::initCounty()
	 *
	 * @param mixed $data
	 * @return
	 */
	public function initCounty($data) {
		$entity = $this->newEntity($data);
		return $this->save($entity);
	}

}
