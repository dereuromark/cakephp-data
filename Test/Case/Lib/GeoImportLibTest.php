<?php

App::uses('GeoImportLib', 'Data.Lib');

/**
 * GeoImportLib test
 */
class GeoImportLibTest extends CakeTestCase {

	public function setUp() {
		parent::setUp();

		$this->Geo = new GeoImportLib();
	}

	public function testImportCountiesCH() {
		$res = $this->Geo->importCounties('CH');
		debug($res);
	}

	public function testImportCH() {
		$res = $this->Geo->importCounties('CH');
		debug($res);
	}

}
