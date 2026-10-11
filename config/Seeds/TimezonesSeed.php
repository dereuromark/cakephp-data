<?php
declare(strict_types = 1);

use Cake\Core\Configure;
use Cake\I18n\DateTime;
use Data\Sync\Timezones;
use Migrations\BaseSeed;

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
class TimezonesSeed extends BaseSeed {

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
	public function run(): void {
		$timezones = new Timezones();
		$data = Configure::read('Data.Timezone.source') === 'php' ? $timezones->allFromPhp() : $timezones->all();
		if (!$data) {
			$data = $timezones->allFromPhp();
		}
		foreach ($data as $key => $row) {
			$data[$key] = $timezones->normalizeForStorage($row);
			$data[$key]['created'] = $data[$key]['modified'] = (new DateTime())->format('Y-m-d H:i:s');
		}

		$table = $this->table('timezones');
		$table->insert($data)->save();
	}

}
