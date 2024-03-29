<?php
/**
 * LocationsFixture
 */

namespace Data\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class LocationsFixture extends TestFixture {

	/**
	 * Fields
	 *
	 * @var array
	 */
	public array $fields = [
		'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10],
		'state_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'length' => 10],
		'country_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'comment' => 'redundance purposely'],
		'postal_code' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'charset' => 'utf8'],
		'city' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 80, 'charset' => 'utf8'],
		'street' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 80, 'comment' => 'street address and street number', 'charset' => 'utf8'],
		'lat' => ['type' => 'float', 'null' => true, 'default' => null, 'length' => '10,6', 'comment' => 'maps.google.de latitude'],
		'lng' => ['type' => 'float', 'null' => true, 'default' => null, 'length' => '10,6', 'comment' => 'maps.google.de longitude'],
		'formatted_address' => ['type' => 'string', 'null' => true, 'default' => null, 'charset' => 'utf8'],
		'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
		'modified' => ['type' => 'datetime', 'null' => false, 'default' => null],
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
			'state_id' => 1,
			'country_id' => 1,
			'postal_code' => 'Lorem ip',
			'city' => 'Lorem ipsum dolor sit amet',
			'street' => 'Lorem ipsum dolor sit amet',
			'lat' => 1,
			'lng' => 1,
			'formatted_address' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-12-26 17:20:20',
			'modified' => '2012-12-26 17:20:20',
		],
		[
			'state_id' => 2,
			'country_id' => 2,
			'postal_code' => 'Lorem ip',
			'city' => 'Lorem ipsum dolor sit amet',
			'street' => 'Lorem ipsum dolor sit amet',
			'lat' => 2,
			'lng' => 2,
			'formatted_address' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-12-26 17:20:20',
			'modified' => '2012-12-26 17:20:20',
		],
		[
			'state_id' => 3,
			'country_id' => 3,
			'postal_code' => 'Lorem ip',
			'city' => 'Lorem ipsum dolor sit amet',
			'street' => 'Lorem ipsum dolor sit amet',
			'lat' => 3,
			'lng' => 3,
			'formatted_address' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-12-26 17:20:20',
			'modified' => '2012-12-26 17:20:20',
		],
		[
			'state_id' => 4,
			'country_id' => 4,
			'postal_code' => 'Lorem ip',
			'city' => 'Lorem ipsum dolor sit amet',
			'street' => 'Lorem ipsum dolor sit amet',
			'lat' => 4,
			'lng' => 4,
			'formatted_address' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-12-26 17:20:20',
			'modified' => '2012-12-26 17:20:20',
		],
		[
			'state_id' => 5,
			'country_id' => 5,
			'postal_code' => 'Lorem ip',
			'city' => 'Lorem ipsum dolor sit amet',
			'street' => 'Lorem ipsum dolor sit amet',
			'lat' => 5,
			'lng' => 5,
			'formatted_address' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-12-26 17:20:20',
			'modified' => '2012-12-26 17:20:20',
		],
		[
			'state_id' => 6,
			'country_id' => 6,
			'postal_code' => 'Lorem ip',
			'city' => 'Lorem ipsum dolor sit amet',
			'street' => 'Lorem ipsum dolor sit amet',
			'lat' => 6,
			'lng' => 6,
			'formatted_address' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-12-26 17:20:20',
			'modified' => '2012-12-26 17:20:20',
		],
		[
			'state_id' => 7,
			'country_id' => 7,
			'postal_code' => 'Lorem ip',
			'city' => 'Lorem ipsum dolor sit amet',
			'street' => 'Lorem ipsum dolor sit amet',
			'lat' => 7,
			'lng' => 7,
			'formatted_address' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-12-26 17:20:20',
			'modified' => '2012-12-26 17:20:20',
		],
		[
			'state_id' => 8,
			'country_id' => 8,
			'postal_code' => 'Lorem ip',
			'city' => 'Lorem ipsum dolor sit amet',
			'street' => 'Lorem ipsum dolor sit amet',
			'lat' => 8,
			'lng' => 8,
			'formatted_address' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-12-26 17:20:20',
			'modified' => '2012-12-26 17:20:20',
		],
		[
			'state_id' => 9,
			'country_id' => 9,
			'postal_code' => 'Lorem ip',
			'city' => 'Lorem ipsum dolor sit amet',
			'street' => 'Lorem ipsum dolor sit amet',
			'lat' => 9,
			'lng' => 9,
			'formatted_address' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-12-26 17:20:20',
			'modified' => '2012-12-26 17:20:20',
		],
		[
			'state_id' => 10,
			'country_id' => 10,
			'postal_code' => 'Lorem ip',
			'city' => 'Lorem ipsum dolor sit amet',
			'street' => 'Lorem ipsum dolor sit amet',
			'lat' => 10,
			'lng' => 10,
			'formatted_address' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-12-26 17:20:20',
			'modified' => '2012-12-26 17:20:20',
		],
	];

}
