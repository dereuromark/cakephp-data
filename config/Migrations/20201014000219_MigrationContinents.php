<?php
declare(strict_types = 1);

use Migrations\BaseMigration;

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
// phpcs:disable PSR2R.Classes.ClassFileName.NoMatch
class MigrationContinents extends BaseMigration {

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
			->addColumn('code', 'string', [
				'default' => null,
				'limit' => 2,
				'null' => true,
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

		$this->table('continents')->insert([
			['id' => 1, 'name' => 'Eurasia', 'ori_name' => '', 'code' => null, 'parent_id' => null, 'lft' => 1, 'rght' => 6, 'status' => 0, 'modified' => '2011-07-15 19:55:33'],
			['id' => 2, 'name' => 'Europe', 'ori_name' => '', 'code' => 'EU', 'parent_id' => 1, 'lft' => 2, 'rght' => 3, 'status' => 1, 'modified' => '2011-07-15 19:55:40'],
			['id' => 3, 'name' => 'Asia', 'ori_name' => '', 'code' => 'AS', 'parent_id' => 1, 'lft' => 4, 'rght' => 5, 'status' => 1, 'modified' => '2011-07-15 19:55:47'],
			['id' => 4, 'name' => 'America', 'ori_name' => '', 'code' => null, 'parent_id' => null, 'lft' => 7, 'rght' => 12, 'status' => 0, 'modified' => '2011-07-15 19:56:06'],
			['id' => 5, 'name' => 'South America', 'ori_name' => '', 'code' => 'SA', 'parent_id' => 4, 'lft' => 8, 'rght' => 9, 'status' => 1, 'modified' => '2011-07-15 19:56:16'],
			['id' => 6, 'name' => 'North America', 'ori_name' => '', 'code' => 'NA', 'parent_id' => 4, 'lft' => 10, 'rght' => 11, 'status' => 1, 'modified' => '2011-07-15 19:56:22'],
			['id' => 7, 'name' => 'Antarctica', 'ori_name' => '', 'code' => 'AN', 'parent_id' => null, 'lft' => 13, 'rght' => 14, 'status' => 0, 'modified' => '2011-07-15 19:56:39'],
			['id' => 8, 'name' => 'Australia/Oceania', 'ori_name' => '', 'code' => 'OC', 'parent_id' => null, 'lft' => 15, 'rght' => 16, 'status' => 1, 'modified' => '2011-07-15 19:56:48'],
			['id' => 9, 'name' => 'Africa', 'ori_name' => '', 'code' => 'AF', 'parent_id' => null, 'lft' => 17, 'rght' => 18, 'status' => 1, 'modified' => '2011-07-15 19:56:48'],
		])->saveData();
	}

}
