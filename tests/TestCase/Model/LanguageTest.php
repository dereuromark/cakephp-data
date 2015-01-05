<?php

namespace Data\Test\TestCase\Model;

use Data\Model\Language;
use Tools\TestSuite\TestCase;
class LanguageTest extends TestCase {

	public $fixtures = array(
		'plugin.data.languages'
	);

	public $Language;

	public function setUp() {
		parent::setUp();

		$this->Language = ClassRegistry::init('Data.Language');
	}

	public function testObject() {
		$this->assertTrue(is_object($this->Language));
		$this->assertInstanceOf('Language', $this->Language);
	}

	//TODO
}
