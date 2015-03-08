<?php
/**
 * DistrictFixture
 *
 */
class DistrictFixture extends CakeTestFixture {

	/**
	 * Fields
	 *
	 * @var array
	 */
	public $fields = [
		'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'],
		'name' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
		'slug' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 40, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
		'city_id' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10],
		'lat' => ['type' => 'float', 'null' => false, 'default' => '0.000000', 'length' => '10,6'],
		'lng' => ['type' => 'float', 'null' => false, 'default' => '0.000000', 'length' => '10,6'],
		'status' => ['type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => '0 inactive, 1 active'],
		'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
		'indexes' => [
			'PRIMARY' => ['column' => 'id', 'unique' => 1]
		],
		'tableParameters' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM']
	];

	/**
	 * Records
	 *
	 * @var array
	 */
	public $records = [
		[
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'slug' => 'Lorem ipsum dolor sit amet',
			'city_id' => 1,
			'lat' => 1,
			'lng' => 1,
			'status' => 1,
			'created' => '2013-11-06 13:20:46'
		],
	];

}
