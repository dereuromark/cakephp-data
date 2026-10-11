<?php

namespace Data\Test\TestCase\Migrations;

use Cake\Core\Configure;
use Cake\Database\Driver\Sqlite;
use Cake\Datasource\ConnectionManager;
use Cake\TestSuite\TestCase;
use Migrations\Migrations;
use PHPUnit\Framework\Attributes\DataProvider;

class AddressForeignKeyMigrationTest extends TestCase {

	/**
	 * @return array<string, array{string|null, string, int|string}>
	 */
	public static function foreignKeyTypes(): array {
		return [
			'released default' => [null, 'string', 'acct-A12'],
			'explicit string' => ['string', 'string', 'account-identifier-over-ten'],
			'integer' => ['integer', 'integer', 42],
			'big integer' => ['biginteger', 'biginteger', 2147483648],
			'uuid' => ['uuid', 'uuid', 'b2651790-1ad0-4a33-8da4-3b1ca53d4f36'],
			'binary uuid' => ['binaryuuid', 'binaryuuid', '0123456789abcdef'],
		];
	}

	/**
	 * @param string|null $configuredType
	 * @param string $schemaType
	 * @param string|int $foreignId
	 * @return void
	 */
	#[DataProvider('foreignKeyTypes')]
	public function testFreshAddressSchemaPreservesForeignKeys(?string $configuredType, string $schemaType, string|int $foreignId): void {
		$previous = Configure::read('Polymorphic');
		$hadPrevious = Configure::check('Polymorphic');
		Configure::delete('Polymorphic');
		if ($configuredType !== null) {
			Configure::write('Polymorphic.type', $configuredType);
		}
		ConnectionManager::setConfig('data_address_migration_test', [
			'className' => 'Cake\\Database\\Connection',
			'driver' => Sqlite::class,
			'database' => ':memory:',
		]);

		try {
			$migrations = new Migrations(['connection' => 'data_address_migration_test', 'plugin' => 'Data']);
			$this->assertTrue($migrations->migrate());
			$connection = ConnectionManager::get('data_address_migration_test');
			$column = $connection->getSchemaCollection()->describe('addresses')->getColumn('foreign_id');
			$this->assertSame($schemaType, $column['type']);
			$this->assertTrue($column['null']);
			$connection->insert('addresses', [
				'country_id' => 1,
				'postal_code' => '12345',
				'city' => 'Test city',
				'street' => 'Test street',
				'formatted_address' => 'Test address',
				'model_key' => 'Accounts',
				'foreign_id' => $foreignId,
				'created' => '2026-01-01 00:00:00',
				'modified' => '2026-01-01 00:00:00',
			]);
			$row = $connection->execute('SELECT foreign_id FROM addresses')->fetch('assoc');
			$this->assertSame((string)$foreignId, (string)$row['foreign_id']);
		} finally {
			ConnectionManager::drop('data_address_migration_test');
			Configure::delete('Polymorphic');
			if ($hadPrevious) {
				Configure::write('Polymorphic', $previous);
			}
		}
	}

}
