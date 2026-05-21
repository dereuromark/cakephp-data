<?php

namespace Data\Test\TestCase\Controller;

use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use ReflectionProperty;

/**
 * @uses \Data\Controller\CountriesController
 */
class CountriesControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.Data.Countries',
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

		$this->get(['plugin' => 'Data', 'controller' => 'Countries', 'action' => 'index']);
		$this->assertResponseCode(200);
	}

	/**
	 * The camelCase `Country.imagePath` key must be honored by the controller.
	 *
	 * @return void
	 */
	public function testImagePathHonorsCamelCaseKey() {
		$imagePath = 'Data./img/country_flags/';
		Configure::write('Country.imagePath', $imagePath);

		$this->disableErrorHandlerMiddleware();
		$this->get(['plugin' => 'Data', 'controller' => 'Countries', 'action' => 'index']);
		$this->assertResponseCode(200);

		$property = new ReflectionProperty($this->_controller, 'imageFolder');
		$this->assertSame(WWW_ROOT . 'img' . DS . $imagePath . DS, $property->getValue($this->_controller));
	}

	/**
	 * The snake_case `Country.image_path` key remains supported as a BC fallback.
	 *
	 * @return void
	 */
	public function testImagePathBcFallback() {
		Configure::write('Country.image_path', 'legacy_flags');

		$this->disableErrorHandlerMiddleware();
		$this->get(['plugin' => 'Data', 'controller' => 'Countries', 'action' => 'index']);
		$this->assertResponseCode(200);

		$property = new ReflectionProperty($this->_controller, 'imageFolder');
		$this->assertSame(WWW_ROOT . 'img' . DS . 'legacy_flags' . DS, $property->getValue($this->_controller));
	}

}
