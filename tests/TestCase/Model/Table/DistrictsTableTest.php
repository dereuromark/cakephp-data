<?php

namespace Data\Test\TestCase\Model\Table;

use Data\Model\District;
use Tools\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

class DistrictsTableTest extends TestCase {

	public $fixtures = array(
		'plugin.data.districts'
	);

	public $District;

	public function setUp() {
		parent::setUp();

		$this->District = TableRegistry::get('Data.Districts');
	}

	public function testObject() {
		$this->assertTrue(is_object($this->District));
		$this->assertInstanceOf('District', $this->District);
	}

}
