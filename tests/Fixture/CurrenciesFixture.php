<?php
/* Currency Fixture generated on: 2011-11-20 21:58:59 : 1321822739 */

namespace Data\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CurrenciesFixture
 */
class CurrenciesFixture extends TestFixture {

	/**
	 * Fields
	 *
	 * @var array
	 */
	public array $fields = [
		'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'collate' => null, 'comment' => ''],
		'name' => ['type' => 'string', 'null' => false, 'comment' => '', 'charset' => 'utf8'],
		'code' => ['type' => 'string', 'null' => false, 'length' => 3, 'comment' => '', 'charset' => 'utf8'],
		'symbol_left' => ['type' => 'string', 'null' => true, 'length' => 12, 'comment' => '', 'charset' => 'utf8'],
		'symbol_right' => ['type' => 'string', 'null' => true, 'length' => 12, 'comment' => '', 'charset' => 'utf8'],
		'decimal_places' => ['type' => 'string', 'null' => true, 'length' => 1, 'comment' => '', 'charset' => 'utf8'],
		'value' => ['type' => 'float', 'null' => true, 'default' => '0.0000', 'length' => '9,4', 'collate' => null, 'comment' => ''],
		'base' => ['type' => 'boolean', 'null' => false, 'default' => '0', 'collate' => null, 'comment' => 'is base currency'],
		'active' => ['type' => 'boolean', 'null' => false, 'default' => '0', 'collate' => null, 'comment' => ''],
		'modified' => ['type' => 'datetime', 'null' => false, 'default' => null, 'collate' => null, 'comment' => ''],
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
			'name' => 'US Dollar',
			'code' => 'USD',
			'symbol_left' => '$',
			'symbol_right' => '',
			'decimal_places' => '2',
			'value' => '1.4146',
			'base' => 0,
			'active' => 1,
			'modified' => '2011-07-16 15:12:33',
		],
		[
			'name' => 'Euro',
			'code' => 'EUR',
			'symbol_left' => '€',
			'symbol_right' => '',
			'decimal_places' => '2',
			'value' => '1.0000',
			'base' => 1,
			'active' => 1,
			'modified' => '2009-11-23 12:45:15',
		],
		[
			'name' => 'British Pounds',
			'code' => 'GBP',
			'symbol_left' => '£',
			'symbol_right' => '',
			'decimal_places' => '2',
			'value' => '0.8775',
			'base' => 0,
			'active' => 1,
			'modified' => '2011-07-16 15:12:33',
		],
		[
			'name' => 'Schweizer Franken',
			'code' => 'CHF',
			'symbol_left' => '',
			'symbol_right' => 'Fr.',
			'decimal_places' => '2',
			'value' => '1.1577',
			'base' => 0,
			'active' => 1,
			'modified' => '2011-07-16 15:12:33',
		],
		[
			'name' => 'Australien Dollar',
			'code' => 'AUD',
			'symbol_left' => '',
			'symbol_right' => '',
			'decimal_places' => '2',
			'value' => '1.3264',
			'base' => 0,
			'active' => 0,
			'modified' => '2011-07-16 15:12:33',
		],
		[
			'name' => 'Canadian Dollar',
			'code' => 'CAD',
			'symbol_left' => '',
			'symbol_right' => '',
			'decimal_places' => '2',
			'value' => '1.3549',
			'base' => 0,
			'active' => 0,
			'modified' => '2011-07-16 15:12:33',
		],
		[
			'name' => 'Japanese Yen',
			'code' => 'JPY',
			'symbol_left' => '',
			'symbol_right' => '',
			'decimal_places' => '2',
			'value' => '111.9700',
			'base' => 0,
			'active' => 0,
			'modified' => '2011-07-16 15:12:33',
		],
		[
			'name' => 'Mexican Peso',
			'code' => 'MXN',
			'symbol_left' => '',
			'symbol_right' => '',
			'decimal_places' => '2',
			'value' => '16.5510',
			'base' => 0,
			'active' => 0,
			'modified' => '2011-07-16 15:12:33',
		],
		[
			'name' => 'Norwegian Krone',
			'code' => 'NOK',
			'symbol_left' => '',
			'symbol_right' => '',
			'decimal_places' => '2',
			'value' => '7.8665',
			'base' => 0,
			'active' => 0,
			'modified' => '2011-07-16 15:12:33',
		],
		[
			'name' => 'Swedish Krona',
			'code' => 'SEK',
			'symbol_left' => '',
			'symbol_right' => '',
			'decimal_places' => '2',
			'value' => '9.2121',
			'base' => 0,
			'active' => 0,
			'modified' => '2011-07-16 15:12:33',
		],
	];

}
