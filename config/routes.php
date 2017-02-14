<?php

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::prefix('admin', function (RouteBuilder $routes) {
		$routes->plugin('Data', function (RouteBuilder $routes) {
			$routes->connect('/', ['action' => 'index'], ['routeClass' => DashedRoute::class]);
			$routes->fallbacks(DashedRoute::class);
		});
});

Router::plugin('Data', ['path' => '/data'], function (RouteBuilder $routes) {
	$routes->connect('/', ['action' => 'index'], ['routeClass' => DashedRoute::class]);
	$routes->fallbacks(DashedRoute::class);
});
