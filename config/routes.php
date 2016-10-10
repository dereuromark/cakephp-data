<?php
namespace Data\Config;

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\Router;

Router::prefix('admin', function ($routes) {
		$routes->plugin('Data', function ($routes) {
			$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => DashedRoute::class]);
			$routes->connect('/:controller/:action/*', [], ['routeClass' => DashedRoute::class]);
		});
});

Router::plugin('Data', function ($routes) {
		$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => DashedRoute::class]);
		$routes->connect('/:controller/:action/*', [], ['routeClass' => DashedRoute::class]);
});
