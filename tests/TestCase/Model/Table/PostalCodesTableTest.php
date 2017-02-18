<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\TestCase;

class PostalCodesTableTest extends TestCase {

	/**
	 * @var array
	 */
	public $fixtures = [
		'plugin.data.postal_codes'
	];

	/**
	 * @var \Data\Model\Table\PostalCodesTable
	 */
	public $PostalCodes;

	/**
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->PostalCodes = TableRegistry::get('Data.PostalCodes');
	}

	/**
	 * @return void
	 */
	public function testBasicFind() {
		$result = $this->PostalCodes->find()->first();
		$this->assertNotEmpty($result);
	}

	/**
	 * @return void
	 */
	public function testBasicSave() {
		$entity = $this->PostalCodes->newEntity(['code' => '81222']);
		$this->assertEmpty($entity->errors());
		$result = $this->PostalCodes->save($entity);
		$this->assertNotEmpty($result);
	}

	/**
	 * @return void
	 */
	public function testSearchLocation() {
		$result = $this->PostalCodes->searchLocation('81234')->first();
		$this->assertNotEmpty($result);
	}

	/**
	 * @return void
	 */
	public function testStats() {
		$result = $this->PostalCodes->stats();
		$this->assertSame([1 => 1], $result);
	}

}
