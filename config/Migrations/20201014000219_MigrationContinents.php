<?php
declare(strict_types = 1);

use Migrations\AbstractMigration;

class MigrationContinents extends AbstractMigration {

	/**
	 * Change Method.
	 *
	 * More information on this method is available here:
	 * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
	 *
	 * @return void
	 */
	public function change() {
		$this->table('continents')
			->addColumn('id', 'integer', [
				'autoIncrement' => true,
				'default' => null,
				'limit' => null,
				'null' => false,
				'signed' => false,
			])
			->addPrimaryKey(['id'])
			->addColumn('name', 'string', [
				'default' => null,
				'limit' => 64,
				'null' => false,
			])
			->addColumn('ori_name', 'string', [
				'default' => null,
				'limit' => 64,
				'null' => false,
			])
			->addColumn('parent_id', 'integer', [
				'default' => null,
				'limit' => 10,
				'null' => true,
				'signed' => false,
			])
			->addColumn('lft', 'integer', [
				'default' => null,
				'limit' => 10,
				'null' => true,
				'signed' => false,
			])
			->addColumn('rght', 'integer', [
				'default' => null,
				'limit' => 10,
				'null' => true,
				'signed' => false,
			])
			->addColumn('status', 'tinyinteger', [
				'default' => '0',
				'limit' => null,
				'null' => false,
				'signed' => false,
			])
			->addColumn('modified', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->create();
	}

}
