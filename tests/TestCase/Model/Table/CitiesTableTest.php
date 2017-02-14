<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Data\Model\Table\CitiesTable;
use Tools\TestSuite\TestCase;

class CitiesTableTest extends TestCase {

	/**
	 * @var array
	 */
	public $fixtures = [
		'plugin.data.cities'
	];

	/**
	 * @var CitiesTable
	 */
	public $Cities;

	public function setUp() {
		parent::setUp();

		$this->Cities = TableRegistry::get('Data.Cities');
	}

	/**
	 * CitiesTableTest::testBasicFind()
	 *
	 * @return void
	 */
	public function testBasicFind() {
		$result = $this->Cities->find()->first();
		$this->assertNotEmpty($result);
	}

}
