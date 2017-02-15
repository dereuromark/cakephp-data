<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\TestCase;

class StatesTableTest extends TestCase {

	/**
	 * @var array
	 */
	public $fixtures = [
		'plugin.data.states'
	];

	/**
	 * @var \Data\Model\Table\StatesTable
	 */
	public $States;

	public function setUp() {
		parent::setUp();

		$this->States = TableRegistry::get('Data.States');
	}

	/**
	 * @return void
	 */
	public function testBasicFind() {
		$result = $this->States->find()->first();
		$this->assertNotEmpty($result);
	}

}
