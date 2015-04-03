<?php
namespace Data\Config;

use Cake\Routing\Router;


Router::prefix('admin', function ($routes) {
		$routes->plugin('Data', function ($routes) {
			$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
			$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);
		});
});

Router::plugin('Data', function ($routes) {
		$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
		$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);
});
