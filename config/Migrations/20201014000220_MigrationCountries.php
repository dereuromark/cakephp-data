<?php
declare(strict_types = 1);

use Migrations\AbstractMigration;

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
// phpcs:disable PSR2R.Classes.ClassFileName.NoMatch
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
			->addColumn('continent_id', 'integer', [
				'default' => null,
				'limit' => 10,
				'null' => true,
				'signed' => false,
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
			->addColumn('phone_code', 'string', [
				'default' => null,
				'limit' => 20,
				'null' => true,
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
			])
			->addColumn('lng', 'float', [
				'comment' => 'longitude',
				'default' => null,
				'null' => true,
			])
			->addColumn('address_format', 'string', [
				'default' => null,
				'limit' => 190,
				'null' => true,
			])
			->addColumn('timezone_offset', 'string', [
				'default' => null,
				'limit' => 255,
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
				'null' => false,
			])
			->addIndex(
				[
					'iso2',
				],
				['unique' => true],
			)
			->addIndex(
				[
					'iso3',
				],
				['unique' => true],
			)
			->create();

		// ALTER TABLE `countries` ADD `timezone_offset` VARCHAR(255) NULL AFTER `phone_code`;
		// ALTER TABLE `countries` CHANGE `country_code` `phone_code` VARCHAR(20) NULL DEFAULT NULL;
	}

}
