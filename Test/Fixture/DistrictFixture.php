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
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 40, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'city_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'lat' => array('type' => 'float', 'null' => false, 'default' => '0.000000', 'length' => '10,6'),
		'lng' => array('type' => 'float', 'null' => false, 'default' => '0.000000', 'length' => '10,6'),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => '0 inactive, 1 active'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	/**
	 * Records
	 *
	 * @var array
	 */
	public $records = array(
		array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'slug' => 'Lorem ipsum dolor sit amet',
			'city_id' => 1,
			'lat' => 1,
			'lng' => 1,
			'status' => 1,
			'created' => '2013-11-06 13:20:46'
		),
	);

}
