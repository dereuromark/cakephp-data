<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Data\Model\Table\CountriesTable;
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

	public function testActiveFinderSupportsOrmDispatchAndDirectCalls(): void {
		$expected = $this->Countries->findActive()->all()->extract('iso2')->toList();
		$this->assertNotEmpty($expected);
		$this->assertSame($expected, $this->Countries->find('active')->all()->extract('iso2')->toList());
		$this->assertSame(['DE'], $this->Countries->findActive(['conditions' => ['iso2' => 'DE']])
			->all()->extract('iso2')->toList());
		$this->assertSame(['DE'], $this->Countries->findActive(options: ['conditions' => ['iso2' => 'DE']])
			->all()->extract('iso2')->toList());
	}

	public function testLegacyFinderOverrideSupportsDirectAndOrmCalls(): void {
		$table = new class (['table' => 'countries', 'alias' => 'Countries']) extends CountriesTable {
			/**
			 * @param array $options
			 * @return \Cake\ORM\Query\SelectQuery
			 */
			public function findActive(array $options = []) {
				return parent::findActive($options)->where(['iso2' => 'DE']);
			}
		};
		$this->assertSame(['DE'], $table->findActive()->all()->extract('iso2')->toList());
		$this->assertSame(['DE'], $table->find()->find('active')->all()->extract('iso2')->toList());
		$this->assertSame(['DE'], $table->find('active')->all()->extract('iso2')->toList());
		$this->assertSame([], $table->find()->where(['iso2 !=' => 'DE'])->find('active')->all()->toList());
		$this->assertSame(['DE'], $table->findActive()->all()->extract('iso2')->toList());
		$query = $table->find('active', ['conditions' => ['iso2' => 'DE']], limit: 1);
		$this->assertSame(1, $query->clause('limit'));
		$this->assertSame(['DE'], $query->all()->extract('iso2')->toList());
		$table->updateAll(['status' => 0], ['iso2' => 'DE']);
		$this->assertSame([], $table->find('active')->all()->toList());
		$this->assertSame([], $table->find()->find('active')->all()->toList());

	}

}
