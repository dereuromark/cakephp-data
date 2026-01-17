<?php
/**
 * DistrictsFixture
 */

namespace Data\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class DistrictsFixture extends TestFixture {

	/**
	 * Fields
	 *
	 * @var array
	 */
	public array $fields = [
		'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10],
		'name' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'charset' => 'utf8'],
		'slug' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 40, 'charset' => 'utf8'],
		'city_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10],
		'lat' => ['type' => 'float', 'null' => true, 'default' => null, 'length' => 10, 'precision' => 6],
		'lng' => ['type' => 'float', 'null' => true, 'default' => null, 'length' => 10, 'precision' => 6],
		'status' => ['type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => '0 inactive, 1 active'],
		'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
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
			'name' => 'Lorem ipsum dolor sit amet',
			'slug' => 'Lorem ipsum dolor sit amet',
			'city_id' => 1,
			'lat' => 1,
			'lng' => 1,
			'status' => 1,
			'created' => '2013-11-06 13:20:46',
		],
	];

}
