<?php
/**
 * @var \Cake\Routing\RouteBuilder $routes
 */

use Cake\Routing\RouteBuilder;

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
