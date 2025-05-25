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

		$sql = <<<SQL
INSERT INTO `continents` (`id`, `name`, `ori_name`, `code`, `parent_id`, `lft`, `rght`, `status`, `modified`) VALUES
(1, 'Eurasia', '', null, null, 1, 6, 0, '2011-07-15 19:55:33'),
(2, 'Europe', '', 'EU', 1, 2, 3, 1, '2011-07-15 19:55:40'),
(3, 'Asia', '', 'AS', 1, 4, 5, 1, '2011-07-15 19:55:47'),
(4, 'America', '', null, null, 7, 12, 0, '2011-07-15 19:56:06'),
(5, 'South America', '', 'SA', 4, 8, 9, 1, '2011-07-15 19:56:16'),
(6, 'North America', '', 'NA', 4, 10, 11, 1, '2011-07-15 19:56:22'),
(7, 'Antarctica', '', 'AN', null, 13, 14, 0, '2011-07-15 19:56:39'),
(8, 'Australia/Oceania', '',  'OC', null, 15, 16, 1, '2011-07-15 19:56:48')
(9, 'Africa', '',  'AF', null, 17, 18, 1, '2011-07-15 19:56:48');
SQL;
		$this->execute($sql);
	}

}
