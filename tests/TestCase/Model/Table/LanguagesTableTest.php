<?php

namespace Data\Test\TestCase\Model;

use Cake\ORM\TableRegistry;
use Data\Model\Language;
use Tools\TestSuite\TestCase;

class LanguagesTableTest extends TestCase {

	public $fixtures = [
		'plugin.data.languages'
	];

	public $Languages;

	public function setUp() {
		parent::setUp();

		$this->Languages = TableRegistry::get('Data.Languages');
	}

	public function testObject() {
		$this->assertTrue(is_object($this->Languages));
		$this->assertInstanceOf('\Data\Model\Table\LanguagesTable', $this->Languages);
	}

	//TODO
}
