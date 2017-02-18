<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Data\Model\Table\DistrictsTable;
use Tools\TestSuite\TestCase;

class DistrictsTableTest extends TestCase {

	/**
	 * @var array
	 */
	public $fixtures = [
		'plugin.data.districts'
	];

	/**
	 * @var DistrictsTable
	 */
	public $Districts;

	public function setUp() {
		parent::setUp();

		$this->Districts = TableRegistry::get('Data.Districts');
	}

	/**
	 * @return void
	 */
	public function testBasicFind() {
		$result = $this->Districts->find()->first();
		$this->assertNotEmpty($result);
	}

}
