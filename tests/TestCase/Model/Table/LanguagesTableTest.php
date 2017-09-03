<?php

namespace Data\Test\TestCase\Model;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\TestCase;

class LanguagesTableTest extends TestCase {

	/**
	 * @var array
	 */
	public $fixtures = [
		'plugin.data.languages'
	];

	/**
	 * @var \Data\Model\Table\LanguagesTable
	 */
	public $Languages;

	/**
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->Languages = TableRegistry::get('Data.Languages');
	}

	public function testObject() {
		$this->assertTrue(is_object($this->Languages));
		$this->assertInstanceOf('\Data\Model\Table\LanguagesTable', $this->Languages);
	}

	public function testGetList() {
		$result = $this->Languages->getList();
		$this->assertContains('Deutsch', $result);
		$this->assertContains('Englisch', $result);
		$this->assertNotContains('Deutsch (Deutschland)', $result);
	}

	public function testCodeList() {
		$result = $this->Languages->codeList();
		$this->assertContains('Deutsch', $result);
		$this->assertContains('Englisch', $result);
		$this->assertNotContains('Deutsch (Deutschland)', $result);
	}
	//TODO

}
