<?php
declare(strict_types = 1);

use Cake\I18n\FrozenTime;
use Data\Sync\Timezones;
use Migrations\AbstractSeed;

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
class TimezonesSeed extends AbstractSeed {

	/**
	 * Run Method.
	 *
	 * Write your database seeder using this method.
	 *
	 * More information on writing seeds is available here:
	 * https://book.cakephp.org/phinx/0/en/seeding.html
	 *
	 * @return void
	 */
	public function run() {
		$data = (new Timezones())->all();
		foreach ($data as $key => $row) {
			$data[$key]['created'] = $data[$key]['modified'] = new FrozenTime();
			$data[$key]['active'] = $row['type'] === 'Canonical';
		}

		$table = $this->table('timezones');
		$table->insert($data)->save();
	}

}
