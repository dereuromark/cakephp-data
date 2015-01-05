<?php
/**
 * MimeTypeImageFixture
 *
 */
namespace Data\Test\Fixture;

class MimeTypeImageFixture extends TestFixture {

	/**
	 * Fields
	 *
	 * @var array
	 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'comment' => 'extension (e.g. jpg)', 'charset' => 'utf8'),
		'ext' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'utf8_unicode_ci', 'comment' => 'extension (lowercase!) of real image (exe.gif -> gif)', 'charset' => 'utf8'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'details' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
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
			'name' => 'Lorem ipsum dolor sit amet',
			'ext' => 'Lorem ipsum dolor ',
			'active' => 1,
			'details' => 'Lorem ipsum dolor sit amet',
			'created' => '2014-07-23 14:06:49',
			'modified' => '2014-07-23 14:06:49'
		),
		array(
			'id' => 2,
			'name' => 'Lorem ipsum dolor sit amet',
			'ext' => 'Lorem ipsum dolor ',
			'active' => 1,
			'details' => 'Lorem ipsum dolor sit amet',
			'created' => '2014-07-23 14:06:49',
			'modified' => '2014-07-23 14:06:49'
		),
		array(
			'id' => 3,
			'name' => 'Lorem ipsum dolor sit amet',
			'ext' => 'Lorem ipsum dolor ',
			'active' => 1,
			'details' => 'Lorem ipsum dolor sit amet',
			'created' => '2014-07-23 14:06:49',
			'modified' => '2014-07-23 14:06:49'
		),
		array(
			'id' => 4,
			'name' => 'Lorem ipsum dolor sit amet',
			'ext' => 'Lorem ipsum dolor ',
			'active' => 1,
			'details' => 'Lorem ipsum dolor sit amet',
			'created' => '2014-07-23 14:06:49',
			'modified' => '2014-07-23 14:06:49'
		),
		array(
			'id' => 5,
			'name' => 'Lorem ipsum dolor sit amet',
			'ext' => 'Lorem ipsum dolor ',
			'active' => 1,
			'details' => 'Lorem ipsum dolor sit amet',
			'created' => '2014-07-23 14:06:49',
			'modified' => '2014-07-23 14:06:49'
		),
		array(
			'id' => 6,
			'name' => 'Lorem ipsum dolor sit amet',
			'ext' => 'Lorem ipsum dolor ',
			'active' => 1,
			'details' => 'Lorem ipsum dolor sit amet',
			'created' => '2014-07-23 14:06:49',
			'modified' => '2014-07-23 14:06:49'
		),
		array(
			'id' => 7,
			'name' => 'Lorem ipsum dolor sit amet',
			'ext' => 'Lorem ipsum dolor ',
			'active' => 1,
			'details' => 'Lorem ipsum dolor sit amet',
			'created' => '2014-07-23 14:06:49',
			'modified' => '2014-07-23 14:06:49'
		),
		array(
			'id' => 8,
			'name' => 'Lorem ipsum dolor sit amet',
			'ext' => 'Lorem ipsum dolor ',
			'active' => 1,
			'details' => 'Lorem ipsum dolor sit amet',
			'created' => '2014-07-23 14:06:49',
			'modified' => '2014-07-23 14:06:49'
		),
		array(
			'id' => 9,
			'name' => 'Lorem ipsum dolor sit amet',
			'ext' => 'Lorem ipsum dolor ',
			'active' => 1,
			'details' => 'Lorem ipsum dolor sit amet',
			'created' => '2014-07-23 14:06:49',
			'modified' => '2014-07-23 14:06:49'
		),
		array(
			'id' => 10,
			'name' => 'Lorem ipsum dolor sit amet',
			'ext' => 'Lorem ipsum dolor ',
			'active' => 1,
			'details' => 'Lorem ipsum dolor sit amet',
			'created' => '2014-07-23 14:06:49',
			'modified' => '2014-07-23 14:06:49'
		),
	);
}
