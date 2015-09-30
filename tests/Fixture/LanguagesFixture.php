<?php
namespace Data\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LanguagesFixture
 *
 */
class LanguagesFixture extends TestFixture {

	/**
	 * Fields
	 *
	 * @var array
	 */
	public $fields = [
		'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'collate' => null, 'comment' => ''],
		'name' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 40, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'],
		'ori_name' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 40, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'],
		'code' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 6, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'],
		'iso3' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 3, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'],
		'iso2' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 2, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'],
		'locale' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'],
		'locale_fallback' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'],
		'status' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2, 'collate' => null, 'comment' => ''],
		'sort' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'collate' => null, 'comment' => ''],
		'modified' => ['type' => 'datetime', 'null' => false, 'default' => null, 'collate' => null, 'comment' => ''],
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
			'id' => '25',
			'name' => 'Deutsch',
			'ori_name' => 'German',
			'code' => 'de',
			'iso3' => '',
			'iso2' => '',
			'locale' => 'de_DE',
			'locale_fallback' => 'deu',
			'status' => '0',
			'sort' => '0',
			'modified' => '2011-07-17 15:23:08'
		],
		[
			'id' => '2',
			'name' => 'Arabic',
			'ori_name' => 'Arabic',
			'code' => 'ar',
			'iso3' => '',
			'iso2' => '',
			'locale' => 'ara',
			'locale_fallback' => 'ara',
			'status' => '0',
			'sort' => '0',
			'modified' => '2011-07-17 15:23:08'
		],
		[
			'id' => '3',
			'name' => 'Arabic (U.A.E.)',
			'ori_name' => 'Arabic (U.A.E.)',
			'code' => 'ar',
			'iso3' => '',
			'iso2' => '',
			'locale' => 'ar_ae',
			'locale_fallback' => 'ara',
			'status' => '0',
			'sort' => '0',
			'modified' => '2011-07-17 15:23:08'
		],
		[
			'id' => '4',
			'name' => 'Arabic (Bahrain)',
			'ori_name' => 'Arabic (Bahrain)',
			'code' => 'ar',
			'iso3' => '',
			'iso2' => '',
			'locale' => 'ar_bh',
			'locale_fallback' => 'ara',
			'status' => '0',
			'sort' => '0',
			'modified' => '2011-07-17 15:23:08'
		],
		[
			'id' => '5',
			'name' => 'Arabic (Algeria)',
			'ori_name' => 'Arabic (Algeria)',
			'code' => 'ar',
			'iso3' => '',
			'iso2' => '',
			'locale' => 'ar_dz',
			'locale_fallback' => 'ara',
			'status' => '0',
			'sort' => '0',
			'modified' => '2011-07-17 15:23:08'
		],
		[
			'id' => '6',
			'name' => 'Arabic (Egypt)',
			'ori_name' => 'Arabic (Egypt)',
			'code' => 'ar',
			'iso3' => '',
			'iso2' => '',
			'locale' => 'ar_eg',
			'locale_fallback' => 'ara',
			'status' => '0',
			'sort' => '0',
			'modified' => '2011-07-17 15:23:08'
		],
		[
			'id' => '7',
			'name' => 'Arabic (Iraq)',
			'ori_name' => 'Arabic (Iraq)',
			'code' => 'ar',
			'iso3' => '',
			'iso2' => '',
			'locale' => 'ar_iq',
			'locale_fallback' => 'ara',
			'status' => '0',
			'sort' => '0',
			'modified' => '2011-07-17 15:23:08'
		],
		[
			'id' => '8',
			'name' => 'Arabic (Jordan)',
			'ori_name' => 'Arabic (Jordan)',
			'code' => 'ar',
			'iso3' => '',
			'iso2' => '',
			'locale' => 'ar_jo',
			'locale_fallback' => 'ara',
			'status' => '0',
			'sort' => '0',
			'modified' => '2011-07-17 15:23:08'
		],
		[
			'id' => '9',
			'name' => 'Arabic (Kuwait)',
			'ori_name' => 'Arabic (Kuwait)',
			'code' => 'ar',
			'iso3' => '',
			'iso2' => '',
			'locale' => 'ar_kw',
			'locale_fallback' => 'ara',
			'status' => '0',
			'sort' => '0',
			'modified' => '2011-07-17 15:23:08'
		],
		[
			'id' => '10',
			'name' => 'Arabic (Lebanon)',
			'ori_name' => 'Arabic (Lebanon)',
			'code' => 'ar',
			'iso3' => '',
			'iso2' => '',
			'locale' => 'ar_lb',
			'locale_fallback' => 'ara',
			'status' => '0',
			'sort' => '0',
			'modified' => '2011-07-17 15:23:08'
		],
	];
}
