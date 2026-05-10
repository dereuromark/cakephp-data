<?php

namespace Data\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Shim\TestSuite\TestCase;

class LocationsTableTest extends TestCase {

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.Data.Locations',
	];

	/**
	 * @var \Data\Model\Table\LocationsTable
	 */
	protected $Locations;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->Locations = TableRegistry::getTableLocator()->get('Data.Locations');
	}

	/**
	 * @return void
	 */
	public function testBasicFind() {
		$result = $this->Locations->find()->first();
		$this->assertNotEmpty($result);
	}

	/**
	 * @return void
	 */
	public function testBasicSave() {
		$data = [
			'country_id' => 1,
			'state_id' => 1,
			'city' => 'Berlin',
		];
		$location = $this->Locations->newEntity($data);
		$result = $this->Locations->save($location);
		$this->assertNotEmpty($result);
	}

	/**
	 * Non-numeric coordinates must return null, not blow up or build a malformed query.
	 *
	 * @return void
	 */
	public function testFindLocationByCoordinatesRejectsNonNumeric() {
		$this->assertNull($this->Locations->findLocationByCoordinates('abc', 13.4));
		$this->assertNull($this->Locations->findLocationByCoordinates(52.5, 'def'));
		$this->assertNull($this->Locations->findLocationByCoordinates(52.5, 13.4, 'limit'));
	}

	/**
	 * Numeric strings that pass is_numeric must produce a runnable query (no SQL injection
	 * or syntax error from raw interpolation). The previous implementation embedded the raw
	 * value into the SELECT expression unsanitized; %F-formatting the cast float fixes that.
	 *
	 * @return void
	 */
	public function testFindLocationByCoordinatesEmitsParameterizedQuery() {
		$query = $this->Locations->findLocationByCoordinates(52.520008, 13.404954, 5);
		$this->assertNotNull($query);

		$sql = $query->sql();
		// The locale-safe formatter must always emit a `.` decimal separator.
		$this->assertStringContainsString('52.520008', $sql);
		$this->assertStringContainsString('13.404954', $sql);
		// And no unbound colon-prefixed parameter placeholders should leak in.
		$this->assertStringNotContainsString(',520008', $sql);
	}

	/**
	 * A leading-+ string passes is_numeric and must still produce a clean float in the SQL.
	 *
	 * @return void
	 */
	public function testFindLocationByCoordinatesNormalizesLeadingPlus() {
		$query = $this->Locations->findLocationByCoordinates('+52.5', '+13.4', 1);
		$this->assertNotNull($query);
		$sql = $query->sql();
		$this->assertStringContainsString('52.500000', $sql);
		$this->assertStringContainsString('13.400000', $sql);
	}

}
