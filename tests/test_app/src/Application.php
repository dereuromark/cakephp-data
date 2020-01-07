<?php

namespace TestApp;

use Cake\Http\BaseApplication;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Middleware\RoutingMiddleware;

/**
 * Application setup class.
 *
 * This defines the bootstrapping logic and middleware layers you
 * want to use in your application.
 */
class Application extends BaseApplication {

	/**
	 * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to setup.
	 *
	 * @return \Cake\Http\MiddlewareQueue The updated middleware.
	 */
	public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue {
		$middlewareQueue
			->add(RoutingMiddleware::class);

		return $middlewareQueue;
	}

}
