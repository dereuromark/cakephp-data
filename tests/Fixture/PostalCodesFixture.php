<?php
namespace Data\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;


/**
 * PostalCodesFixture
 *
 */
class PostalCodesFixture extends TestFixture {

	/**
	 * Fields
	 *
	 * @var array
	 */
	public $fields = [
		'id' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'],
		'code' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 5, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'],
		'country_id' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2, 'collate' => null, 'comment' => ''],
		'lat' => ['type' => 'float', 'null' => false, 'default' => '0.0000', 'length' => '9,4', 'collate' => null, 'comment' => ''],
		'lng' => ['type' => 'float', 'null' => false, 'default' => '0.0000', 'length' => '9,4', 'collate' => null, 'comment' => ''],
		'official_address' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'],
		'created' => ['type' => 'datetime', 'null' => true, 'default' => null, 'collate' => null, 'comment' => ''],
		'modified' => ['type' => 'datetime', 'null' => true, 'default' => null, 'collate' => null, 'comment' => ''],
		'_constraints' => ['primary' => ['type' => 'primary', 'columns' => ['id']]],
		'_options' => []
	];

	/**
	 * Records
	 *
	 * @var array
	 */
	public $records = [
	/*
		'id' => '1',
		'code' => '81234',
		'country_id' => 1,
		'lat' => 11,
		'lng' => 12,
		'official_adress' => 'Foo bar',
		'created' => null,
		'modified' => null
	*/
	];
}
