<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Data\Model\Table\MimeTypeImagesTable;
use Tools\TestSuite\TestCase;

class MimeTypeImagesTableTest extends TestCase {

	/**
	 * @var array
	 */
	public $fixtures = [
		'plugin.data.mime_type_images'
	];

	/**
	 * @var MimeTypeImagesTable
	 */
	public $MimeTypeImages;

	public function setUp() {
		parent::setUp();

		$this->MimeTypeImages = TableRegistry::get('Data.MimeTypeImages');
	}

	/**
	 * @return void
	 */
	public function testBasicFind() {
		$result = $this->MimeTypeImages->find()->first();
		$this->assertNotEmpty($result);
	}

}
