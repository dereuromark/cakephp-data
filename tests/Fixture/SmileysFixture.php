<?php

namespace Data\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class SmileysFixture extends TestFixture {

	public $fields = [
		'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10],
		'smiley_cat_id' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10],
		'smiley_path' => ['type' => 'string', 'null' => false],
		'title' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 32],
		'prim_code' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 15],
		'sec_code' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 15],
		'is_base' => ['type' => 'boolean', 'null' => false, 'default' => '0'],
		'sort' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10],
		'active' => ['type' => 'boolean', 'null' => false, 'default' => '0'],
		'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
		'modified' => ['type' => 'datetime', 'null' => false, 'default' => null],
		'_constraints' => ['primary' => ['type' => 'primary', 'columns' => ['id']]],
		'_options' => []
	];

	public $records = [
		[
			'id' => 1,
			'smiley_cat_id' => 1,
			'smiley_path' => 'Lorem ipsum dolor sit amet',
			'title' => 'Lorem ipsum dolor sit amet',
			'prim_code' => 'Lorem ipsum d',
			'sec_code' => 'Lorem ipsum d',
			'is_base' => 1,
			'sort' => 1,
			'active' => 1,
			'created' => '2010-06-02 01:33:59',
			'modified' => '2010-06-02 01:33:59'
		],
	];
}
