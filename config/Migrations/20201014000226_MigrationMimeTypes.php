<?php
declare(strict_types = 1);

use Migrations\AbstractMigration;

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
// phpcs:disable PSR2R.Classes.ClassFileName.NoMatch
class MigrationMimeTypes extends AbstractMigration {

	/**
	 * Change Method.
	 *
	 * More information on this method is available here:
	 * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
	 *
	 * @return void
	 */
	public function change() {
		$this->table('mime_type_images')
			->addColumn('name', 'string', [
				'comment' => 'extension (e.g. jpg)',
				'default' => null,
				'limit' => 100,
				'null' => false,
			])
			->addColumn('ext', 'string', [
				'comment' => 'extension (lowercase!) of real image (exe.gif -> gif)',
				'default' => null,
				'limit' => 20,
				'null' => false,
			])
			->addColumn('active', 'boolean', [
				'default' => false,
				'limit' => null,
				'null' => false,
			])
			->addColumn('details', 'string', [
				'default' => null,
				'limit' => 190,
				'null' => false,
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

		$this->table('mime_types')
			->addColumn('name', 'string', [
				'comment' => 'Program Name',
				'default' => null,
				'limit' => 100,
				'null' => false,
			])
			->addColumn('ext', 'string', [
				'comment' => 'extension (lowercase!)',
				'default' => null,
				'limit' => 20,
				'null' => false,
			])
			->addColumn('type', 'string', [
				'default' => null,
				'limit' => 190,
				'null' => false,
			])
			->addColumn('alt_type', 'string', [
				'comment' => 'alternate (sometimes there is more than one type)',
				'default' => null,
				'limit' => 190,
				'null' => false,
			])
			->addColumn('details', 'string', [
				'default' => null,
				'limit' => 190,
				'null' => false,
			])
			->addColumn('core', 'boolean', [
				'comment' => 'if part of core definitions',
				'default' => false,
				'limit' => null,
				'null' => false,
			])
			->addColumn('active', 'boolean', [
				'default' => false,
				'limit' => null,
				'null' => false,
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
			->addColumn('sort', 'integer', [
				'comment' => 'often used ones should be on top',
				'default' => '0',
				'limit' => null,
				'null' => false,
			])
			->addColumn('mime_type_image_id', 'integer', [
				'default' => null,
				'limit' => null,
				'null' => true,
				'signed' => false,
			])
			->create();
	}

}
