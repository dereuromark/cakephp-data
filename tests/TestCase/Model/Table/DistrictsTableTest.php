<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\TestCase;

class DistrictsTableTest extends TestCase {

	/**
	 * @var array
	 */
	public $fixtures = [
		'plugin.Data.Districts',
	];

	/**
	 * @var \Data\Model\Table\DistrictsTable
	 */
	protected $Districts;

	/**
	 * @return void
	 */
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
