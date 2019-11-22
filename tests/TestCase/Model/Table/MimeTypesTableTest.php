<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\TestCase;

class MimeTypesTableTest extends TestCase {

	/**
	 * @var array
	 */
	public $fixtures = [
		'plugin.Data.MimeTypes',
	];

	/**
	 * @var \Data\Model\Table\MimeTypesTable
	 */
	public $MimeTypes;

	/**
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->MimeTypes = TableRegistry::get('Data.MimeTypes');
	}

	/**
	 * @return void
	 */
	public function testBasicFind() {
		$result = $this->MimeTypes->find()->first();
		$this->assertNotEmpty($result);
	}

}
