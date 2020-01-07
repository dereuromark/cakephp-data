<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\TestCase;

class ContinentsTableTest extends TestCase {

	/**
	 * @var array
	 */
	public $fixtures = [
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

		$this->Continents = TableRegistry::get('Data.Continents');
	}

	/**
	 * @return void
	 */
	public function tearDown(): void {
		parent::tearDown();

		TableRegistry::clear();
	}

	/**
	 * @return void
	 */
	public function testBasicFind() {
		$result = $this->Continents->find()->first();
		$this->assertNotEmpty($result);
	}

}
