<?php
/**
 * @var \Cake\Routing\RouteBuilder $routes
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

$routes->prefix('Admin', function (RouteBuilder $routes) {
		$routes->plugin('Data', function (RouteBuilder $routes) {
			$routes->connect('/', ['action' => 'index'], ['routeClass' => DashedRoute::class]);

			$routes->fallbacks(DashedRoute::class);
		});
});

$routes->plugin('Data', function (RouteBuilder $routes) {
	$routes->connect('/', ['action' => 'index'], ['routeClass' => DashedRoute::class]);

	$routes->fallbacks(DashedRoute::class);
});
