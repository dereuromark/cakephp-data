<?php

namespace Data\Test\TestCase\Sync;

use Data\Model\Entity\Timezone;
use Data\Sync\Timezones;
use Shim\TestSuite\TestCase;

class TimezonesTest extends TestCase {

	/**
	 * @var \Data\Sync\Timezones
	 */
	protected $Timezones;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->Timezones = new Timezones();
	}

	/**
	 * @return void
	 */
	public function testAll() {
		$result = $this->Timezones->all();
		$this->assertNotEmpty($result);

		$berlin = $result['Europe/Berlin'];
		unset($berlin['covered']);
		$expected = [
			'name' => 'Europe/Berlin',
			'country_code' => 'DE,DK,NO,SE,SJ',
			//'lat' => (float)52.3,
			//'lng' => (float)13.22,
			'offset' => 3600,
			'offset_dst' => 7200,
			'abbr' => 'CEST',
			'notes' => 'In 1945, the [[Bizone|Trizone]] did not follow Berlin\'s switch to DST, see [[Time in Germany]]',
			'type' => 'Canonical',
			'alias' => 'Central European Summer Time',
		];
		$this->assertEquals($expected, $berlin);
	}

	/**
	 * @return void
	 */
	public function testDiff() {
		$existing = [];
		$existing['Europe/Paris'] = new Timezone([
			'name' => 'Europe/FooBar',
		]);
		$existing['BAD'] = new Timezone([
			'name' => 'Invalid/Country',
		]);

		$result = $this->Timezones->diff($existing);

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
		$this->assertTrue(count($result['add']) >= 488);
	}

	/**
	 * @return void
	 */
	public function testIntToString(): void {
		$result = Timezones::intToString(3600);
		$this->assertSame('+01:00', $result);

		$result = Timezones::intToString(-3600);
		$this->assertSame('-01:00', $result);

		$result = Timezones::intToString(19800);
		$this->assertSame('+05:30', $result);
	}

	/**
	 * @return void
	 */
	public function testStringToInt(): void {
		$result = Timezones::stringToInt('01:00');
		$this->assertSame(3600, $result);

		$result = Timezones::stringToInt('+01:00');
		$this->assertSame(3600, $result);

		$result = Timezones::stringToInt('-01:00');
		$this->assertSame(-3600, $result);
	}

}
