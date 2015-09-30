<?php

namespace Data\Test\TestCase\Model\Table;

use Tools\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

class CountiesTableTest extends TestCase {

	public $fixtures = [
		'plugin.data.counties', 'plugin.data.states',
	];

	public $Counties;

	public function setUp() {
		parent::setUp();

		$this->Counties = TableRegistry::get('Data.Counties');
	}

	/**
	 * CountiesTableTest::testBasicFind()
	 *
	 * @return void
	 */
	public function testBasicFind() {
		$result = $this->Counties->find()->first();
		$this->assertNotEmpty($result);
	}

	/**
	 * CountiesTableTest::testBasicSave()
	 *
	 * @return void
	 */
	public function testBasicSave() {
		$data = [
			'name' => 'Foo Bar'
		];
		$entity = $this->Counties->newEntity($data);
		$this->assertEmpty($entity->errors());

		$result = $this->Counties->save($entity);
		//debug($result);ob_flush();
		$this->assertNotEmpty($result);
		$this->assertSame('foo-bar', $result['slug']);
	}

}
