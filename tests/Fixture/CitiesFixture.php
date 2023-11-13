<?php

namespace Data\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CitiesFixture
 */
class CitiesFixture extends TestFixture {

	/**
	 * Fields
	 *
	 * @var array
	 */
	public array $fields = [
		'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'collate' => null, 'comment' => ''],
		'name' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'comment' => '', 'charset' => 'utf8'],
		'slug' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 40, 'comment' => '', 'charset' => 'utf8'],
		'lat' => ['type' => 'float', 'null' => false, 'default' => null, 'length' => '10,6', 'collate' => null, 'comment' => ''],
		'lng' => ['type' => 'float', 'null' => false, 'default' => null, 'length' => '10,6', 'collate' => null, 'comment' => ''],
		'active' => ['type' => 'boolean', 'null' => false, 'default' => '0', 'collate' => null, 'comment' => ''],
		'created' => ['type' => 'datetime', 'null' => false, 'default' => null, 'collate' => null, 'comment' => ''],
		'modified' => ['type' => 'datetime', 'null' => false, 'default' => null, 'collate' => null, 'comment' => ''],
		'_constraints' => ['primary' => ['type' => 'primary', 'columns' => ['id']]],
		'_options' => ['charset' => 'utf8', 'engine' => 'MyISAM'],
	];

	/**
	 * Records
	 *
	 * @var array
	 */
	public array $records = [
		[
			'name' => 'München',
			'slug' => 'muenchen',
			'lat' => '48.139126',
			'lng' => '11.580186',
			'active' => 1,
			'created' => '2011-04-21 16:50:05',
			'modified' => '2011-04-21 16:50:05',
		],
		[
			'name' => 'Stuttgart',
			'slug' => 'Stuttgart',
			'lat' => '48.777107',
			'lng' => '9.180769',
			'active' => 1,
			'created' => '2011-10-07 16:48:05',
			'modified' => '2011-04-21 16:50:05',
		],
	];

}
