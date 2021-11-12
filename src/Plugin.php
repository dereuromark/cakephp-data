<?php

namespace Data;

use Cake\Core\BasePlugin;
use Cake\Routing\RouteBuilder;

class Plugin extends BasePlugin {

	/**
	 * @var bool
	 */
	protected $middlewareEnabled = false;

	/**
	 * @var bool
	 */
	protected $consoleEnabled = false;

	/**
	 * @param \Cake\Routing\RouteBuilder $routes The route builder to update.
	 * @return void
	 */
	public function routes(RouteBuilder $routes): void {
		$routes->prefix('Admin', function (RouteBuilder $routes) {
			$routes->plugin('Data', function (RouteBuilder $routes) {
				$routes->connect('/', ['action' => 'index']);

				$routes->fallbacks();
			});
		});

		$routes->plugin('Data', function (RouteBuilder $routes) {
			$routes->connect('/', ['action' => 'index']);

			$routes->fallbacks();
		});
	}

}
