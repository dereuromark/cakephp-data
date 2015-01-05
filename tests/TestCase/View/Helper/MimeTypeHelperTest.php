<?php

namespace Data\Test\TestCase\View\Helper;

use Cake\View\View;
use Data\View\Helper\MimeTypeHelper;
use Tools\TestSuite\TestCase;

class MimeTypeHelperTest extends TestCase {

	public $MimeTypeHelper;

	public function setUp() {
		parent::setUp();

		$this->MimeTypeHelper = new MimeTypeHelper(new View(null));
	}

	public function testObject() {
		$this->assertTrue(is_object($this->MimeTypeHelper));
		$this->assertInstanceOf('MimeTypeHelper', $this->MimeTypeHelper);
	}

	//TODO
}