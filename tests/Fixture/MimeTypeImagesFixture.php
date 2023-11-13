<?php
/**
 * MimeTypeImagesFixture
 */

namespace Data\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class MimeTypeImagesFixture extends TestFixture {

	/**
	 * Fields
	 *
	 * @var array
	 */
	public array $fields = [
		'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true],
		'name' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'comment' => 'extension (e.g. jpg)', 'charset' => 'utf8'],
		'ext' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'comment' => 'extension (lowercase!) of real image (exe.gif -> gif)', 'charset' => 'utf8'],
		'active' => ['type' => 'boolean', 'null' => false, 'default' => '0'],
		'details' => ['type' => 'string', 'null' => false, 'default' => null, 'charset' => 'utf8'],
		'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
		'modified' => ['type' => 'datetime', 'null' => false, 'default' => null],
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
			'active' => 1,
			'details' => 'Lorem ipsum dolor sit amet',
			'created' => '2014-07-23 14:06:49',
			'modified' => '2014-07-23 14:06:49',
		],
	];

}
