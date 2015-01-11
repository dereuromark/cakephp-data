<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\TestCase;

class MimeTypeImagesTableTest extends TestCase {

	public $fixtures = array(
		'plugin.data.mime_type_images'
	);

	public $MimeTypeImages;

	public function setUp() {
		parent::setUp();

		$this->MimeTypeImages = TableRegistry::get('Data.MimeTypeImages');
	}

	/**
	 *
	 * @return void
	 */
	public function testBasicFind() {
		$result = $this->MimeTypeImages->find()->first();
		$this->assertNotEmpty($result);
	}

}
