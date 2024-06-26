<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Shim\TestSuite\TestCase;

class CountriesTableTest extends TestCase {

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.Data.Countries',
		'plugin.Data.States',
	];

	/**
	 * @var \Data\Model\Table\CountriesTable
	 */
	protected $Countries;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->Countries = TableRegistry::getTableLocator()->get('Data.Countries');
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
		$result = $this->Countries->find()->contain(['States'])->first();
		$this->assertNotEmpty($result);
		$this->assertNotEmpty($result->states);
	}

	/**
	 * @return void
	 */
	public function testBasicSave() {
		$country = $this->Countries->newEntity([
			'name' => 'Foo Bar',
			'ori_name' => 'Foo Bar',
			'iso2' => 'FB',
			'iso3' => 'fbr',
		]);
		$result = $this->Countries->saveOrFail($country);
		$this->assertSame('FBR', $result->iso3);
	}

}
