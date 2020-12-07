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
		$expected = [
			'name' => 'Europe/Berlin',
			'country_code' => 'DE',
			'lat' => (float)52.3,
			'lng' => (float)13.22,
			'offset' => '+01:00',
			'offset_dst' => '+02:00',
			'covered' => 'Germany (most areas)',
			'notes' => 'In 1945, the Trizone did not follow Berlin\'s switch to DST, see [[Time in Germany]]',
			'type' => 'Canonical',
		];
		$this->assertEquals($expected, $result['Europe/Berlin']);
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

}
