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
			$data[$key]['created'] = $data[$key]['modified'] = substr((new FrozenTime())->toIso8601String(), 0, 19);
			$data[$key]['active'] = $row['type'] === 'Canonical';
			unset($data[$key]['abbr']);
			unset($data[$key]['alias']);

			if ($row['country_code'] && strpos($row['country_code'], ',') !== false) {
				$data[$key]['country_code'] = substr($row['country_code'], 0, 2);
			}

			if ($row['notes'] && mb_strlen($row['notes']) > 190) {
				$data[$key]['notes'] = mb_substr($row['notes'], 0, 190);
			}
		}

		$table = $this->table('timezones');
		$table->insert($data)->save();
	}

}
