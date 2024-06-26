<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\Database\Driver\Postgres;
use Cake\ORM\TableRegistry;
use Shim\TestSuite\TestCase;
use TestApp\Model\Behavior\TestGeocoderBehavior;

class PostalCodesTableTest extends TestCase {

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.Data.PostalCodes',
	];

	/**
	 * @var \Data\Model\Table\PostalCodesTable
	 */
	protected $PostalCodes;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->PostalCodes = TableRegistry::getTableLocator()->get('Data.PostalCodes');
	}

	/**
	 * @return void
	 */
	public function testBasicFind() {
		$result = $this->PostalCodes->find()->first();
		$this->assertNotEmpty($result);
	}

	/**
	 * @return void
	 */
	public function testBasicSave() {
		$config = $this->PostalCodes->behaviors()->Geocoder->getConfig();
		$this->PostalCodes->removeBehavior('Geocoder');
		$this->PostalCodes->addBehavior('Geocoder', ['className' => TestGeocoderBehavior::class] + $config);

		$entity = $this->PostalCodes->newEntity(['code' => '81222']);
		$this->assertEmpty($entity->getErrors());
		$result = $this->PostalCodes->save($entity);
		$this->assertNotEmpty($result);
	}

	/**
	 * @return void
	 */
	public function testSearchLocation() {
		$result = $this->PostalCodes->searchLocation('81234')->first();
		$this->assertNotEmpty($result);
	}

	/**
	 * @return void
	 */
	public function testStats() {
		$connectionConfig = $this->PostalCodes->getConnection()->config();
		$this->skipIf($connectionConfig['driver'] === Postgres::class, 'Does not work for postgres right now');

		$result = $this->PostalCodes->stats();
		$this->assertSame([1 => 1], $result);
	}

}
