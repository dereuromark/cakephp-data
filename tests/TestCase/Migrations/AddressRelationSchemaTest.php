<?php

namespace Data\Test\TestCase\Migrations;

use Cake\Database\Driver\Sqlite;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\Locator\TableLocator;
use Cake\TestSuite\TestCase;
use Data\Model\Entity\Address;
use Migrations\Migrations;
use PHPUnit\Framework\Attributes\DataProvider;

class AddressRelationSchemaTest extends TestCase {

	/**
	 * @return array<string, array{bool}>
	 */
	public static function schemas(): array {
		return ['fresh migration' => [false], 'legacy model column' => [true]];
	}

	/**
	 * @param bool $legacy
	 * @return void
	 */
	#[DataProvider('schemas')]
	public function testOwnerRelationsAndValidation(bool $legacy): void {
		ConnectionManager::setConfig('data_address_relation_test', [
			'className' => 'Cake\\Database\\Connection',
			'driver' => Sqlite::class,
			'database' => ':memory:',
		]);
		try {
			$this->assertTrue((new Migrations(['connection' => 'data_address_relation_test', 'plugin' => 'Data']))->migrate());
			$connection = ConnectionManager::get('data_address_relation_test');
			$connection->execute('CREATE TABLE users (id INTEGER PRIMARY KEY, username VARCHAR(100))');
			$connection->insert('users', ['id' => 1, 'username' => 'example']);
			$modelField = $legacy ? 'model' : 'model_key';
			if ($legacy) {
				$connection->execute('ALTER TABLE addresses RENAME COLUMN model_key TO model');
				$connection->execute('ALTER TABLE addresses ADD COLUMN type_id INTEGER');
			}
			$data = [
				'country_id' => 1,
				'postal_code' => '',
				'city' => 'Test city',
				'street' => 'Test street',
				'formatted_address' => 'Test address',
				$modelField => 'User',
				'foreign_id' => 1,
				'created' => '2026-01-01 00:00:00',
				'modified' => '2026-01-01 00:00:00',
			];
			$connection->insert('addresses', $data);
			$locator = new TableLocator();
			$locator->setConfig('Users', ['connection' => $connection]);
			$addresses = $locator->get('Data.Addresses', ['connection' => $connection]);
			$addresses->removeBehavior('Geocoder');
			$row = $addresses->find()->contain(['Users'])->firstOrFail();
			$this->assertSame('example', $row->user->username);
			$errors = $addresses->getValidator()->validate($data);
			$this->assertArrayHasKey('validateUnique', $errors['formatted_address']);
			$company = $data;
			$company[$modelField] = 'Company';
			$this->assertArrayNotHasKey('formatted_address', $addresses->getValidator()->validate($company));

			// Address types are an optional application schema extension.
			$connection->execute('ALTER TABLE addresses ADD COLUMN address_type_id INTEGER');
			$connection->update('addresses', ['address_type_id' => Address::TYPE_MAIN], ['id' => 1]);
			$company['address_type_id'] = Address::TYPE_MAIN;
			$this->assertTrue($addresses->primaryUnique(Address::TYPE_MAIN, ['data' => $company]));
			$data['address_type_id'] = Address::TYPE_MAIN;
			$this->assertFalse($addresses->primaryUnique(Address::TYPE_MAIN, ['data' => $data]));
			$connection->insert('addresses', $company);
			$this->assertSame(2, $addresses->find()->count());
			$this->assertNull($addresses->find()->where([$addresses->aliasField($modelField) => 'Company'])->contain(['Users'])->firstOrFail()->user);
		} finally {
			ConnectionManager::drop('data_address_relation_test');
		}
	}

}
