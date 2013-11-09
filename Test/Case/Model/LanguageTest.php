<?php

App::uses('Language', 'Data.Model');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

class LanguageTest extends MyCakeTestCase {

	public $Language;

	public function setUp() {
		parent::setUp();

		$this->Language = new Language();
	}

	public function testObject() {
		$this->assertTrue(is_object($this->Language));
		$this->assertInstanceOf('Language', $this->Language);
	}

	//TODO
}
