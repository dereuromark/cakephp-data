<?php
declare(strict_types = 1);

namespace Data\Test\TestCase\Controller\Admin;

use Cake\Event\EventInterface;
use Cake\Event\EventManager;
use Cake\Http\MiddlewareQueue;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Data\Controller\Admin\MimeTypesController;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

#[UsesClass(MimeTypesController::class)]
class MimeTypesControllerTest extends TestCase {

	use IntegrationTestTrait;

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

		$this->loadPlugins(['Data', 'Tools']);
	}

	/**
	 * @return void
	 */
	public function testIndex(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'MimeTypes', 'action' => 'index']);
		$this->assertResponseCode(200);
	}

	/**
	 * @return void
	 */
	public function testView(): void {
		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'MimeTypes', 'action' => 'view', 1]);
		$this->assertResponseCode(200);
	}

	/**
	 * @return void
	 */
	public function testAdd(): void {
		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'MimeTypes', 'action' => 'add']);
		$this->assertResponseCode(200);
	}

	/**
	 * @return void
	 */
	public function testEdit(): void {
		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'MimeTypes', 'action' => 'edit', 1]);
		$this->assertResponseCode(200);
	}

	/**
	 * @return void
	 */
	public function testDelete(): void {
		$this->post(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'MimeTypes', 'action' => 'delete', 1]);
		$this->assertResponseCode(302);
	}

	/**
	 * CakePHP's CspMiddleware stores the nonce as `cspScriptNonce`.
	 *
	 * @param string $action
	 * @param array<mixed> $pass
	 *
	 * @return void
	 */
	#[DataProvider('cspActionProvider')]
	public function testCspScriptNonce(string $action, array $pass): void {
		$this->withRequestAttribute('cspScriptNonce', 'core-nonce');

		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'MimeTypes', 'action' => $action, ...$pass]);

		$this->assertResponseCode(200);
		$this->assertAllScriptsHaveNonce('core-nonce');
	}

	/**
	 * @return array<string, array<mixed>>
	 */
	public static function cspActionProvider(): array {
		return [
			'add' => ['add', []],
			'edit' => ['edit', [1]],
			'view (csp_confirm element)' => ['view', [1]],
		];
	}

	/**
	 * A custom middleware may still provide the nonce as `cspNonce`.
	 *
	 * @return void
	 */
	public function testCspNonceFallback(): void {
		$this->withRequestAttribute('cspNonce', 'custom-nonce');

		$this->get(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'MimeTypes', 'action' => 'add']);

		$this->assertResponseCode(200);
		$this->assertResponseContains('<script type="text/javascript" nonce="custom-nonce">');
	}

	/**
	 * Asserts the page has scripts and every one carries exactly the given nonce.
	 *
	 * @param string $nonce
	 *
	 * @return void
	 */
	protected function assertAllScriptsHaveNonce(string $nonce): void {
		$body = (string)$this->_response->getBody();
		$scripts = preg_match_all('/<script\b/', $body);
		$this->assertGreaterThan(0, $scripts);
		$this->assertSame($scripts, preg_match_all('/<script\b[^>]*\snonce="' . preg_quote($nonce, '/') . '"/', $body));
	}

	/**
	 * Adds a middleware that sets a request attribute, like a CSP middleware would.
	 *
	 * @param string $name
	 * @param string $value
	 *
	 * @return void
	 */
	protected function withRequestAttribute(string $name, string $value): void {
		EventManager::instance()->on('Server.buildMiddleware', function (EventInterface $event, MiddlewareQueue $queue) use ($name, $value): void {
			$queue->prepend(function (ServerRequestInterface $request, RequestHandlerInterface $handler) use ($name, $value): ResponseInterface {
				return $handler->handle($request->withAttribute($name, $value));
			});
		});
	}

}
