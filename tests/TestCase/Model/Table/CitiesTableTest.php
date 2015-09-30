<?php

namespace Data\Test\TestCase\Model\Table;

use Data\Model\City;
use Tools\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

class CitiesTableTest extends TestCase {

	public $fixtures = [
		'plugin.data.cities'
	];

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
