<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Shim\TestSuite\TestCase;

class StatesTableTest extends TestCase {

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.Data.States',
	];

	/**
	 * @var \Data\Model\Table\StatesTable
	 */
	protected $States;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->States = TableRegistry::getTableLocator()->get('Data.States');
	}

	/**
	 * @return void
	 */
	public function testBasicFind() {
		$result = $this->States->find()->first();
		$this->assertNotEmpty($result);
	}

	/**
	 * @return void
	 */
	public function testGetStateId() {
		$state = $this->States->find()->first();

		$id = $this->States->getStateId(['code' => $state->code]);
		$this->assertSame($state->id, $id);
	}

	/**
	 * @return void
	 */
	public function testBasicSave() {
		$data = [
			'name' => 'Foo',
			'code' => 'fxy',
			'country_id' => 1,
		];

		$result = $this->States->newEntity($data);
		$this->States->saveOrFail($result);
		$this->assertSame('FXY', $result->code);
	}

}
