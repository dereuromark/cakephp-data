<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\TestCase;

class ContinentsTableTest extends TestCase {

	public $fixtures = array(
		'plugin.data.continents'
	);

	public $Continents;

	public function setUp() {
		parent::setUp();

		$this->Continents = TableRegistry::get('Data.Continents');
	}

	/**
	 * ContinentsTableTest::testBasicFind()
	 *
	 * @return void
	 */
	public function testBasicFind() {
		$result = $this->Continents->find()->first();
		$this->assertNotEmpty($result);
	}

}
