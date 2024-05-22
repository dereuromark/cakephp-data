<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Shim\TestSuite\TestCase;

class ContinentsTableTest extends TestCase {

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.Data.Continents',
	];

	/**
	 * @var \Data\Model\Table\ContinentsTable
	 */
	protected $Continents;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->Continents = TableRegistry::getTableLocator()->get('Data.Continents');
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
		$result = $this->Continents->find()->first();
		$this->assertNotEmpty($result);
	}

	/**
	 * @return void
	 */
	public function testBasicSave() {
		$data = [
			'name' => 'Foo',
			'code' => 'XY',
		];

		$result = $this->Continents->newEntity($data);
		$this->Continents->saveOrFail($result);
		$this->assertSame('XY', $result->code);
	}

}
