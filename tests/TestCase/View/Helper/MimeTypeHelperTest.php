<?php

namespace Data\Test\TestCase\View\Helper;

use Cake\View\View;
use Data\View\Helper\MimeTypeHelper;
use Tools\TestSuite\TestCase;

class MimeTypeHelperTest extends TestCase {

	public $MimeTypeHelper;

	public $fixtures = array('plugin.Data.MimeTypes', 'plugin.Data.MimeTypeImages');

	public function setUp() {
		parent::setUp();

		$this->MimeTypeHelper = new MimeTypeHelper(new View(null));
	}

	public function testGetTypes() {
		$result = $this->MimeTypeHelper->getTypes();
		debug($result);
		//$this->assertInstanceOf('MimeTypeHelper', $this->MimeTypeHelper);
	}

	//TODO
}
