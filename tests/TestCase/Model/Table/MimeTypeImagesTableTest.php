<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Shim\TestSuite\TestCase;

class MimeTypeImagesTableTest extends TestCase {

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.Data.MimeTypeImages',
	];

	/**
	 * @var \Data\Model\Table\MimeTypeImagesTable
	 */
	protected $MimeTypeImages;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->MimeTypeImages = TableRegistry::getTableLocator()->get('Data.MimeTypeImages');
	}

	/**
	 * @return void
	 */
	public function testBasicFind() {
		$result = $this->MimeTypeImages->find()->first();
		$this->assertNotEmpty($result);
	}

}
