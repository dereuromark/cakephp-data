<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\TestCase;

class CitiesTableTest extends TestCase {

	/**
	 * @var array
	 */
	public $fixtures = [
		'plugin.data.cities'
	];

	/**
	 * @var \Data\Model\Table\CitiesTable
	 */
	public $Cities;

	/**
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->Cities = TableRegistry::get('Data.Cities');
	}

	/**
	 * @return void
	 */
	public function tearDown() {
		parent::tearDown();

		TableRegistry::clear();
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
