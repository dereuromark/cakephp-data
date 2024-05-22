<?php

namespace Data\Test\TestCase\View\Helper;

use Cake\View\View;
use Data\View\Helper\MimeTypeHelper;
use Shim\TestSuite\TestCase;

class MimeTypeHelperTest extends TestCase {

	/**
	 * @var \Data\View\Helper\MimeTypeHelper
	 */
	protected $MimeTypeHelper;

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.Data.MimeTypes',
		'plugin.Data.MimeTypeImages',
	];

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->MimeTypeHelper = new MimeTypeHelper(new View(null));
	}

	/**
	 * @return void
	 */
	public function testGetTypes() {
		$result = $this->MimeTypeHelper->getTypes();
		$this->assertFalse($result);
		//$this->assertInstanceOf('MimeTypeHelper', $this->MimeTypeHelper);
	}

}
