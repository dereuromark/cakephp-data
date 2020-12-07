<?php
declare(strict_types = 1);

use Migrations\AbstractMigration;

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
// phpcs:disable PSR2R.Classes.ClassFileName.NoMatch
class MigrationCities extends AbstractMigration {

	/**
	 * Change Method.
	 *
	 * More information on this method is available here:
	 * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
	 *
	 * @return void
	 */
	public function change() {
		$this->table('cities')
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
			->addColumn('official_key', 'string', [
				'default' => null,
				'limit' => 10,
				'null' => false,
			])
			->addColumn('county_id', 'string', [
				'default' => null,
				'limit' => 8,
				'null' => false,
			])
			->addColumn('name', 'string', [
				'default' => '',
				'limit' => 190,
				'null' => false,
			])
			->addColumn('citizens', 'integer', [
				'default' => null,
				'limit' => null,
				'null' => true,
			])
			->addColumn('postal_code', 'string', [
				'default' => '',
				'limit' => 7,
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
			->addColumn('slug', 'string', [
				'default' => '',
				'limit' => 190,
				'null' => false,
			])
			->addColumn('description', 'text', [
				'default' => null,
				'limit' => null,
				'null' => true,
			])
			->addColumn('postal_code_unique', 'boolean', [
				'default' => false,
				'limit' => null,
				'null' => false,
			])
			->addColumn('modified', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->addIndex(
				[
					'slug',
				],
				['unique' => true]
			)
			->addIndex(
				[
					'official_key',
				]
			)
			->addIndex(
				[
					'name',
				]
			)
			->addIndex(
				[
					'postal_code',
				]
			)
			->create();
	}

}
