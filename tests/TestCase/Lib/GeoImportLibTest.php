<?php

namespace Data\Test\TestCase\Lib;

use Tools\TestSuite\TestCase;
use Data\Lib\GeoImportLib;

/**
 * GeoImportLib test
 */
class GeoImportLibTest extends TestCase {

	public $fixtures = array('plugin.data.countries');

	public function setUp() {
		parent::setUp();

		$this->Geo = new GeoImportLib();
	}

	public function testImportCountiesCH() {
		$res = $this->Geo->importCounties('CH');
		//debug($res);
	}

	public function testImportCH() {
		$res = $this->Geo->importCounties('CH');
		//debug($res);
	}

}
