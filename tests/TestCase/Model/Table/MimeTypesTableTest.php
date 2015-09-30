<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\TestCase;

class MimeTypesTableTest extends TestCase {

	public $fixtures = [
		'plugin.data.mime_types'
	];

	public $MimeTypes;

	public function setUp() {
		parent::setUp();

		$this->MimeTypes = TableRegistry::get('Data.MimeTypes');
	}

	/**
	 *
	 * @return void
	 */
	public function testBasicFind() {
		$result = $this->MimeTypes->find()->first();
		$this->assertNotEmpty($result);
	}

}
