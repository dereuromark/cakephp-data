<?php

namespace Data\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CountriesFixture
 */
class CountriesFixture extends TestFixture {

	/**
	 * Fields
	 *
	 * @var array
	 */
	public array $fields = [
		'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'collate' => null, 'comment' => ''],
		'name' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'comment' => '', 'charset' => 'utf8'],
		'ori_name' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'comment' => '', 'charset' => 'utf8'],
		'iso2' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 2, 'comment' => '', 'charset' => 'utf8'],
		'iso3' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 3, 'comment' => '', 'charset' => 'utf8'],
		'continent_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'collate' => null, 'comment' => ''],
		'phone_code' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'comment' => ''],
		'eu_member' => ['type' => 'boolean', 'null' => false, 'default' => '0', 'collate' => null, 'comment' => 'Member of the EU'],
		'special' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 40, 'comment' => '', 'charset' => 'utf8'],
		'zip_length' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2, 'collate' => null, 'comment' => 'if > 0 validate on this length'],
		'zip_regexp' => ['type' => 'string', 'null' => true, 'default' => null, 'comment' => '', 'charset' => 'utf8'],
		'sort' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'collate' => null, 'comment' => ''],
		'lat' => ['type' => 'float', 'null' => true, 'default' => null, 'length' => '10,6', 'collate' => null, 'comment' => 'forGoogleMap'],
		'lng' => ['type' => 'float', 'null' => true, 'default' => null, 'length' => '10,6', 'collate' => null, 'comment' => 'forGoogleMap'],
		'address_format' => ['type' => 'string', 'null' => true, 'default' => null, 'comment' => '', 'charset' => 'utf8'],
		'timezone_offset' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => '', 'charset' => 'utf8'],
		'status' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2, 'collate' => null, 'comment' => ''],
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
			'name' => 'Deutschland',
			'ori_name' => 'Deutschland',
			'iso2' => 'DE',
			'iso3' => 'DEU',
			'continent_id' => '0',
			'phone_code' => '49',
			'eu_member' => 1,
			'special' => '',
			'zip_length' => '5',
			'zip_regexp' => '',
			'sort' => '3',
			'lat' => '51.165691',
			'lng' => '10.451526',
			'address_format' => ':name :street_address D-:postcode :city :country',
			'status' => '1',
			'modified' => '2010-06-06 00:19:04',
		],
		[
			'name' => 'Österreich',
			'ori_name' => 'Österreich',
			'iso2' => 'AT',
			'iso3' => 'AUT',
			'continent_id' => '0',
			'phone_code' => '43',
			'eu_member' => 1,
			'special' => '',
			'zip_length' => '0',
			'zip_regexp' => '',
			'sort' => '2',
			'lat' => '47.516232',
			'lng' => '14.550072',
			'address_format' => '',
			'status' => '1',
			'modified' => '2010-06-06 00:19:04',
		],
		[
			'name' => 'Schweiz',
			'ori_name' => 'Schweiz',
			'iso2' => 'CH',
			'iso3' => 'CHE',
			'continent_id' => '0',
			'phone_code' => '41',
			'eu_member' => 0,
			'special' => '',
			'zip_length' => '0',
			'zip_regexp' => '',
			'sort' => '1',
			'lat' => '46.818188',
			'lng' => '8.227512',
			'address_format' => '',
			'status' => '1',
			'modified' => '2010-06-06 00:19:04',
		],
		[
			'name' => 'Belgien',
			'ori_name' => 'Belgium',
			'iso2' => 'BE',
			'iso3' => 'BEL',
			'continent_id' => '0',
			'phone_code' => '32',
			'eu_member' => 1,
			'special' => '',
			'zip_length' => '0',
			'zip_regexp' => '',
			'sort' => '0',
			'lat' => '50.503887',
			'lng' => '4.469936',
			'address_format' => '',
			'status' => '1',
			'modified' => '2010-06-06 00:19:09',
		],
		[
			'name' => 'Niederlande',
			'ori_name' => 'Netherlands',
			'iso2' => 'NL',
			'iso3' => 'NLD',
			'continent_id' => '0',
			'phone_code' => '31',
			'eu_member' => 1,
			'special' => '',
			'zip_length' => '0',
			'zip_regexp' => '',
			'sort' => '0',
			'lat' => '52.132633',
			'lng' => '5.291266',
			'address_format' => '',
			'status' => '1',
			'modified' => '2010-06-06 00:19:40',
		],
		[
			'name' => 'Dänemark',
			'ori_name' => 'Denmark',
			'iso2' => 'DK',
			'iso3' => 'DNK',
			'continent_id' => '0',
			'phone_code' => '45',
			'eu_member' => 1,
			'special' => '',
			'zip_length' => '0',
			'zip_regexp' => '',
			'sort' => '0',
			'lat' => '56.263920',
			'lng' => '9.501785',
			'address_format' => '',
			'status' => '1',
			'modified' => '2010-06-06 00:19:14',
		],
		[
			'name' => 'Luxemburg',
			'ori_name' => 'Luxembourg',
			'iso2' => 'LU',
			'iso3' => 'LUX',
			'continent_id' => '0',
			'phone_code' => '352',
			'eu_member' => 1,
			'special' => '',
			'zip_length' => '0',
			'zip_regexp' => '',
			'sort' => '0',
			'lat' => '49.815273',
			'lng' => '6.129583',
			'address_format' => '',
			'status' => '1',
			'modified' => '2010-06-06 00:19:34',
		],
		[
			'name' => 'Frankreich',
			'ori_name' => 'France',
			'iso2' => 'FR',
			'iso3' => 'FRA',
			'continent_id' => '0',
			'phone_code' => '33',
			'eu_member' => 1,
			'special' => '',
			'zip_length' => '0',
			'zip_regexp' => '',
			'sort' => '0',
			'lat' => '46.227638',
			'lng' => '2.213749',
			'address_format' => '',
			'status' => '1',
			'modified' => '2010-06-06 00:19:17',
		],
		[
			'name' => 'Großbritannien',
			'ori_name' => 'United Kingdom (Great Britian)',
			'iso2' => 'GB',
			'iso3' => 'GBR',
			'continent_id' => '0',
			'phone_code' => '44',
			'eu_member' => 1,
			'special' => '',
			'zip_length' => '0',
			'zip_regexp' => '',
			'sort' => '0',
			'lat' => '55.378052',
			'lng' => '-3.435973',
			'address_format' => '',
			'status' => '1',
			'modified' => '2010-06-06 00:19:19',
		],
		[
			'name' => 'Ukraine',
			'ori_name' => 'Ukraine',
			'iso2' => 'UA',
			'iso3' => 'UKR',
			'continent_id' => '0',
			'phone_code' => '380',
			'eu_member' => 1,
			'special' => '',
			'zip_length' => '0',
			'zip_regexp' => '',
			'sort' => '0',
			'lat' => '48.379433',
			'lng' => '31.165581',
			'address_format' => '',
			'status' => '1',
			'modified' => '2010-06-06 00:19:57',
		],
	];

}
