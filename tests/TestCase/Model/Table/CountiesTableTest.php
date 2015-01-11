<?php

namespace Data\Test\TestCase\Model\Table;

use Data\Model\County;
use Tools\TestSuite\TestCase;

class CountiesTableTest extends TestCase {

	public $fixtures = array(
		'plugin.data.counties'
	);

	public $County;

	public function setUp() {
		parent::setUp();

		$this->County = ClassRegistry::init('Data.County');
	}

	public function testObject() {
		$this->assertTrue(is_object($this->County));
		$this->assertInstanceOf('County', $this->County);
	}

	//TODO
}
