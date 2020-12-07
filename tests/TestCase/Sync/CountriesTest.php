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

		foreach ($result as $country => $row) {
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

}
