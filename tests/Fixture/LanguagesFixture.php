<?php

namespace Data\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LanguagesFixture
 */
class LanguagesFixture extends TestFixture {

	/**
	 * Fields
	 *
	 * @var array
	 */
	public array $fields = [
		'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'collate' => null, 'comment' => ''],
		'name' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 40, 'comment' => '', 'charset' => 'utf8'],
		'ori_name' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 40, 'comment' => '', 'charset' => 'utf8'],
		'code' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 6, 'comment' => '', 'charset' => 'utf8'],
		'iso3' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 3, 'comment' => '', 'charset' => 'utf8'],
		'iso2' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 2, 'comment' => '', 'charset' => 'utf8'],
		'locale' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'comment' => '', 'charset' => 'utf8'],
		'locale_fallback' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'comment' => '', 'charset' => 'utf8'],
		'status' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2, 'collate' => null, 'comment' => ''],
		'sort' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'collate' => null, 'comment' => ''],
		'direction' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2, 'collate' => null, 'comment' => ''],
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
			'id' => '1',
			'name' => 'Deutsch',
			'ori_name' => 'German',
			'code' => 'de',
			'iso3' => 'deu',
			'iso2' => 'de',
			'locale' => 'deu',
			'locale_fallback' => 'deu',
			'status' => '1',
			'sort' => '0',
			'modified' => '2011-07-17 15:23:08',
		],
		[
			'id' => '2',
			'name' => 'Deutsch (Deutschland)',
			'ori_name' => 'German',
			'code' => 'de',
			'iso3' => 'deu',
			'iso2' => 'de',
			'locale' => 'de_DE',
			'locale_fallback' => 'deu',
			'status' => '0',
			'sort' => '0',
			'modified' => '2011-07-17 15:23:08',
		],
		[
			'id' => '3',
			'name' => 'Englisch',
			'ori_name' => 'English',
			'code' => 'en',
			'iso3' => 'eng',
			'iso2' => 'en',
			'locale' => 'en_US',
			'locale_fallback' => 'eng',
			'status' => '1',
			'sort' => '0',
			'modified' => '2011-07-17 15:23:08',
		],
	];

}
