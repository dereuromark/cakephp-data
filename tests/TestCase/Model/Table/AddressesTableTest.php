<?php

namespace Data\Test\TestCase\Model\Table;

use App\Model\Entity\Address;
use App\Model\Table\AddressesTable;
use Tools\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

class AddressesTableTest extends TestCase {

	public $fixtures = [
		'plugin.data.addresses'
	];

	/**
	 * @var AddressesTable
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

	/**
	 * @return void
	 */
	public function testAdd() {
		$result = $this->Addresses->add(1, 1, Address::TYPE_TO, ['email' => 'foo@bar.de']);
		debug($result);
	}
}
