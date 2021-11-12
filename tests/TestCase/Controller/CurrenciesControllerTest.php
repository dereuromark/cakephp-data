<?php
declare(strict_types = 1);

namespace Data\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * @uses \Data\Controller\CurrenciesController
 */
class CurrenciesControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * @var array<string>
	 */
	protected $fixtures = [
		'plugin.Data.Currencies',
	];

	/**
	 * @return void
	 */
	public function testIndex(): void {
		$this->get(['plugin' => 'Data', 'controller' => 'Currencies', 'action' => 'index']);
		$this->assertResponseCode(200);
	}

}
