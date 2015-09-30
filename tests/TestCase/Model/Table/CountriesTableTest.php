<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\TestCase;

class CountriesTableTest extends TestCase {

	public $fixtures = [
		'plugin.data.countries'
	];

	public $Countries;

	public function setUp() {
		parent::setUp();

		$this->Countries = TableRegistry::get('Data.Countries');
	}

	/**
	 * CountriesTableTest::testBasicFind()
	 *
	 * @return void
	 */
	public function testBasicFind() {
		$result = $this->Countries->find()->first();
		$this->assertNotEmpty($result);
	}

}
