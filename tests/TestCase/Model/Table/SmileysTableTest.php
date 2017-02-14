<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\TestCase;

class SmileysTableTest extends TestCase {

	/**
	 * @var array
	 */
	public $fixtures = [
		'plugin.data.smileys'
	];

	public function setUp() {
		parent::setUp();

		$this->Smileys = TableRegistry::get('Data.Smileys');
	}

	/**
	 * @return void
	 */
	public function testBasicFind() {
		$result = $this->Smileys->find()->first();
		$this->assertNotEmpty($result);
	}

	/**
	 * SmileysTableTest::testExport()
	 *
	 * @return void
	 */
	public function testExport() {
		$is = $this->Smileys->export();
		//pr($is);
		$this->assertTrue(!empty($is));
	}

}
