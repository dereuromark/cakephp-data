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
	public $fields = [
		'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'collate' => null, 'comment' => ''],
		'country_id' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'collate' => null, 'comment' => ''],
		'name' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'],
		'abbr' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 3, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'],
		'lat' => ['type' => 'float', 'null' => true, 'default' => null, 'length' => '10,6', 'collate' => null, 'comment' => ''],
		'lng' => ['type' => 'float', 'null' => true, 'default' => null, 'length' => '10,6', 'collate' => null, 'comment' => ''],
		'slug' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'],
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
	public $records = [
		[
			'id' => '1',
			'country_id' => '1',
			'name' => 'Hamburg',
			'abbr' => 'HH',
			'lat' => '42.000000',
			'lng' => '36.000000',
			'slug' => 'hamburg',
			'modified' => null,
		],
	];

}
