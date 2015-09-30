<?php
/* State Fixture generated on: 2011-11-20 21:59:38 : 1321822778 */
namespace Data\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;


/**
 * StatesFixture
 *
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
		'lat' => ['type' => 'float', 'null' => false, 'default' => '0.000000', 'length' => '10,6', 'collate' => null, 'comment' => ''],
		'lng' => ['type' => 'float', 'null' => false, 'default' => '0.000000', 'length' => '10,6', 'collate' => null, 'comment' => ''],
		'slug' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'],
		'modified' => ['type' => 'datetime', 'null' => false, 'default' => null, 'collate' => null, 'comment' => ''],
		//'_indexes' => ['slug' => ['unique' => 0, 'columns' => 'slug']],
		'_constraints' => ['primary' => ['type' => 'primary', 'columns' => ['id']]],
		'_options' => []
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
			'name' => 'Schleswig-Holstein',
			'abbr' => '',
			'lat' => '0.000000',
			'lng' => '0.000000',
			'slug' => 'schleswig-holstein',
			'modified' => '0000-00-00 00:00:00'
		],
		[
			'id' => '2',
			'country_id' => '1',
			'name' => 'Hamburg',
			'abbr' => '',
			'lat' => '0.000000',
			'lng' => '0.000000',
			'slug' => 'hamburg',
			'modified' => '0000-00-00 00:00:00'
		],
		[
			'id' => '3',
			'country_id' => '1',
			'name' => 'Niedersachsen',
			'abbr' => '',
			'lat' => '0.000000',
			'lng' => '0.000000',
			'slug' => 'niedersachsen',
			'modified' => '0000-00-00 00:00:00'
		],
		[
			'id' => '4',
			'country_id' => '1',
			'name' => 'Bremen',
			'abbr' => '',
			'lat' => '0.000000',
			'lng' => '0.000000',
			'slug' => 'bremen',
			'modified' => '0000-00-00 00:00:00'
		],
		[
			'id' => '5',
			'country_id' => '1',
			'name' => 'Nordrhein-Westfalen',
			'abbr' => '',
			'lat' => '0.000000',
			'lng' => '0.000000',
			'slug' => 'nordrhein-westfalen',
			'modified' => '0000-00-00 00:00:00'
		],
		[
			'id' => '6',
			'country_id' => '1',
			'name' => 'Hessen',
			'abbr' => '',
			'lat' => '0.000000',
			'lng' => '0.000000',
			'slug' => 'hessen',
			'modified' => '0000-00-00 00:00:00'
		],
		[
			'id' => '7',
			'country_id' => '1',
			'name' => 'Rheinland-Pfalz',
			'abbr' => '',
			'lat' => '0.000000',
			'lng' => '0.000000',
			'slug' => 'rheinland-pfalz',
			'modified' => '0000-00-00 00:00:00'
		],
		[
			'id' => '8',
			'country_id' => '1',
			'name' => 'Baden-Württemberg',
			'abbr' => '',
			'lat' => '0.000000',
			'lng' => '0.000000',
			'slug' => 'baden-wuerttemberg',
			'modified' => '0000-00-00 00:00:00'
		],
		[
			'id' => '9',
			'country_id' => '1',
			'name' => 'Bayern',
			'abbr' => '',
			'lat' => '0.000000',
			'lng' => '0.000000',
			'slug' => 'bayern',
			'modified' => '0000-00-00 00:00:00'
		],
		[
			'id' => '10',
			'country_id' => '1',
			'name' => 'Saarland',
			'abbr' => '',
			'lat' => '0.000000',
			'lng' => '0.000000',
			'slug' => 'saarland',
			'modified' => '0000-00-00 00:00:00'
		],
	];
}
