<?php

use Cake\Routing\Router;

Router::reload();

require(dirname(dirname(dirname(__DIR__))) . '/config/routes.php');
