<?php

namespace Data\Test\TestCase\Model;

use Cake\ORM\TableRegistry;
use Data\Model\Table\LanguagesTable;
use Shim\TestSuite\TestCase;

class LanguagesTableTest extends TestCase {

	/**
	 * @var array
	 */
	protected $fixtures = [
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
		$this->assertInstanceOf(LanguagesTable::class, $this->Languages);
	}

	/**
	 * @return void
	 */
	public function testGetList() {
		$result = $this->Languages->getList();
		$this->assertTrue(in_array('Deutsch', $result, true));
		$this->assertTrue(in_array('Englisch', $result, true));

		$this->assertFalse(in_array('Deutsch (Deutschland)', $result, true));
	}

	/**
	 * @return void
	 */
	public function testCodeList() {
		$result = $this->Languages->codeList();
		$this->assertTrue(in_array('Deutsch', $result, true));
		$this->assertTrue(in_array('Englisch', $result, true));

		$this->assertFalse(in_array('Deutsch (Deutschland)', $result, true));
	}

	/**
	 * @return void
	 */
	public function testBasicSave() {
		$data = [
			'name' => 'Foo',
			'ori_name' => 'Foo',
			'code' => 'Fxy',
			'iso2' => 'Fx',
			'iso3' => 'Fxy',
			'locale' => 'fe_fe',
			'locale_fallback' => 'FES',
		];

		$result = $this->Languages->newEntity($data);
		$this->Languages->saveOrFail($result);
		$this->assertSame('fxy', $result->code);
		$this->assertSame('fx', $result->iso2);
		$this->assertSame('fxy', $result->iso3);
		$this->assertSame('fe_FE', $result->locale);
		$this->assertSame('fes', $result->locale_fallback);
	}

}
