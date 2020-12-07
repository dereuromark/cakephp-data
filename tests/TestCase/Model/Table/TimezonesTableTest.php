<?php
declare(strict_types = 1);

namespace Data\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Data\Model\Table\TimezonesTable;

class TimezonesTableTest extends TestCase {

	/**
	 * Test subject
	 *
	 * @var \Data\Model\Table\TimezonesTable
	 */
	protected $Timezones;

	/**
	 * @var string[]
	 */
	protected $fixtures = [
		'plugin.Data.Timezones',
	];

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();
		$config = $this->getTableLocator()->exists('Timezones') ? [] : ['className' => TimezonesTable::class];
		$this->Timezones = $this->getTableLocator()->get('Timezones', $config);
	}

	/**
	 * @return void
	 */
	public function tearDown(): void {
		unset($this->Timezones);

		parent::tearDown();
	}

	/**
	 * @return void
	 */
	public function testValidationDefault(): void {
		$this->markTestIncomplete('Not implemented yet.');
	}

}
