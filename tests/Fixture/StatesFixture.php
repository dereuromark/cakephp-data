<?php
/* State Fixture generated on: 2011-11-20 21:59:38 : 1321822778 */

namespace Data\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * StatesFixture
 */
class StatesFixture extends TestFixture {

	/**
	 * Fields
	 *
	 * @var array
	 */
	public array $fields = [
		'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'collate' => null, 'comment' => ''],
		'country_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'collate' => null, 'comment' => ''],
		'name' => ['type' => 'string', 'null' => false, 'default' => null, 'comment' => '', 'charset' => 'utf8'],
		'ori_name' => ['type' => 'string', 'null' => true, 'default' => null, 'comment' => '', 'charset' => 'utf8'],
		'code' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 6, 'comment' => '', 'charset' => 'utf8'],
		'lat' => ['type' => 'float', 'null' => true, 'default' => null, 'length' => '10,6', 'collate' => null, 'comment' => ''],
		'lng' => ['type' => 'float', 'null' => true, 'default' => null, 'length' => '10,6', 'collate' => null, 'comment' => ''],
		'slug' => ['type' => 'string', 'null' => false, 'default' => null, 'comment' => '', 'charset' => 'utf8'],
		'modified' => ['type' => 'datetime', 'null' => true, 'default' => null, 'collate' => null, 'comment' => ''],
		//'_indexes' => ['slug' => ['unique' => 0, 'columns' => 'slug']],
		'_constraints' => ['primary' => ['type' => 'primary', 'columns' => ['id']]],
		'_options' => [],
	];

	/**
	 * Records
	 *
	 * @var array
	 */
	public array $records = [
		[
			'country_id' => '1',
			'name' => 'Hamburg',
			'ori_name' => 'Hamburg',
			'code' => 'HH',
			'lat' => '42.000000',
			'lng' => '36.000000',
			'slug' => 'hamburg',
			'modified' => '2011-07-15 19:47:38',
		],
	];

}
