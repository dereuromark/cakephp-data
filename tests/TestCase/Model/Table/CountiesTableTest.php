<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\TestCase;

class CountiesTableTest extends TestCase {

	/**
	 * @var array
	 */
	public $fixtures = [
		'plugin.Data.Counties',
		'plugin.Data.States',
	];

	/**
	 * @var \Data\Model\Table\CountriesTable
	 */
	protected $Counties;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->Counties = TableRegistry::get('Data.Counties');
	}

	/**
	 * @return void
	 */
	public function tearDown(): void {
		parent::tearDown();

		TableRegistry::clear();
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
			'official_id' => 'foobar',
			'rank' => 5,
			'name' => 'Foo Bar',
		];
		$entity = $this->Counties->newEntity($data);
		$this->assertEmpty($entity->errors());

		$result = $this->Counties->save($entity);
		//debug($result);ob_flush();
		$this->assertNotEmpty($result);
		$this->assertSame('foo-bar', $result['slug']);
	}

}
