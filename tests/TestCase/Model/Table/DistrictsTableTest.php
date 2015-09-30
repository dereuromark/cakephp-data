<?php

namespace Data\Test\TestCase\Model\Table;

use Data\Model\District;
use Tools\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

class DistrictsTableTest extends TestCase {

	public $fixtures = [
		'plugin.data.districts'
	];

	public $Districts;

	public function setUp() {
		parent::setUp();

		$this->Districts = TableRegistry::get('Data.Districts');
	}

	/**
	 *
	 * @return void
	 */
	public function testBasicFind() {
		$result = $this->Districts->find()->first();
		$this->assertNotEmpty($result);
	}

}
