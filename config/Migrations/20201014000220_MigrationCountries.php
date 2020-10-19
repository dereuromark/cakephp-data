<?php
declare(strict_types = 1);

use Migrations\AbstractMigration;

class MigrationCountries extends AbstractMigration {

	/**
	 * Change Method.
	 *
	 * More information on this method is available here:
	 * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
	 *
	 * @return void
	 */
	public function change() {
		$this->table('countries')
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
			->addColumn('iso2', 'string', [
				'default' => null,
				'limit' => 2,
				'null' => false,
			])
			->addColumn('iso3', 'string', [
				'default' => null,
				'limit' => 3,
				'null' => false,
			])
			->addColumn('country_code', 'integer', [
				'default' => null,
				'limit' => null,
				'null' => true,
				'signed' => false,
			])
			->addColumn('eu_member', 'boolean', [
				'comment' => 'Member of the EU',
				'default' => false,
				'limit' => null,
				'null' => false,
			])
			->addColumn('zip_length', 'tinyinteger', [
				'comment' => 'if > 0 validate on this length',
				'default' => '0',
				'limit' => null,
				'null' => false,
				'signed' => false,
			])
			->addColumn('zip_regexp', 'string', [
				'default' => null,
				'limit' => 190,
				'null' => true,
			])
			->addColumn('sort', 'integer', [
				'default' => '0',
				'limit' => null,
				'null' => false,
				'signed' => false,
			])
			->addColumn('lat', 'float', [
				'comment' => 'latitude',
				'default' => null,
				'null' => true,
				'precision' => 10,
				'scale' => 6,
			])
			->addColumn('lng', 'float', [
				'comment' => 'longitude',
				'default' => null,
				'null' => true,
				'precision' => 10,
				'scale' => 6,
			])
			->addColumn('address_format', 'string', [
				'default' => null,
				'limit' => 190,
				'null' => true,
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
				'null' => true,
			])
			->addIndex(
				[
					'iso2',
				],
				['unique' => true]
			)
			->addIndex(
				[
					'iso3',
				],
				['unique' => true]
			)
			->create();
	}

}
