<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Shim\TestSuite\TestCase;
use TestApp\Model\Behavior\TestGeocoderBehavior;

class AddressesTableTest extends TestCase {

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.Data.Addresses',
		'plugin.Data.Countries',
		'plugin.Data.States',
	];

	/**
	 * @var \Data\Model\Table\AddressesTable
	 */
	protected $Addresses;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->Addresses = TableRegistry::getTableLocator()->get('Data.Addresses');
	}

	/**
	 * @return void
	 */
	public function tearDown(): void {
		parent::tearDown();

		//TableRegistry::clear();
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
		$this->assertTrue($address->last_used > Time::parseTime('-2 seconds'));
	}

	/**
	 * @return void
	 */
	public function testBasicSave() {
		$this->Addresses->removeBehavior('Geocoder');
		$this->Addresses->addBehavior('Geocoder', ['className' => TestGeocoderBehavior::class]);

		$data = [
			'foreign_id' => 'eb25610d-7bfa-4e34-812c-ad72b100fb26',
			'model' => 'Foo',
			'city' => 'Berlin',
		];
		$address = $this->Addresses->newEntity($data);
		$result = $this->Addresses->save($address);
		$this->assertTrue((bool)$result);
	}

	/**
	 * @return void
	 */
	public function testSaveWithState() {
		$this->Addresses->removeBehavior('Geocoder');

		$data = [
			'foreign_id' => 'eb25610d-7bfa-4e34-812c-ad72b100fb26',
			'model' => 'Foo',
			'city' => 'Berlin',
			'country_id' => 1,
			'state_id' => 1,
		];
		$address = $this->Addresses->newEntity($data);
		$result = $this->Addresses->save($address);
		$this->assertTrue((bool)$result);
	}

	/**
	 * @return void
	 */
	public function testSaveWithPostalCode() {
		$this->Addresses->removeBehavior('Geocoder');

		$data = [
			'foreign_id' => 'eb25610d-7bfa-4e34-812c-ad72b100fb26',
			'model' => 'Foo',
			'city' => 'Berlin',
			'country_id' => 1,
			'postal_code' => 12345,
		];
		$address = $this->Addresses->newEntity($data);
		$result = $this->Addresses->save($address);
		$this->assertTrue((bool)$result);
	}

}
