<?php

namespace Data\Test\TestCase\Model\Table;

use Data\Model\State;
use Tools\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

class StatesTableTest extends TestCase {

	public $fixtures = [
		'plugin.data.states'
	];

	public $States;

	public function setUp() {
		parent::setUp();

		$this->States = TableRegistry::get('Data.States');
	}

	/**
	 * StatesTableTest::testBasicFind()
	 *
	 * @return void
	 */
	public function testBasicFind() {
		$result = $this->States->find()->first();
		$this->assertNotEmpty($result);
	}

}
