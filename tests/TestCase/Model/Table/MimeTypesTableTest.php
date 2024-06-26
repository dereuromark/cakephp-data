<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Shim\TestSuite\TestCase;

class MimeTypesTableTest extends TestCase {

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.Data.MimeTypes',
	];

	/**
	 * @var \Data\Model\Table\MimeTypesTable
	 */
	protected $MimeTypes;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->MimeTypes = TableRegistry::getTableLocator()->get('Data.MimeTypes');
	}

	/**
	 * @return void
	 */
	public function testBasicFind() {
		$result = $this->MimeTypes->find()->first();
		$this->assertNotEmpty($result);
	}

}
