<?php

namespace Data\Test\TestCase\Sync;

use Data\Model\Entity\Country;
use Data\Sync\Countries;
use Shim\TestSuite\TestCase;

class CountriesTest extends TestCase {

	/**
	 * @var \Data\Sync\Countries
	 */
	protected $Countries;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->Countries = new Countries();
	}

	/**
	 * @return void
	 */
	public function testAll() {
		$result = $this->Countries->all();

		$this->assertNotEmpty($result);
		$this->assertTrue(count($result) > 247);

		foreach ($result as $row) {
			if (empty($row['timezones'])) {
				continue;
			}

			$timezones = [];
			foreach ($row['timezones'] as $timezone) {
				$this->assertIsNumeric($timezone['gmtOffset']);
				$timezones[] = $timezone['gmtOffset'];
			}

			$timezoneString = implode(', ', $timezones);
			$this->assertTrue(mb_strlen($timezoneString) < 255, $timezoneString . ': ' . mb_strlen($timezoneString));
		}
	}

	/**
	 * @return void
	 */
	public function testDiff() {
		$existing = [];
		$existing['DEU'] = new Country([
			'iso3' => 'DEU',
			'name' => 'Geeermany',
		]);
		$existing['BAD'] = new Country([
			'iso3' => 'BAD',
			'name' => 'Invalid Country',
		]);

		$result = $this->Countries->diff($existing);

		$keys = array_keys($result);
		$expected = [
			'add',
			'edit',
			'delete',
		];
		sort($keys);
		sort($expected);

		$this->assertSame($expected, $keys);
		$this->assertCount(1, $result['delete']);
		$this->assertCount(1, $result['edit']);
		$this->assertTrue(count($result['add']) >= 248);
	}

	public function testDiffUsesPersistedTimezoneField(): void {
		$sync = $this->getMockBuilder(Countries::class)->onlyMethods(['all'])->getMock();
		$sync->expects($this->once())->method('all')->willReturn([
			'DEU' => [
				'name' => 'Germany',
				'native' => 'Deutschland',
				'iso2' => 'DE',
				'phone_code' => '49',
				'timezones' => [['gmtOffset' => 3600]],
			],
		]);
		$country = new Country([
			'name' => 'Germany',
			'ori_name' => 'Deutschland',
			'iso2' => 'DE',
			'phone_code' => '49',
			'timezone_offset' => '0',
		]);
		$result = $sync->diff(['DEU' => $country], ['timezone_offset']);
		$this->assertSame(['timezone_offset' => '3600'], $result['edit'][0]['fields']);
	}

	public function testDiffHandlesMissingTimezones(): void {
		$sync = $this->getMockBuilder(Countries::class)->onlyMethods(['all'])->getMock();
		$sync->expects($this->once())->method('all')->willReturn([
			'DEU' => ['name' => 'Germany', 'native' => 'Deutschland', 'iso2' => 'DE', 'phone_code' => '49'],
		]);
		$country = new Country([
			'name' => 'Germany',
			'ori_name' => 'Deutschland',
			'iso2' => 'DE',
			'phone_code' => '49',
			'timezone_offset' => null,
		]);
		$this->assertSame([], $sync->diff(['DEU' => $country]));
	}

	public function testNewCountriesMapNativeNamesAndOffsets(): void {
		$sync = $this->getMockBuilder(Countries::class)->onlyMethods(['all'])->getMock();
		$sync->expects($this->once())->method('all')->willReturn([
			'DEU' => [
				'name' => 'Germany',
				'native' => 'Deutschland',
				'iso2' => 'DE',
				'iso3' => 'DEU',
				'timezones' => [['gmtOffset' => 3600]],
			],
		]);
		$result = $sync->diff([]);
		$this->assertSame('Deutschland', $result['add'][0]['data']['ori_name']);
		$this->assertSame('3600', $result['add'][0]['data']['timezone_offset']);
	}

	public function testEmptyUpstreamDoesNotProposeDeletions(): void {
		$sync = $this->getMockBuilder(Countries::class)->onlyMethods(['all'])->getMock();
		$sync->expects($this->once())->method('all')->willReturn([]);
		$this->assertSame([], $sync->diff(['DEU' => new Country(['name' => 'Existing'])]));
	}

}
