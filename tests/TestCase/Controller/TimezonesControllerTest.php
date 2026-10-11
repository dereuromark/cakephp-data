<?php
declare(strict_types = 1);

namespace Data\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Data\Controller\TimezonesController;
use PHPUnit\Framework\Attributes\UsesClass;

#[UsesClass(TimezonesController::class)]
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
	public function setUp(): void {
		parent::setUp();

		$this->loadPlugins(['Data', 'Tools']);
	}

	/**
	 * @return void
	 */
	public function testIndex(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Data', 'controller' => 'Timezones', 'action' => 'index']);
		$this->assertResponseCode(200);
	}

}
