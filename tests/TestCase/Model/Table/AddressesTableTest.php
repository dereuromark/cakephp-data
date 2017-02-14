<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\TestCase;

class AddressesTableTest extends TestCase {

	/**
	 * @var array
	 */
	public $fixtures = [
		'plugin.data.addresses'
	];

	/**
	 * @var \Data\Model\Table\AddressesTable
	 */
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
