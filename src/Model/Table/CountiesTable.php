<?php
namespace Data\Model\Table;

use Data\Model\DataAppModel;
use Tools\Model\Table\Table;

class CountiesTable extends Table {

	public $actsAs = array('Tools.Slugged' => array('case' => 'low', 'mode' => 'ascii', 'unique' => false, 'overwrite' => false));

	public $hasMany = array(
		'City' => array('className' => 'Data.City')
	);

	public $belongsTo = array(
		'State' => array('className' => 'Data.State')
	);

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
