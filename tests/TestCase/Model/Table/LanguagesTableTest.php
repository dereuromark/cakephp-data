<?php

namespace Data\Test\TestCase\Model;

use Cake\ORM\TableRegistry;
use Shim\TestSuite\TestCase;

class LanguagesTableTest extends TestCase {

	/**
	 * @var array
	 */
	public $fixtures = [
		'plugin.Data.Languages',
	];

	/**
	 * @var \Data\Model\Table\LanguagesTable
	 */
	protected $Languages;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->Languages = TableRegistry::get('Data.Languages');
	}

	/**
	 * @return void
	 */
	public function testObject() {
		$this->assertTrue(is_object($this->Languages));
		$this->assertInstanceOf('\Data\Model\Table\LanguagesTable', $this->Languages);
	}

	/**
	 * @return void
	 */
	public function testGetList() {
		$result = $this->Languages->getList();
		$this->assertStringContainsString('Deutsch', $result);
		$this->assertStringContainsString('Englisch', $result);
		$this->assertStringNotContainsString('Deutsch (Deutschland)', $result);
	}

	/**
	 * @return void
	 */
	public function testCodeList() {
		$result = $this->Languages->codeList();
		$this->assertStringContainsString('Deutsch', $result);
		$this->assertStringContainsString('Englisch', $result);
		$this->assertStringNotContainsString('Deutsch (Deutschland)', $result);
	}

}
