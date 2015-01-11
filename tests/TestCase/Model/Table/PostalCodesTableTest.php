<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\TestCase;

class PostalCodesTableTest extends TestCase {

	public $fixtures = array(
		'plugin.data.postal_codes'
	);

	public $PostalCodes;

	public function setUp() {
		parent::setUp();

		$this->PostalCodes = TableRegistry::get('Data.PostalCodes');

		$entity = $this->PostalCodes->newEntity(['code' => '81222']);
		$this->assertEmpty($entity->errors());
		$result = $this->PostalCodes->save($entity);
		$this->assertNotEmpty($result);
	}

	/**
	 *
	 * @return void
	 */
	public function testBasicFind() {
		$result = $this->PostalCodes->find()->first();
		$this->assertNotEmpty($result);
	}

}
