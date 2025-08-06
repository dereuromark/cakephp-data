<?php

namespace Data\Model\Table;

use Tools\Model\Table\Table;

/**
 * @deprecated Use only Countries => States => Cities
 */
class CountiesTable extends Table {

	/**
	 * @param array $config
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		$this->addBehavior('Tools.Slugged', ['case' => 'low', 'mode' => 'ascii', 'unique' => false, 'overwrite' => false]);

		$this->hasMany('Cities', [
			'className' => 'Data.Cities',
		]);

		$this->belongsTo('States', [
			'className' => 'Data.States',
		]);
	}

	/**
	 * @param mixed $data
	 * @return \Cake\Datasource\EntityInterface|bool
	 */
	public function initCounty($data) {
		$entity = $this->newEntity($data);

		return $this->save($entity);
	}

}
