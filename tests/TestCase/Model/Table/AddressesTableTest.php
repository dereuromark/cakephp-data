<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\I18n\Time;
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

	/**
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->Addresses = TableRegistry::get('Data.Addresses');
	}

	/**
	 * @return void
	 */
	public function tearDown() {
		parent::tearDown();

		TableRegistry::clear();
	}

	/**
	 * @return void
	 */
	public function testBasicFind() {
		$result = $this->Addresses->find()->first();
		$this->assertNotEmpty($result);
	}

	/**
	 * @return void
	 */
	public function testTouch() {
		$address = $this->Addresses->find()->first();
		$this->assertNotEmpty($address);

		$this->Addresses->touch($address->id);
		$address = $this->Addresses->get($address->id);
		$this->assertTrue($address->last_used > new Time('-2 seconds'));
	}

}
