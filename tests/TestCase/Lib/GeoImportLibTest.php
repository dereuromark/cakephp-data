<?php

namespace Data\Test\TestCase\Lib;

use Cake\Cache\Cache;
use Cake\Core\Plugin;
use Data\Lib\GeoImportLib;
use Tools\TestSuite\TestCase;

/**
 * GeoImportLib test
 */
class GeoImportLibTest extends TestCase {

	/**
	 * @var array
	 */
	public $fixtures = ['plugin.data.countries'];

	/**
	 * @var \Data\Lib\GeoImportLib|\PHPUnit_Framework_MockObject_MockObject
	 */
	public $GeoImport;

	/**
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		if ($this->isDebug()) {
			$this->GeoImport = new GeoImportLib();
			return;
		}

		$this->GeoImport = $this->getMockBuilder(GeoImportLib::class)->setMethods(['_getFromUrl'])->getMock();
		$this->path = Plugin::path('Data') . 'tests' . DS . 'test_files' . DS . 'html' . DS;
		// Liste-der-St-C3-A4dte-in-der-Schweiz-action-edit-section-4.html

		Cache::clear();
	}

	/**
	 * @return void
	 */
	public function testImportCountiesCH() {
		if (!$this->isDebug()) {
			$this->GeoImport->expects($this->once())
				->method('_getFromUrl')
				->with('http://de.wikipedia.org/w/index.php?title=Kanton_(Schweiz)&action=edit&section=4')
				->will($this->returnValue(file_get_contents($this->path . 'Kanton-Schweiz-action-edit-section-4.html')));
		}

		$res = $this->GeoImport->importCounties('CH');
		//debug($res);
	}

	/**
	 * @return void
	 */
	public function testImportCH() {
		if (!$this->isDebug()) {
			$this->GeoImport->expects($this->at(0))
				->method('_getFromUrl')
				->with('http://de.wikipedia.org/w/index.php?title=Liste_der_St%C3%A4dte_in_der_Schweiz&action=edit&section=3')
				->will($this->returnValue(file_get_contents($this->path . 'Liste-der-St-C3-A4dte-in-der-Schweiz-action-edit-section-3.html')));
			$this->GeoImport->expects($this->at(1))
				->method('_getFromUrl')
				->with('http://de.wikipedia.org/w/index.php?title=Liste_der_St%C3%A4dte_in_der_Schweiz&action=edit&section=4')
				->will($this->returnValue(file_get_contents($this->path . 'Liste-der-St-C3-A4dte-in-der-Schweiz-action-edit-section-4.html')));
		}

		$res = $this->GeoImport->import('CH');
		//debug($res);
	}

}
