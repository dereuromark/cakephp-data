<?php

namespace Data\Test\TestCase\Model\Table;

use Tools\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

class SmileysTableTest extends TestCase {

	public $fixtures = array(
		'plugin.data.smileys'
	);

	public function setUp() {
		parent::setUp();

		$this->Smileys = TableRegistry::get('Data.Smileys');
	}

	/**
	 *
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
