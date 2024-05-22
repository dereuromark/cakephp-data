<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Shim\TestSuite\TestCase;

class DistrictsTableTest extends TestCase {

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.Data.Districts',
	];

	/**
	 * @var \Data\Model\Table\DistrictsTable
	 */
	protected $Districts;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->Districts = TableRegistry::getTableLocator()->get('Data.Districts');
	}

	/**
	 * @return void
	 */
	public function testBasicFind() {
		$result = $this->Districts->find()->first();
		$this->assertNotEmpty($result);
	}

}
