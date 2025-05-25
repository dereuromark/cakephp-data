<?php
declare(strict_types = 1);

use Migrations\BaseMigration;

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
// phpcs:disable PSR2R.Classes.ClassFileName.NoMatch
class MigrationLanguages extends BaseMigration {

	/**
	 * Change Method.
	 *
	 * More information on this method is available here:
	 * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
	 *
	 * @return void
	 */
	public function change() {
		$this->table('languages')
			->addColumn('name', 'string', [
				'default' => null,
				'limit' => 60,
				'null' => false,
			])
			->addColumn('ori_name', 'string', [
				'default' => null,
				'limit' => 60,
				'null' => false,
			])
			->addColumn('code', 'string', [
				'default' => null,
				'limit' => 6,
				'null' => false,
			])
			->addColumn('iso3', 'char', [
				'default' => null,
				'limit' => 3,
				'null' => false,
			])
			->addColumn('iso2', 'char', [
				'default' => null,
				'limit' => 2,
				'null' => false,
			])
			->addColumn('locale', 'string', [
				'default' => null,
				'limit' => 30,
				'null' => false,
			])
			->addColumn('locale_fallback', 'string', [
				'default' => null,
				'limit' => 30,
				'null' => false,
			])
			->addColumn('status', 'tinyinteger', [
				'default' => '0',
				'limit' => null,
				'null' => false,
				'signed' => false,
			])
			->addColumn('direction', 'tinyinteger', [
				'default' => '0',
				'limit' => null,
				'null' => false,
				'signed' => false,
			])
			->addColumn('sort', 'integer', [
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
	}

}
