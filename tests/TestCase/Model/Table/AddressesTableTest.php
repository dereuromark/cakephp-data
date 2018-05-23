<?php

namespace Data\Test\TestCase\Model\Table;

use App\Model\Behavior\GeocoderBehavior;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Tools\TestSuite\TestCase;

class AddressesTableTest extends TestCase {

	/**
	 * @var array
	 */
	public $fixtures = [
		'plugin.data.addresses',
		'plugin.data.countries',
		'plugin.data.states',
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

	/**
	 * @return void
	 */
	public function testBasicSave() {
		$this->Addresses->removeBehavior('Geocoder');
		$this->Addresses->addBehavior('Geocoder', ['className' => GeocoderBehavior::class]);

		$data = [
			'foreign_id' => 1,
			'model' => 'Foo',
			'city' => 'Berlin',
		];
		$address = $this->Addresses->newEntity($data);
		$result = $this->Addresses->save($address);
		$this->assertTrue((bool)$result);
	}

}
