<?php
declare(strict_types = 1);

namespace Data\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * @uses \Data\Controller\TimezonesController
 */
class TimezonesControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.Data.Timezones',
	];

	/**
	 * @return void
	 */
	public function testIndex(): void {
		$this->get(['plugin' => 'Data', 'controller' => 'Timezones', 'action' => 'index']);
		$this->assertResponseCode(200);
	}

}
