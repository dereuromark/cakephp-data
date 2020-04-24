<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::prefix('Admin', function (RouteBuilder $routes) {
		$routes->plugin('Data', function (RouteBuilder $routes) {
			$routes->connect('/', ['action' => 'index'], ['routeClass' => DashedRoute::class]);

			$routes->fallbacks(DashedRoute::class);
		});
});

Router::plugin('Data', function (RouteBuilder $routes) {
	$routes->connect('/', ['action' => 'index'], ['routeClass' => DashedRoute::class]);

	$routes->fallbacks(DashedRoute::class);
});
