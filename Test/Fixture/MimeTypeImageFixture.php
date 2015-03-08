<?php
/**
 * MimeTypeImageFixture
 *
 */
class MimeTypeImageFixture extends CakeTestFixture {

	/**
	 * Fields
	 *
	 * @var array
	 */
	public $fields = [
		'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'],
		'name' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'comment' => 'extension (e.g. jpg)', 'charset' => 'utf8'],
		'ext' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'utf8_unicode_ci', 'comment' => 'extension (lowercase!) of real image (exe.gif -> gif)', 'charset' => 'utf8'],
		'active' => ['type' => 'boolean', 'null' => false, 'default' => '0'],
		'details' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
		'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
		'modified' => ['type' => 'datetime', 'null' => false, 'default' => null],
		'indexes' => [
			'PRIMARY' => ['column' => 'id', 'unique' => 1]
		],
		'tableParameters' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM']
	];

	/**
	 * Records
	 *
	 * @var array
	 */
	public $records = [
		[
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'ext' => 'Lorem ipsum dolor ',
			'active' => 1,
			'details' => 'Lorem ipsum dolor sit amet',
			'created' => '2014-07-23 14:06:49',
			'modified' => '2014-07-23 14:06:49'
		],
		[
			'id' => 2,
			'name' => 'Lorem ipsum dolor sit amet',
			'ext' => 'Lorem ipsum dolor ',
			'active' => 1,
			'details' => 'Lorem ipsum dolor sit amet',
			'created' => '2014-07-23 14:06:49',
			'modified' => '2014-07-23 14:06:49'
		],
		[
			'id' => 3,
			'name' => 'Lorem ipsum dolor sit amet',
			'ext' => 'Lorem ipsum dolor ',
			'active' => 1,
			'details' => 'Lorem ipsum dolor sit amet',
			'created' => '2014-07-23 14:06:49',
			'modified' => '2014-07-23 14:06:49'
		],
		[
			'id' => 4,
			'name' => 'Lorem ipsum dolor sit amet',
			'ext' => 'Lorem ipsum dolor ',
			'active' => 1,
			'details' => 'Lorem ipsum dolor sit amet',
			'created' => '2014-07-23 14:06:49',
			'modified' => '2014-07-23 14:06:49'
		],
		[
			'id' => 5,
			'name' => 'Lorem ipsum dolor sit amet',
			'ext' => 'Lorem ipsum dolor ',
			'active' => 1,
			'details' => 'Lorem ipsum dolor sit amet',
			'created' => '2014-07-23 14:06:49',
			'modified' => '2014-07-23 14:06:49'
		],
		[
			'id' => 6,
			'name' => 'Lorem ipsum dolor sit amet',
			'ext' => 'Lorem ipsum dolor ',
			'active' => 1,
			'details' => 'Lorem ipsum dolor sit amet',
			'created' => '2014-07-23 14:06:49',
			'modified' => '2014-07-23 14:06:49'
		],
		[
			'id' => 7,
			'name' => 'Lorem ipsum dolor sit amet',
			'ext' => 'Lorem ipsum dolor ',
			'active' => 1,
			'details' => 'Lorem ipsum dolor sit amet',
			'created' => '2014-07-23 14:06:49',
			'modified' => '2014-07-23 14:06:49'
		],
		[
			'id' => 8,
			'name' => 'Lorem ipsum dolor sit amet',
			'ext' => 'Lorem ipsum dolor ',
			'active' => 1,
			'details' => 'Lorem ipsum dolor sit amet',
			'created' => '2014-07-23 14:06:49',
			'modified' => '2014-07-23 14:06:49'
		],
		[
			'id' => 9,
			'name' => 'Lorem ipsum dolor sit amet',
			'ext' => 'Lorem ipsum dolor ',
			'active' => 1,
			'details' => 'Lorem ipsum dolor sit amet',
			'created' => '2014-07-23 14:06:49',
			'modified' => '2014-07-23 14:06:49'
		],
		[
			'id' => 10,
			'name' => 'Lorem ipsum dolor sit amet',
			'ext' => 'Lorem ipsum dolor ',
			'active' => 1,
			'details' => 'Lorem ipsum dolor sit amet',
			'created' => '2014-07-23 14:06:49',
			'modified' => '2014-07-23 14:06:49'
		],
	];
}
