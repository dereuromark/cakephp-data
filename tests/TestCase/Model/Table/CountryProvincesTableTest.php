<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\TestCase;

class CountryProvincesTableTest extends TestCase {

	public $fixtures = [
		'plugin.data.country_provinces'
	];

	public $CountryProvinces;

	public function setUp() {
		parent::setUp();

		$this->CountryProvinces = TableRegistry::get('Data.CountryProvinces');
	}

	/**
	 *
	 * @return void
	 */
	public function testBasicFind() {
		$result = $this->CountryProvinces->find()->first();
		$this->assertNotEmpty($result);
	}
}
