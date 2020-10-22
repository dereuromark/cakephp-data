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

		$sql = <<<SQL
INSERT INTO `continents` (`id`, `name`, `ori_name`, `parent_id`, `lft`, `rght`, `status`, `modified`) VALUES
(1, 'Eurasia', '', null, 1, 6, 0, '2011-07-15 19:55:33'),
(2, 'Europe', '', 1, 2, 3, 1, '2011-07-15 19:55:40'),
(3, 'Asia', '', 1, 4, 5, 1, '2011-07-15 19:55:47'),
(4, 'America', '', null, 7, 12, 1, '2011-07-15 19:56:06'),
(5, 'South America', '', 4, 8, 9, 1, '2011-07-15 19:56:16'),
(6, 'North America', '', 4, 10, 11, 1, '2011-07-15 19:56:22'),
(7, 'Antarctica', '', null, 13, 14, 0, '2011-07-15 19:56:39'),
(8, 'Australia/Oceania', '', null, 15, 16, 1, '2011-07-15 19:56:48');
SQL;
		$this->execute($sql);
	}

}
