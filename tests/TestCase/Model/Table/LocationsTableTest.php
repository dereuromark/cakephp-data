<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Shim\TestSuite\TestCase;

class LocationsTableTest extends TestCase {

	/**
	 * @var array
	 */
	protected array $fixtures = [
		'plugin.Data.Locations',
	];

	/**
	 * @var \Data\Model\Table\LocationsTable
	 */
	protected $Locations;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->Locations = TableRegistry::getTableLocator()->get('Data.Locations');
	}

	/**
	 * @return void
	 */
	public function testBasicFind() {
		$result = $this->Locations->find()->first();
		$this->assertNotEmpty($result);
	}

	/**
	 * @return void
	 */
	public function testBasicSave() {
		$data = [
			'country_id' => 1,
			'state_id' => 1,
			'city' => 'Berlin',
		];
		$location = $this->Locations->newEntity($data);
		$result = $this->Locations->save($location);
		$this->assertNotEmpty($result);
	}

}
