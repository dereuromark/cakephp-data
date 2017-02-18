<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Data\Model\Table\LocationsTable;
use Tools\TestSuite\TestCase;

class LocationsTableTest extends TestCase {

	/**
	 * @var array
	 */
	public $fixtures = [
		'plugin.data.locations'
	];

	/**
	 * @var LocationsTable
	 */
	public $Locations;

	/**
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->Locations = TableRegistry::get('Data.Locations');
	}

	/**
	 * @return void
	 */
	public function testBasicFind() {
		$result = $this->Locations->find()->first();
		$this->assertNotEmpty($result);
	}

}
