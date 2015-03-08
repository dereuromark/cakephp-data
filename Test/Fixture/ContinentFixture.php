<?php

class ContinentFixture extends CakeTestFixture {

	public $fields = [
		'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'],
		'name' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
		'ori_name' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
		'parent_id' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10],
		'lft' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10],
		'rgt' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10],
		'status' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2],
		'modified' => ['type' => 'datetime', 'null' => false, 'default' => null],
		'indexes' => ['PRIMARY' => ['column' => 'id', 'unique' => 1]],
		'tableParameters' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM']
	];

	public $records = [
		[
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'ori_name' => 'Lorem ipsum dolor sit amet',
			'parent_id' => 1,
			'lft' => 1,
			'rgt' => 1,
			'status' => 1,
			'modified' => '2011-07-15 19:47:38'
		],
	];
}
