<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\TestCase;

class CitiesTableTest extends TestCase {

	/**
	 * @var array
	 */
	public $fixtures = [
		'plugin.Data.Cities',
	];

	/**
	 * @var \Data\Model\Table\CitiesTable
	 */
	protected $Cities;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->Cities = TableRegistry::get('Data.Cities');
	}

	/**
	 * @return void
	 */
	public function tearDown(): void {
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
