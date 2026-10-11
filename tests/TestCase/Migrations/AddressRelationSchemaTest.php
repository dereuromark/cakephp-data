<?php

namespace Data\Test\TestCase\Migrations;

use Cake\Database\Driver\Sqlite;
use Cake\Datasource\ConnectionManager;
use Cake\Http\ServerRequest;
use Cake\ORM\Locator\TableLocator;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\View\View;
use Data\Model\Entity\Address;
use Migrations\Migrations;
use PHPUnit\Framework\Attributes\DataProvider;

class AddressRelationSchemaTest extends TestCase {

	use IntegrationTestTrait;

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
			$addresses->setSchema($connection->getSchemaCollection()->describe('addresses'));
			$companyRow = $addresses->get(2);
			$addresses->patchEntity($companyRow, ['address_type_id' => Address::TYPE_MAIN, 'user_id' => 999]);
			$this->assertSame([], $companyRow->getErrors());
			$duplicate = $data;
			$duplicate['formatted_address'] = 'Second address';
			$connection->insert('addresses', $duplicate);
			$userRow = $addresses->get(1);
			$addresses->patchEntity($userRow, ['formatted_address' => 'Second address']);
			$this->assertArrayHasKey('validateUnique', $userRow->getError('formatted_address'));
			$ownerChange = $addresses->get(2);
			$addresses->patchEntity($ownerChange, [$modelField => 'User', 'foreign_id' => 1]);
			$this->assertNotEmpty($ownerChange->getError($modelField));
			$this->assertFalse($addresses->save($ownerChange));
			$this->assertSame('Company', $addresses->get(2)->get($modelField));
			$nullable = $data;
			$nullable['foreign_id'] = 3;
			$nullable[$modelField] = null;
			$nullable['formatted_address'] = 'Nullable owner address';
			$connection->insert('addresses', $nullable);
			$nullableRow = $addresses->find()->where(['foreign_id' => 3])->firstOrFail();
			$addresses->patchEntity($nullableRow, ['address_type_id' => Address::TYPE_MAIN]);
			$this->assertSame([], $nullableRow->getErrors());
			$this->assertNotFalse($addresses->save($nullableRow));
			$withoutOwner = $nullable;
			unset($withoutOwner[$modelField]);
			$withoutOwner['formatted_address'] = 'Another nullable owner address';
			$newAddress = $addresses->newEntity($withoutOwner);
			$this->assertSame([], $newAddress->getErrors());
			$this->assertNotFalse($addresses->save($newAddress));
			$this->assertSame('', $addresses->get($newAddress->id)->get($modelField));
			$secondDefault = $withoutOwner;
			$secondDefault['formatted_address'] = 'Different default-owner address';
			$this->assertFalse($addresses->save($addresses->newEntity($secondDefault)));
			$duplicateDefault = $withoutOwner;
			$duplicateDefault['address_type_id'] = 99;
			$this->assertFalse($addresses->save($addresses->newEntity($duplicateDefault)));
			foreach (['', null] as $emptyOwner) {
				$occupied = $data;
				$occupied[$modelField] = $emptyOwner;
				$occupied['formatted_address'] = 'Occupied empty owner ' . ($emptyOwner === null ? 'null' : 'blank');
				$connection->insert('addresses', $occupied);
				$ownerChange = $addresses->get(2);
				$addresses->patchEntity($ownerChange, [$modelField => $emptyOwner]);
				$this->assertSame([], $ownerChange->getErrors());
				$this->assertFalse($addresses->save($ownerChange));
				$this->assertSame('Company', $addresses->get(2)->get($modelField));
			}
			$nonconflicting = $company;
			$nonconflicting['foreign_id'] = 7;
			$connection->insert('addresses', $nonconflicting);
			$ownerChange = $addresses->find()->where(['foreign_id' => 7])->firstOrFail();
			$addresses->patchEntity($ownerChange, [$modelField => '']);
			$this->assertNotFalse($addresses->save($ownerChange));
			$this->assertSame('', $addresses->get($ownerChange->id)->get($modelField));

			$this->loadPlugins(['Data', 'Tools']);
			TableRegistry::getTableLocator()->set('Data.Addresses', $addresses);
			$this->disableErrorHandlerMiddleware();
			$submitted = $data;
			unset($submitted['address_type_id']);
			$submitted['formatted_address'] = 'Admin address';
			$this->post(['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'Addresses', 'action' => 'add'], $submitted);
			$this->assertRedirect();
			$this->assertSame('User', $addresses->find()->where(['formatted_address' => 'Admin address'])->firstOrFail()->get($modelField));
			$view = new View();
			$view->setRequest(new ServerRequest(['params' => ['prefix' => 'Admin', 'plugin' => 'Data', 'controller' => 'Addresses', 'action' => 'add']]));
			$view->setPlugin('Data');
			$view->setTemplatePath('Admin/Addresses');
			$view->set(['address' => $addresses->newEmptyEntity(), 'countries' => [], 'states' => [], 'modelField' => $addresses->getModelField()]);
			$form = $view->render('add', false);
			$this->assertStringContainsString('name="' . $modelField . '"', $form);
		} finally {
			TableRegistry::getTableLocator()->clear();
			ConnectionManager::drop('data_address_relation_test');
		}
	}

}
