<?php
declare(strict_types = 1);

use Migrations\AbstractMigration;

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
// phpcs:disable PSR2R.Classes.ClassFileName.NoMatch
class MigrationAddresses extends AbstractMigration {

	/**
	 * Change Method.
	 *
	 * More information on this method is available here:
	 * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
	 *
	 * @return void
	 */
	public function change() {
		$this->table('addresses')
			->addColumn('id', 'integer', [
				'autoIncrement' => true,
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->addPrimaryKey(['id'])
			->addColumn('country_id', 'integer', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->addColumn('state_id', 'integer', [
				'default' => null,
				'limit' => null,
				'null' => true,
			])
			->addColumn('postal_code', 'string', [
				'default' => null,
				'limit' => 10,
				'null' => false,
			])
			->addColumn('city', 'string', [
				'default' => null,
				'limit' => 80,
				'null' => false,
			])
			->addColumn('street', 'string', [
				'default' => null,
				'limit' => 80,
				'null' => false,
			])
			->addColumn('foreign_id', 'string', [
				'default' => null,
				'limit' => 10,
				'null' => true,
			])
			->addColumn('model_key', 'string', [
				'default' => '',
				'limit' => 60,
				'null' => true,
			])
			->addColumn('postal_code', 'string', [
				'default' => null,
				'limit' => 7,
				'null' => false,
			])
			->addColumn('formatted_address', 'string', [
				'default' => null,
				'limit' => 190,
				'null' => false,
			])
			->addColumn('lat', 'float', [
				'default' => null,
				'null' => true,
			])
			->addColumn('lng', 'float', [
				'default' => null,
				'null' => true,
			])
			->addColumn('created', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->addColumn('modified', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->create();
	}

}
