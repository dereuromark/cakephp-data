<?php

namespace Data\Test\TestCase\Model\Table;

use Tools\TestSuite\TestCase;
use Data\Model\Smiley;

class SmileysTableTest extends TestCase {

	public $fixtures = array(
		'plugin.data.smileys'
	);

	public function setUp() {
		parent::setUp();

		$this->Smiley = TableRegistry::get('Data.Smiley');
	}

	/**
	 * Seems to keep the last one on duplicates
	 */
	public function testArrayUnique() {
		$is = array(
			'x' => 't',
			'x' => 'e',
			'y' => 'z',
			'z' => 'r',
			't' => 'w'
		);
		$is = array_unique($is);
		pr($is);
		$this->assertEquals($is['x'], 'e');

		$is = array(
			'e' => 't',
			'x' => 'e',
			'y' => 'z',
			'z' => 't',
			't' => 'w'
		);
		$is = array_unique($is);
		pr($is);
		$this->assertEquals($is['e'], 't');
	}

	public function testExport() {

		$is = $this->Smiley->export();
		pr($is);
		$this->assertTrue(!empty($is));
	}

}
