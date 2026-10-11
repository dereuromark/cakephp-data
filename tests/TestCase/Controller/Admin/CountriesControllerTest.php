<?php

namespace Data\Test\TestCase\Controller\Admin;

use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Data\Controller\Admin\CountriesController;
use PHPUnit\Framework\Attributes\UsesClass;

#[UsesClass(CountriesController::class)]
class CountriesControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.Data.Countries',
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
	public function testIndex() {
		$this->disableErrorHandlerMiddleware();

		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'Countries', 'action' => 'index']);
		$this->assertResponseCode(200);
	}

	/**
	 * @return void
	 */
	public function testSync(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'Countries', 'action' => 'sync']);
		$this->assertResponseCode(200);
	}

	/**
	 * @return void
	 */
	public function testView() {
		$this->disableErrorHandlerMiddleware();

		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'Countries', 'action' => 'view', 1]);
		$this->assertResponseCode(200);
	}

	/**
	 * The camelCase `Country.imagePath` key must be honored and take precedence
	 * over the snake_case `Country.image_path` BC fallback.
	 *
	 * @return void
	 */
	public function testImagePathHonorsCamelCaseKey() {
		$imagePath = 'Data./img/country_flags/';
		Configure::write('Country.imagePath', $imagePath);
		Configure::write('Country.image_path', 'legacy_flags');

		$this->disableErrorHandlerMiddleware();
		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'Countries', 'action' => 'index']);
		$this->assertResponseCode(200);

		$this->assertSame(WWW_ROOT . 'img' . DS . $imagePath . DS, $this->controller->imageFolder);
	}

	/**
	 * The snake_case `Country.image_path` key remains supported as a BC fallback.
	 *
	 * @return void
	 */
	public function testImagePathBcFallback() {
		Configure::write('Country.image_path', 'legacy_flags');

		$this->disableErrorHandlerMiddleware();
		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'Countries', 'action' => 'index']);
		$this->assertResponseCode(200);

		$this->assertSame(WWW_ROOT . 'img' . DS . 'legacy_flags' . DS, $this->controller->imageFolder);
	}

}
