<?php

namespace Data\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class ContinentsFixture extends TestFixture {

	/**
	 * @var array
	 */
	public array $fields = [
		'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10],
		'name' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'charset' => 'utf8'],
		'ori_name' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 64, 'charset' => 'utf8'],
		'code' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 2, 'charset' => 'utf8'],
		'parent_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'length' => 10],
		'lft' => ['type' => 'integer', 'null' => true, 'default' => null, 'length' => 10],
		'rght' => ['type' => 'integer', 'null' => true, 'default' => null, 'length' => 10],
		'status' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2],
		'modified' => ['type' => 'datetime', 'null' => false, 'default' => null],
		'_constraints' => ['primary' => ['type' => 'primary', 'columns' => ['id']]],
		'_options' => ['charset' => 'utf8', 'engine' => 'MyISAM'],
	];

	/**
	 * @var array
	 */
	public array $records = [
		[
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'ori_name' => 'Lorem ipsum dolor sit amet',
			'code' => 'XY',
			'parent_id' => 1,
			'lft' => 1,
			'rght' => 1,
			'status' => 1,
			'modified' => '2011-07-15 19:47:38',
		],
	];

}
