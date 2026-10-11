<?php

namespace Data\Test\TestCase\Migrations;

use Cake\Console\CommandRunner;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOutput;
use Cake\Core\Configure;
use Cake\Database\Driver\Sqlite;
use Cake\Datasource\ConnectionManager;
use Cake\TestSuite\TestCase;
use Migrations\Migrations;
use TestApp\Application;

class InstallationTest extends TestCase {

	public function testFreshMigrationsAndOfflineTimezoneSeed(): void {
		ConnectionManager::setConfig('data_installation_test', [
			'className' => 'Cake\\Database\\Connection',
			'driver' => Sqlite::class,
			'database' => ':memory:',
		]);
		$previous = Configure::read('Data.Timezone.source');
		Configure::write('Data.Timezone.source', 'php');

		try {
			$migrations = new Migrations(['connection' => 'data_installation_test', 'plugin' => 'Data']);
			$this->assertTrue($migrations->migrate());
			$connection = ConnectionManager::get('data_installation_test');
			$this->assertCount(12, $connection->getSchemaCollection()->listTables());
			$continents = $connection->execute('SELECT COUNT(*) AS total FROM continents')->fetch('assoc');
			$this->assertSame(9, (int)$continents['total']);

			$app = new Application(CONFIG);
			$app->addPlugin('Data');
			$app->addPlugin('Migrations');
			$runner = new CommandRunner($app, 'cake');
			$io = new ConsoleIo(new ConsoleOutput(TMP . 'data-seed-output.txt'), new ConsoleOutput(TMP . 'data-seed-error.txt'));
			$arguments = ['cake', 'seeds', 'run', 'TimezonesSeed', '-p', 'Data', '-c', 'data_installation_test'];
			$this->assertSame(0, $runner->run($arguments, $io));
			$timezones = $connection->execute('SELECT COUNT(*) AS total FROM timezones')->fetch('assoc');
			$this->assertGreaterThan(400, (int)$timezones['total']);
			$this->assertSame(0, $runner->run($arguments, $io));
			$repeated = $connection->execute('SELECT COUNT(*) AS total FROM timezones')->fetch('assoc');
			$this->assertSame($timezones['total'], $repeated['total']);
			$utc = $connection->execute("SELECT offset, offset_dst FROM timezones WHERE name = 'UTC'")->fetch('assoc');
			$this->assertSame(0, (int)$utc['offset']);
			$this->assertSame(0, (int)$utc['offset_dst']);
		} finally {
			ConnectionManager::drop('data_installation_test');
			Configure::write('Data.Timezone.source', $previous);
		}
	}

}
