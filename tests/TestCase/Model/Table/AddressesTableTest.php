<?php

namespace Data\Test\TestCase\Model\Table;

use Data\Model\Address;
use Tools\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

class AddressesTableTest extends TestCase {

	public $fixtures = [
		'plugin.data.addresses'
	];

	public $Addresses;

	public function setUp() {
		parent::setUp();

		$this->Addresses = TableRegistry::get('Data.Addresses');
	}

	/**
	 * AddressesTableTest::testBasicFind()
	 *
	 * @return void
	 */
	public function testBasicFind() {
		$result = $this->Addresses->find()->first();
		$this->assertNotEmpty($result);
	}

}
