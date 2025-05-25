<?php
declare(strict_types = 1);

use Migrations\BaseMigration;

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
// phpcs:disable PSR2R.Classes.ClassFileName.NoMatch
class MigrationStates extends BaseMigration {

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
			->addColumn('country_id', 'integer', [
				'default' => null,
				'limit' => null,
				'null' => false,
				'signed' => false,
			])
			->addColumn('code', 'string', [
				'default' => null,
				'limit' => 6,
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
			])
			->addColumn('lng', 'float', [
				'default' => null,
				'null' => true,
			])
			->addColumn('modified', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->create();
	}

}
