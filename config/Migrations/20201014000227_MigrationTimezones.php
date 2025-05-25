<?php
declare(strict_types = 1);

use Migrations\BaseMigration;

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
// phpcs:disable PSR2R.Classes.ClassFileName.NoMatch
class MigrationTimezones extends BaseMigration {

	/**
	 * Change Method.
	 *
	 * More information on this method is available here:
	 * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
	 *
	 * @return void
	 */
	public function change() {
		$this->table('timezones')
			->addColumn('name', 'string', [
				'comment' => null,
				'default' => null,
				'limit' => 100,
				'null' => false,
			])
			->addColumn('offset', 'integer', [
				'default' => null,
				'limit' => 10,
				'signed' => true,
				'null' => false,
			])
			->addColumn('offset_dst', 'integer', [
				'default' => null,
				'limit' => 10,
				'signed' => true,
				'null' => false,
			])
			->addColumn('type', 'string', [
				'default' => null,
				'limit' => 100,
				'null' => false,
			])
			->addColumn('country_code', 'string', [
				'comment' => 'ISO_3166-2',
				'default' => null,
				'limit' => 2,
				'null' => true,
			])
			->addColumn('active', 'boolean', [
				'default' => false,
				'limit' => null,
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
			->addColumn('covered', 'string', [
				'default' => null,
				'limit' => 190,
				'null' => true,
			])
			->addColumn('notes', 'string', [
				'default' => null,
				'limit' => 190,
				'null' => true,
			])
			->addColumn('linked_id', 'integer', [
				'default' => null,
				'limit' => null,
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

		// ALTER TABLE `timezones` CHANGE `offset` `offset` INT(10) NULL;
		// ALTER TABLE `timezones` CHANGE `offset_dst` `offset_dst` INT(10) NULL;
	}

}
