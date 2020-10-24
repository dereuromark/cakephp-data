<?php

namespace Data\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PostalCodesFixture
 */
class PostalCodesFixture extends TestFixture {

	/**
	 * Fields
	 *
	 * @var array
	 */
	public $fields = [
		'id' => ['type' => 'uuid', 'null' => false, 'default' => null, 'length' => 36],
		'code' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 5],
		'country_id' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2, 'collate' => null],
		'lat' => ['type' => 'float', 'null' => false, 'default' => '0.0000', 'length' => '9,4', 'collate' => null],
		'lng' => ['type' => 'float', 'null' => false, 'default' => '0.0000', 'length' => '9,4', 'collate' => null],
		'official_address' => ['type' => 'string', 'null' => false, 'default' => null],
		'created' => ['type' => 'datetime', 'null' => true, 'default' => null, 'collate' => null],
		'modified' => ['type' => 'datetime', 'null' => true, 'default' => null, 'collate' => null],
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
			'id' => 'e23',
			'code' => '81234',
			'country_id' => 1,
			'lat' => 11,
			'lng' => 12,
			'official_address' => 'Foo bar',
			'created' => '2011-07-15 19:47:38',
			'modified' => '2011-07-15 19:47:38',
		],
	];

}
