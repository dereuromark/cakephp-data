<?php

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Data\Plugin as DataPlugin;
use TestApp\Application;
use TestApp\Controller\AppController;
use TestApp\View\AppView;
use Tools\ToolsPlugin;
use Tools\View\Icon\BootstrapIcon;

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
define('ROOT', dirname(__DIR__));
define('CAKE_CORE_INCLUDE_PATH', ROOT . DS . 'vendor' . DS . 'cakephp' . DS . 'cakephp');
define('CORE_PATH', ROOT . DS . 'vendor' . DS . 'cakephp' . DS . 'cakephp' . DS);
define('CAKE', CORE_PATH . 'src' . DS);
define('TESTS', ROOT . DS . 'tests' . DS);
define('APP', TESTS . 'test_app' . DS);
define('APP_DIR', 'test_app');
define('WEBROOT_DIR', 'webroot');
define('TMP', ROOT . DS . 'tmp' . DS);
define('CONFIG', TESTS . 'config' . DS);
define('WWW_ROOT', APP);
define('CACHE', TMP);
define('LOGS', TMP);

require ROOT . '/vendor/autoload.php';
require CORE_PATH . 'config/bootstrap.php';
require CAKE . 'functions.php';

require ROOT . '/config/bootstrap.php';

Configure::write('App', [
	'namespace' => 'App',
	'encoding' => 'utf-8',
	'paths' => [
		'templates' => [ROOT . DS . 'tests' . DS . 'test_app' . DS . 'templates' . DS],
	],
]);

Configure::write('debug', true);

$cache = [
	'default' => [
		'engine' => 'File',
		'path' => CACHE,
	],
	'_cake_core_' => [
		'className' => 'File',
		'prefix' => 'crud_myapp_cake_core_',
		'path' => CACHE . 'persistent/',
		'serialize' => true,
		'duration' => '+10 seconds',
	],
	'_cake_model_' => [
		'className' => 'File',
		'prefix' => 'crud_my_app_cake_model_',
		'path' => CACHE . 'models/',
		'serialize' => 'File',
		'duration' => '+10 seconds',
	],
];

Cache::setConfig($cache);

class_alias(AppController::class, 'App\Controller\AppController');
class_alias(AppView::class, 'App\View\AppView');
class_alias(Application::class, 'App\Application');

Plugin::getCollection()->add(new DataPlugin());
Plugin::getCollection()->add(new ToolsPlugin());

// Ensure default test connection is defined
if (!getenv('DB_URL')) {
	putenv('DB_URL=sqlite:///:memory:');
}

ConnectionManager::setConfig('test', [
	'url' => getenv('DB_URL') ?: null,
	'timezone' => 'UTC',
	'quoteIdentifiers' => true,
	'cacheMetadata' => true,
	'flags' => [
		PDO::MYSQL_ATTR_INIT_COMMAND => "SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''))",
	],
]);

Configure::write('Icon', [
	'sets' => [
		'bs' => BootstrapIcon::class,
	],
]);

if (env('FIXTURE_SCHEMA_METADATA')) {
	$loader = new Cake\TestSuite\Fixture\SchemaLoader();
	$loader->loadInternalFile(env('FIXTURE_SCHEMA_METADATA'));
}
