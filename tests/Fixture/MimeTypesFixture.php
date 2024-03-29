<?php
/**
 * MimeTypesFixture
 */

namespace Data\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class MimeTypesFixture extends TestFixture {

	/**
	 * Fields
	 *
	 * @var array
	 */
	public array $fields = [
		'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true],
		'name' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'comment' => 'Program Name', 'charset' => 'utf8'],
		'ext' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'comment' => 'extension (lowercase!)', 'charset' => 'utf8'],
		'type' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 200, 'charset' => 'utf8'],
		'details' => ['type' => 'string', 'null' => false, 'default' => null, 'charset' => 'utf8'],
		'core' => ['type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'if part of core definitions'],
		'active' => ['type' => 'boolean', 'null' => false, 'default' => '0'],
		'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
		'modified' => ['type' => 'datetime', 'null' => false, 'default' => null],
		'sort' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => true, 'comment' => 'often used ones should be on top'],
		'mime_type_image_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'unsigned' => true],
		'alt_type' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 200, 'comment' => 'alternate (sometimes there is more than one type)', 'charset' => 'utf8'],
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
			'name' => 'Lorem ipsum dolor sit amet',
			'ext' => 'Lorem ipsum dolor ',
			'type' => 'Lorem ipsum dolor sit amet',
			'details' => 'Lorem ipsum dolor sit amet',
			'core' => 1,
			'active' => 1,
			'created' => '2014-07-23 14:07:02',
			'modified' => '2014-07-23 14:07:02',
			'sort' => 1,
			'mime_type_image_id' => 1,
			'alt_type' => 'Lorem ipsum dolor sit amet',
		],
	];

}
