<?php
/* County Fixture generated on: 2011-11-20 21:58:50 : 1321822730 */

namespace Data\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CountiesFixture
 */
class CountiesFixture extends TestFixture {

	/**
	 * Fields
	 *
	 * @var array
	 */
	public $fields = [
		'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'collate' => null, 'comment' => ''],
		'official_key' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 9, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'],
		'country_id' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'collate' => null, 'comment' => ''],
		'state_id' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'collate' => null, 'comment' => ''],
		'name' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'],
		'lat' => ['type' => 'float', 'null' => false, 'default' => '0.000000', 'length' => '10,6', 'collate' => null, 'comment' => ''],
		'lng' => ['type' => 'float', 'null' => false, 'default' => '0.000000', 'length' => '10,6', 'collate' => null, 'comment' => ''],
		'slug' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'],
		'single_city' => ['type' => 'boolean', 'null' => false, 'default' => '0', 'collate' => null, 'comment' => ''],
		'rank' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 5, 'collate' => null, 'comment' => ''],
		'modified' => ['type' => 'datetime', 'null' => false, 'default' => null, 'collate' => null, 'comment' => ''],
		'_constraints' => ['primary' => ['type' => 'primary', 'columns' => ['id']], 'official_key' => ['type' => 'unique', 'columns' => 'official_key'], 'slug' => ['type' => 'unique', 'columns' => 'slug']],
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
			'official_key' => '01-0-01',
			'country_id' => '1',
			'state_id' => '1',
			'name' => 'Flensburg',
			'lat' => '0.000000',
			'lng' => '0.000000',
			'slug' => 'flensburg',
			'single_city' => 1,
			'rank' => '1',
			'modified' => '0000-00-00 00:00:00',
		],
		[
			'id' => '2',
			'official_key' => '01-0-02',
			'country_id' => '1',
			'state_id' => '1',
			'name' => 'Kiel',
			'lat' => '0.000000',
			'lng' => '0.000000',
			'slug' => 'kiel',
			'single_city' => 1,
			'rank' => '3',
			'modified' => '0000-00-00 00:00:00',
		],
		[
			'id' => '3',
			'official_key' => '01-0-03',
			'country_id' => '1',
			'state_id' => '1',
			'name' => 'Lübeck',
			'lat' => '0.000000',
			'lng' => '0.000000',
			'slug' => 'luebeck',
			'single_city' => 1,
			'rank' => '4',
			'modified' => '0000-00-00 00:00:00',
		],
		[
			'id' => '4',
			'official_key' => '01-0-04',
			'country_id' => '1',
			'state_id' => '1',
			'name' => 'Neumünster',
			'lat' => '0.000000',
			'lng' => '0.000000',
			'slug' => 'neumuenster',
			'single_city' => 1,
			'rank' => '5',
			'modified' => '0000-00-00 00:00:00',
		],
		[
			'id' => '5',
			'official_key' => '02-0-00',
			'country_id' => '1',
			'state_id' => '2',
			'name' => 'Hamburg',
			'lat' => '0.000000',
			'lng' => '0.000000',
			'slug' => 'hamburg',
			'single_city' => 1,
			'rank' => '0',
			'modified' => '0000-00-00 00:00:00',
		],
		[
			'id' => '6',
			'official_key' => '03-1-01',
			'country_id' => '1',
			'state_id' => '3',
			'name' => 'Braunschweig',
			'lat' => '0.000000',
			'lng' => '0.000000',
			'slug' => 'braunschweig',
			'single_city' => 1,
			'rank' => '2',
			'modified' => '0000-00-00 00:00:00',
		],
		[
			'id' => '7',
			'official_key' => '03-1-02',
			'country_id' => '1',
			'state_id' => '3',
			'name' => 'Salzgitter',
			'lat' => '0.000000',
			'lng' => '0.000000',
			'slug' => 'salzgitter',
			'single_city' => 1,
			'rank' => '34',
			'modified' => '0000-00-00 00:00:00',
		],
		[
			'id' => '8',
			'official_key' => '03-1-03',
			'country_id' => '1',
			'state_id' => '3',
			'name' => 'Wolfsburg',
			'lat' => '0.000000',
			'lng' => '0.000000',
			'slug' => 'wolfsburg',
			'single_city' => 1,
			'rank' => '45',
			'modified' => '0000-00-00 00:00:00',
		],
		[
			'id' => '9',
			'official_key' => '03-4-01',
			'country_id' => '1',
			'state_id' => '3',
			'name' => 'Delmenhorst',
			'lat' => '0.000000',
			'lng' => '0.000000',
			'slug' => 'delmenhorst',
			'single_city' => 1,
			'rank' => '6',
			'modified' => '0000-00-00 00:00:00',
		],
		[
			'id' => '10',
			'official_key' => '03-4-02',
			'country_id' => '1',
			'state_id' => '3',
			'name' => 'Emden',
			'lat' => '0.000000',
			'lng' => '0.000000',
			'slug' => 'emden',
			'single_city' => 1,
			'rank' => '8',
			'modified' => '0000-00-00 00:00:00',
		],
	];

}
