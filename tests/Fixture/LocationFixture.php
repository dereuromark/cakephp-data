<?php
/**
 * LocationFixture
 *
 */
class LocationFixture extends CakeTestFixture {

	/**
	 * Fields
	 *
	 * @var array
	 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'country_province_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'country_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'comment' => 'redundance purposely'),
		'postal_code' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'city' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 80, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'street' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 80, 'collate' => 'utf8_unicode_ci', 'comment' => 'street address and street number', 'charset' => 'utf8'),
		'lat' => array('type' => 'float', 'null' => false, 'default' => '0.000000', 'length' => '10,6', 'comment' => 'maps.google.de latitude'),
		'lng' => array('type' => 'float', 'null' => false, 'default' => '0.000000', 'length' => '10,6', 'comment' => 'maps.google.de longitude'),
		'formatted_address' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
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
			'country_province_id' => 1,
			'country_id' => 1,
			'postal_code' => 'Lorem ip',
			'city' => 'Lorem ipsum dolor sit amet',
			'street' => 'Lorem ipsum dolor sit amet',
			'lat' => 1,
			'lng' => 1,
			'formatted_address' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-12-26 17:20:20',
			'modified' => '2012-12-26 17:20:20'
		),
		array(
			'id' => 2,
			'country_province_id' => 2,
			'country_id' => 2,
			'postal_code' => 'Lorem ip',
			'city' => 'Lorem ipsum dolor sit amet',
			'street' => 'Lorem ipsum dolor sit amet',
			'lat' => 2,
			'lng' => 2,
			'formatted_address' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-12-26 17:20:20',
			'modified' => '2012-12-26 17:20:20'
		),
		array(
			'id' => 3,
			'country_province_id' => 3,
			'country_id' => 3,
			'postal_code' => 'Lorem ip',
			'city' => 'Lorem ipsum dolor sit amet',
			'street' => 'Lorem ipsum dolor sit amet',
			'lat' => 3,
			'lng' => 3,
			'formatted_address' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-12-26 17:20:20',
			'modified' => '2012-12-26 17:20:20'
		),
		array(
			'id' => 4,
			'country_province_id' => 4,
			'country_id' => 4,
			'postal_code' => 'Lorem ip',
			'city' => 'Lorem ipsum dolor sit amet',
			'street' => 'Lorem ipsum dolor sit amet',
			'lat' => 4,
			'lng' => 4,
			'formatted_address' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-12-26 17:20:20',
			'modified' => '2012-12-26 17:20:20'
		),
		array(
			'id' => 5,
			'country_province_id' => 5,
			'country_id' => 5,
			'postal_code' => 'Lorem ip',
			'city' => 'Lorem ipsum dolor sit amet',
			'street' => 'Lorem ipsum dolor sit amet',
			'lat' => 5,
			'lng' => 5,
			'formatted_address' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-12-26 17:20:20',
			'modified' => '2012-12-26 17:20:20'
		),
		array(
			'id' => 6,
			'country_province_id' => 6,
			'country_id' => 6,
			'postal_code' => 'Lorem ip',
			'city' => 'Lorem ipsum dolor sit amet',
			'street' => 'Lorem ipsum dolor sit amet',
			'lat' => 6,
			'lng' => 6,
			'formatted_address' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-12-26 17:20:20',
			'modified' => '2012-12-26 17:20:20'
		),
		array(
			'id' => 7,
			'country_province_id' => 7,
			'country_id' => 7,
			'postal_code' => 'Lorem ip',
			'city' => 'Lorem ipsum dolor sit amet',
			'street' => 'Lorem ipsum dolor sit amet',
			'lat' => 7,
			'lng' => 7,
			'formatted_address' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-12-26 17:20:20',
			'modified' => '2012-12-26 17:20:20'
		),
		array(
			'id' => 8,
			'country_province_id' => 8,
			'country_id' => 8,
			'postal_code' => 'Lorem ip',
			'city' => 'Lorem ipsum dolor sit amet',
			'street' => 'Lorem ipsum dolor sit amet',
			'lat' => 8,
			'lng' => 8,
			'formatted_address' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-12-26 17:20:20',
			'modified' => '2012-12-26 17:20:20'
		),
		array(
			'id' => 9,
			'country_province_id' => 9,
			'country_id' => 9,
			'postal_code' => 'Lorem ip',
			'city' => 'Lorem ipsum dolor sit amet',
			'street' => 'Lorem ipsum dolor sit amet',
			'lat' => 9,
			'lng' => 9,
			'formatted_address' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-12-26 17:20:20',
			'modified' => '2012-12-26 17:20:20'
		),
		array(
			'id' => 10,
			'country_province_id' => 10,
			'country_id' => 10,
			'postal_code' => 'Lorem ip',
			'city' => 'Lorem ipsum dolor sit amet',
			'street' => 'Lorem ipsum dolor sit amet',
			'lat' => 10,
			'lng' => 10,
			'formatted_address' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-12-26 17:20:20',
			'modified' => '2012-12-26 17:20:20'
		),
	);
}
