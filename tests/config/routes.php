<?php
namespace Data\Test\App\Config;

use Cake\Core\Plugin;
use Cake\Routing\Router;

Router::scope('/', function($routes) {
	$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'InflectedRoute']);
	$routes->connect('/:controller/:action/*', [], ['routeClass' => 'InflectedRoute']);
});

Router::plugin('Data', function ($routes) {
	$routes->prefix('admin', function ($routes) {
		$routes->connect('/:controller/:action/*', ['routeClass' => 'InflectedRoute']);
	});

	$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'InflectedRoute']);
	$routes->connect('/:controller/:action/*', [], ['routeClass' => 'InflectedRoute']);
});

//Plugin::routes();