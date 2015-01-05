<?php

namespace Data\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class ContinentsFixture extends TestFixture {

	public $fields = array(
		'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10],
		'name' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
		'ori_name' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
		'parent_id' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10],
		'lft' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10],
		'rgt' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10],
		'status' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2],
		'modified' => ['type' => 'datetime', 'null' => false, 'default' => null],
		'_constraints' => ['primary' => ['type' => 'primary', 'columns' => ['id']]],
		'_options' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM']
	);

	public $records = array(
		array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'ori_name' => 'Lorem ipsum dolor sit amet',
			'parent_id' => 1,
			'lft' => 1,
			'rgt' => 1,
			'status' => 1,
			'modified' => '2011-07-15 19:47:38'
		),
	);
}
