<?php

if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}
if (!defined('WINDOWS')) {
	if (DS === '\\' || substr(PHP_OS, 0, 3) === 'WIN') {
		define('WINDOWS', true);
	} else {
		define('WINDOWS', false);
	}
}
// Path constants to a few helpful things.
define('ROOT', dirname(__DIR__) . DS);
define('CAKE_CORE_INCLUDE_PATH', ROOT . 'vendor' . DS . 'cakephp' . DS . 'cakephp');
define('CORE_PATH', ROOT . 'vendor' . DS . 'cakephp' . DS . 'cakephp' . DS);
define('CAKE', CORE_PATH . 'src' . DS);
define('TESTS', ROOT . 'tests');
define('APP', ROOT . 'tests' . DS . 'test_app' . DS);
define('APP_DIR', 'test_app');
define('WEBROOT_DIR', 'webroot');
define('TMP', ROOT . 'tmp' . DS);
define('CONFIG', APP . 'config' . DS);
define('WWW_ROOT', APP);
define('CACHE', TMP);
define('LOGS', TMP);

require ROOT . '/vendor/autoload.php';
require CORE_PATH . 'config/bootstrap.php';

Cake\Core\Configure::write('App', [
	'namespace' => 'App',
	'paths' => [
		'templates' => [ROOT . DS . 'tests' . DS . 'test_app' . DS . 'src' . DS . 'Template' . DS],
	],
]);

Cake\Core\Configure::write('debug', true);

$cache = [
	'default' => [
		'engine' => 'File',
		'path' => CACHE
	],
	'_cake_core_' => [
		'className' => 'File',
		'prefix' => 'crud_myapp_cake_core_',
		'path' => CACHE . 'persistent/',
		'serialize' => true,
		'duration' => '+10 seconds'
	],
	'_cake_model_' => [
		'className' => 'File',
		'prefix' => 'crud_my_app_cake_model_',
		'path' => CACHE . 'models/',
		'serialize' => 'File',
		'duration' => '+10 seconds'
	]
];

Cake\Cache\Cache::setConfig($cache);

Cake\Core\Plugin::load('Data', ['path' => ROOT . DS, 'autoload' => true, 'routes' => true]);
Cake\Core\Plugin::load('Tools', ['path' => ROOT . DS . 'vendor/dereuromark/cakephp-tools/', 'autoload' => true, 'bootstrap' => true]);

// Ensure default test connection is defined
if (!getenv('db_class')) {
	putenv('db_class=Cake\Database\Driver\Sqlite');
}
if (!getenv('db_dsn')) {
	putenv('db_dsn=sqlite::memory:');
}

if (strpos(getenv('db_class'), 'MySql') !== false) {
	Cake\Datasource\ConnectionManager::setConfig('test', [
		'className' => 'Cake\Database\Connection',
		'driver' => 'Cake\Database\Driver\Mysql',
		'database' => 'cake_test',
		'username' => 'root',
		'password' => 'secret',
		'timezone' => 'UTC',
		'quoteIdentifiers' => true,
		'cacheMetadata' => true,
	]);
	return;
}

Cake\Datasource\ConnectionManager::setConfig('test', [
	'className' => 'Cake\Database\Connection',
	'driver' => getenv('db_class'),
	'dsn' => getenv('db_dsn'),
	'database' => getenv('db_database'),
	'username' => getenv('db_username'),
	'password' => getenv('db_password'),
	'timezone' => 'UTC',
	'quoteIdentifiers' => true,
	'cacheMetadata' => true,
]);
