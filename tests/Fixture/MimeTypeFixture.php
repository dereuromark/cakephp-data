<?php
/**
 * MimeTypeFixture
 *
 */
class MimeTypeFixture extends CakeTestFixture {

	/**
	 * Fields
	 *
	 * @var array
	 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'comment' => 'Program Name', 'charset' => 'utf8'),
		'ext' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'utf8_unicode_ci', 'comment' => 'extension (lowercase!)', 'charset' => 'utf8'),
		'type' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 200, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'details' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'core' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'if part of core definitions'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'sort' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => true, 'comment' => 'often used ones should be on top'),
		'mime_type_image_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => true),
		'alt_type' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 200, 'collate' => 'utf8_unicode_ci', 'comment' => 'alternate (sometimes there is more than one type)', 'charset' => 'utf8'),
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
			'type' => 'Lorem ipsum dolor sit amet',
			'details' => 'Lorem ipsum dolor sit amet',
			'core' => 1,
			'active' => 1,
			'created' => '2014-07-23 14:07:02',
			'modified' => '2014-07-23 14:07:02',
			'sort' => 1,
			'mime_type_image_id' => 1,
			'alt_type' => 'Lorem ipsum dolor sit amet'
		),
		array(
			'id' => 2,
			'name' => 'Lorem ipsum dolor sit amet',
			'ext' => 'Lorem ipsum dolor ',
			'type' => 'Lorem ipsum dolor sit amet',
			'details' => 'Lorem ipsum dolor sit amet',
			'core' => 1,
			'active' => 1,
			'created' => '2014-07-23 14:07:02',
			'modified' => '2014-07-23 14:07:02',
			'sort' => 2,
			'mime_type_image_id' => 2,
			'alt_type' => 'Lorem ipsum dolor sit amet'
		),
		array(
			'id' => 3,
			'name' => 'Lorem ipsum dolor sit amet',
			'ext' => 'Lorem ipsum dolor ',
			'type' => 'Lorem ipsum dolor sit amet',
			'details' => 'Lorem ipsum dolor sit amet',
			'core' => 1,
			'active' => 1,
			'created' => '2014-07-23 14:07:02',
			'modified' => '2014-07-23 14:07:02',
			'sort' => 3,
			'mime_type_image_id' => 3,
			'alt_type' => 'Lorem ipsum dolor sit amet'
		),
		array(
			'id' => 4,
			'name' => 'Lorem ipsum dolor sit amet',
			'ext' => 'Lorem ipsum dolor ',
			'type' => 'Lorem ipsum dolor sit amet',
			'details' => 'Lorem ipsum dolor sit amet',
			'core' => 1,
			'active' => 1,
			'created' => '2014-07-23 14:07:02',
			'modified' => '2014-07-23 14:07:02',
			'sort' => 4,
			'mime_type_image_id' => 4,
			'alt_type' => 'Lorem ipsum dolor sit amet'
		),
		array(
			'id' => 5,
			'name' => 'Lorem ipsum dolor sit amet',
			'ext' => 'Lorem ipsum dolor ',
			'type' => 'Lorem ipsum dolor sit amet',
			'details' => 'Lorem ipsum dolor sit amet',
			'core' => 1,
			'active' => 1,
			'created' => '2014-07-23 14:07:02',
			'modified' => '2014-07-23 14:07:02',
			'sort' => 5,
			'mime_type_image_id' => 5,
			'alt_type' => 'Lorem ipsum dolor sit amet'
		),
		array(
			'id' => 6,
			'name' => 'Lorem ipsum dolor sit amet',
			'ext' => 'Lorem ipsum dolor ',
			'type' => 'Lorem ipsum dolor sit amet',
			'details' => 'Lorem ipsum dolor sit amet',
			'core' => 1,
			'active' => 1,
			'created' => '2014-07-23 14:07:02',
			'modified' => '2014-07-23 14:07:02',
			'sort' => 6,
			'mime_type_image_id' => 6,
			'alt_type' => 'Lorem ipsum dolor sit amet'
		),
		array(
			'id' => 7,
			'name' => 'Lorem ipsum dolor sit amet',
			'ext' => 'Lorem ipsum dolor ',
			'type' => 'Lorem ipsum dolor sit amet',
			'details' => 'Lorem ipsum dolor sit amet',
			'core' => 1,
			'active' => 1,
			'created' => '2014-07-23 14:07:02',
			'modified' => '2014-07-23 14:07:02',
			'sort' => 7,
			'mime_type_image_id' => 7,
			'alt_type' => 'Lorem ipsum dolor sit amet'
		),
		array(
			'id' => 8,
			'name' => 'Lorem ipsum dolor sit amet',
			'ext' => 'Lorem ipsum dolor ',
			'type' => 'Lorem ipsum dolor sit amet',
			'details' => 'Lorem ipsum dolor sit amet',
			'core' => 1,
			'active' => 1,
			'created' => '2014-07-23 14:07:02',
			'modified' => '2014-07-23 14:07:02',
			'sort' => 8,
			'mime_type_image_id' => 8,
			'alt_type' => 'Lorem ipsum dolor sit amet'
		),
		array(
			'id' => 9,
			'name' => 'Lorem ipsum dolor sit amet',
			'ext' => 'Lorem ipsum dolor ',
			'type' => 'Lorem ipsum dolor sit amet',
			'details' => 'Lorem ipsum dolor sit amet',
			'core' => 1,
			'active' => 1,
			'created' => '2014-07-23 14:07:02',
			'modified' => '2014-07-23 14:07:02',
			'sort' => 9,
			'mime_type_image_id' => 9,
			'alt_type' => 'Lorem ipsum dolor sit amet'
		),
		array(
			'id' => 10,
			'name' => 'Lorem ipsum dolor sit amet',
			'ext' => 'Lorem ipsum dolor ',
			'type' => 'Lorem ipsum dolor sit amet',
			'details' => 'Lorem ipsum dolor sit amet',
			'core' => 1,
			'active' => 1,
			'created' => '2014-07-23 14:07:02',
			'modified' => '2014-07-23 14:07:02',
			'sort' => 10,
			'mime_type_image_id' => 10,
			'alt_type' => 'Lorem ipsum dolor sit amet'
		),
	);
}
