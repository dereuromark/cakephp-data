<?php

namespace Data\Test\TestCase\Sync;

use Cake\Http\Exception\NotFoundException;
use Data\Model\Entity\Timezone;
use Data\Sync\Timezones;
use DateTimeImmutable;
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
		if (!$result) {
			$this->markTestSkipped('Wikipedia timezone data not available (network issue).');
		}
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
		// Check if data is available first
		$all = $this->Timezones->all();
		if (!$all) {
			$this->markTestSkipped('Wikipedia timezone data not available (network issue).');
		}

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

	/**
	 * allFromPhp() must produce the structural data with no network dependency.
	 *
	 * @return void
	 */
	public function testAllFromPhpIsOfflineAndCovers400PlusZones(): void {
		// Pin the references so DST detection is deterministic regardless of when CI runs.
		$standard = new DateTimeImmutable('2026-01-15T12:00:00Z');
		$dst = new DateTimeImmutable('2026-07-15T12:00:00Z');

		$result = $this->Timezones->allFromPhp($standard, $dst);

		$this->assertGreaterThan(400, count($result));

		$this->assertArrayHasKey('Europe/Berlin', $result);
		$berlin = $result['Europe/Berlin'];
		$this->assertSame('Europe/Berlin', $berlin['name']);
		$this->assertSame('DE', $berlin['country_code']);
		$this->assertSame(3600, $berlin['offset']);
		$this->assertSame(7200, $berlin['offset_dst']);
		$this->assertSame('Canonical', $berlin['type']);

		// Wikipedia commentary fields are null on the PHP path.
		$this->assertNull($berlin['covered']);
		$this->assertNull($berlin['abbr']);
		$this->assertNull($berlin['alias']);
	}

	/**
	 * Zones without DST must report null for offset_dst, not the same value as offset.
	 *
	 * @return void
	 */
	public function testAllFromPhpNonDstZoneHasNullOffsetDst(): void {
		$standard = new DateTimeImmutable('2026-01-15T12:00:00Z');
		$dst = new DateTimeImmutable('2026-07-15T12:00:00Z');

		$result = $this->Timezones->allFromPhp($standard, $dst);

		$this->assertArrayHasKey('UTC', $result);
		$this->assertSame(0, $result['UTC']['offset']);
		$this->assertNull($result['UTC']['offset_dst']);
	}

	/**
	 * Wikipedia API JSON shape drift must produce a graceful empty result, not a fatal.
	 *
	 * @return void
	 */
	public function testAllReturnsEmptyOnUnexpectedWikipediaPayload(): void {
		$cachePath = TMP . 'wiki-timezones.txt';
		if (file_exists($cachePath)) {
			unlink($cachePath);
		}
		// Seed the cache with a payload the parser does not understand.
		file_put_contents($cachePath, json_encode(['parse' => ['unexpected' => 'shape']]));

		try {
			$this->assertSame([], $this->Timezones->all());
		} finally {
			if (file_exists($cachePath)) {
				unlink($cachePath);
			}
		}
	}

	/**
	 * Wikipedia unreachable / NotFoundException must degrade to an empty array, not bubble up
	 * as a 500 in the admin sync action. CI runners frequently can't reach Wikipedia at all.
	 *
	 * @return void
	 */
	public function testAllReturnsEmptyOnFetchFailure(): void {
		$cachePath = TMP . 'wiki-timezones.txt';
		if (file_exists($cachePath)) {
			unlink($cachePath);
		}

		// Anonymous subclass that simulates an unreachable upstream by throwing
		// the same exception Timezones::fetchContent() would emit on a non-OK HTTP response.
		$tz = new class extends Timezones {

			protected function fetchContent(): string {
				throw new NotFoundException('Cannot load timezones HTML from Wikipedia');
			}

		};

		$this->assertSame([], $tz->all());
	}

}
