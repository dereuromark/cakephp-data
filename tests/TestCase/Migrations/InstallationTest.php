<?php

namespace Data\Test\TestCase\Migrations;

use Cake\Database\Driver\Sqlite;
use Cake\Datasource\ConnectionManager;
use Cake\TestSuite\TestCase;
use Migrations\Migrations;

class InstallationTest extends TestCase {

	public function testFreshMigrationsAndOfflineTimezoneSeed(): void {
		ConnectionManager::setConfig('data_installation_test', [
			'className' => 'Cake\\Database\\Connection',
			'driver' => Sqlite::class,
			'database' => ':memory:',
		]);
		$cachePath = TMP . 'wiki-timezones.txt';
		$previous = is_file($cachePath) ? file_get_contents($cachePath) : null;
		file_put_contents($cachePath, json_encode(['parse' => ['unexpected' => 'shape']]));

		try {
			$migrations = new Migrations(['connection' => 'data_installation_test', 'plugin' => 'Data']);
			$this->assertTrue($migrations->migrate());
			$connection = ConnectionManager::get('data_installation_test');
			$this->assertCount(12, $connection->getSchemaCollection()->listTables());
			$continents = $connection->execute('SELECT COUNT(*) AS total FROM continents')->fetch('assoc');
			$this->assertSame(9, (int)$continents['total']);

			$this->assertTrue($migrations->seed(['seed' => 'TimezonesSeed']));
			$timezones = $connection->execute('SELECT COUNT(*) AS total FROM timezones')->fetch('assoc');
			$this->assertGreaterThan(400, (int)$timezones['total']);
			$utc = $connection->execute("SELECT offset, offset_dst FROM timezones WHERE name = 'UTC'")->fetch('assoc');
			$this->assertSame(0, (int)$utc['offset']);
			$this->assertSame(0, (int)$utc['offset_dst']);
		} finally {
			ConnectionManager::drop('data_installation_test');
			if ($previous === null) {
				unlink($cachePath);
			} else {
				file_put_contents($cachePath, $previous);
			}
		}
	}

}
