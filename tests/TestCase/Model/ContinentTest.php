<?php

namespace Data\Test\TestCase\Model;

use Data\Model\Continent;
use Tools\TestSuite\MyCakeTestCase;

class ContinentTest extends MyCakeTestCase {

	public $fixtures = array(
		'plugin.data.continents'
	);

	public $Continent;

	public function setUp() {
		parent::setUp();

		$this->Continent = ClassRegistry::init('Data.Continent');
	}

	public function testObject() {
		$this->assertTrue(is_object($this->Continent));
		$this->assertInstanceOf('Continent', $this->Continent);
	}

	//TODO
}
