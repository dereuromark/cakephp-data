<?php
declare(strict_types = 1);

use Migrations\AbstractMigration;

class MigrationStates extends AbstractMigration {

	/**
	 * Change Method.
	 *
	 * More information on this method is available here:
	 * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
	 *
	 * @return void
	 */
	public function change() {
		$this->table('states')
			->addColumn('id', 'integer', [
				'autoIncrement' => true,
				'default' => null,
				'limit' => null,
				'null' => false,
				'signed' => false,
			])
			->addPrimaryKey(['id'])
			->addColumn('country_id', 'integer', [
				'default' => null,
				'limit' => null,
				'null' => false,
				'signed' => false,
			])
			->addColumn('code', 'string', [
				'default' => null,
				'limit' => 3,
				'null' => false,
			])
			->addColumn('name', 'string', [
				'default' => null,
				'limit' => 60,
				'null' => false,
			])
			->addColumn('lat', 'float', [
				'default' => null,
				'null' => true,
				'precision' => 10,
				'scale' => 6,
			])
			->addColumn('lng', 'float', [
				'default' => null,
				'null' => true,
				'precision' => 10,
				'scale' => 6,
			])
			->addColumn('modified', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => true,
			])
			->create();
	}

}
