<?php

namespace Data\Sync;

use Cake\Http\Client;
use Cake\Http\Exception\NotFoundException;
use Data\Model\Entity\Timezone;
use InvalidArgumentException;
use RuntimeException;

/**
 * @see https://en.wikipedia.org/wiki/List_of_tz_database_time_zones
 */
class Timezones {

    /**
     * @var string
     */
	public const URL = 'https://en.wikipedia.org/w/api.php?action=parse&page=%s&prop=wikitext&format=json';

    /**
     * @var string
     */
	public const PAGE = 'List_of_tz_database_time_zones';

	/**
	 * @return array
	 */
	public function all(): array {
		$client = new Client();
		$response = $client->get(sprintf(static::URL, static::PAGE));
		if (!$response->isOk()) {
			throw new NotFoundException('Cannot load timezones HTML from Wikipedia');
		}

		$content = $response->getBody()->getContents();
		$data = json_decode($content, true);
		$data = $data['parse']['wikitext']['*'];

		file_put_contents(TMP . 'timezones.txt', $data);
		$rows = explode(PHP_EOL, $data);

		$rows = $this->parse($rows);

		$timezones = [];
		foreach ($rows as $row) {
			preg_match('#\|(.+?)]]$#', $row['name'], $nameMatches);
			if ($nameMatches) {
				$name = $nameMatches[1];
			} else {
				$name = str_replace(['[[', ']]'], '', $row['name']);
			}

			$offset = null;
			preg_match('#\|(.\d+:\d+)]]$#', str_replace('−', '-', $row['offset']), $offsetMatches);
			if ($offsetMatches) {
				$offset = $offsetMatches[1];
			}
			$offsetDst = null;
			preg_match('#\|(.\d+:\d+)]]$#', str_replace('−', '-', $row['offset_dst']), $offsetDstMatches);
			if ($offsetDstMatches) {
				$offsetDst = $offsetDstMatches[1];
			}

			$countryCode = null;
			if ($row['country_code']) {
				preg_match('#\|(.+?)]]$#', $row['country_code'], $countryCodeMatches);
				$countryCode = $countryCodeMatches ? $countryCodeMatches[1] : null;
			}

			$lat = $lng = null;
			if ($row['lat_lng']) {
				preg_match('#^([+−]\d+)([+−]\d+)$#u', $row['lat_lng'], $latLngMatches);
				$lat = $latLngMatches[1];
				$lng = $latLngMatches[2];

				$lat = str_replace(['+', '−'], ['+', '-'], $lat);
				$lng = str_replace(['+', '−'], ['+', '-'], $lng);

				$lat = (float)((int)substr($lat, 0, 3) . '.' . substr($lat, 3));
				$lng = (float)((int)substr($lng, 0, 4) . '.' . substr($lng, 4));
			}

			if ($offset) {
				$offset = static::stringToInt($offset);
			}
			if ($offsetDst) {
				$offsetDst = static::stringToInt($offsetDst);
			}
			if (!is_numeric($offset) || !is_numeric($offsetDst)) {
				throw new RuntimeException('Not numeric value encountered in offset or offset_dst for ' . $name . '!');
			}

			$timezones[$name] = [
				'name' => $name,
				'country_code' => $countryCode,
				'lat' => $lat,
				'lng' => $lng,
				'offset' => $offset,
				'offset_dst' => $offsetDst,
				'type' => $row['status'],
				'covered' => $row['covered'] ?: null,
				'notes' => $row['notes'],
			];
		}

		return $timezones;
	}

	/**
	 * @param array<\Data\Model\Entity\Timezone> $storedTimezones
	 * @param array<string> $fields
	 *
	 * @return array
	 */
	public function diff(array $storedTimezones, array $fields = []): array {
		$all = $this->all();

		$completeDiff = [];
		foreach ($storedTimezones as $key => $storedTimezone) {
			if (!isset($all[$key])) {
				$completeDiff['delete'][] = [
					'label' => $storedTimezone->name,
					'entity' => $storedTimezone,
				];

				continue;
			}

			$diff = $this->getDifferences($storedTimezone, $all[$key]);
			if ($fields) {
				$diff = array_intersect_key($diff, array_combine($fields, $fields));
			}
			if (!$diff) {
				unset($all[$key]);

				continue;
			}

			$completeDiff['edit'][] = [
				'label' => $storedTimezone->name,
				'entity' => $storedTimezone,
				'fields' => $diff,
			];

			unset($all[$key]);
		}

		foreach ($all as $new) {
			$completeDiff['add'][] = [
				'label' => $new['name'],
				'data' => $new,
			];
		}

		return $completeDiff;
	}

	/**
	 * @param \Data\Model\Entity\Timezone $storedTimezone
	 * @param array $timezone
	 *
	 * @return array
	 */
	protected function getDifferences(Timezone $storedTimezone, array $timezone): array {
		$diff = [];

		if ((string)$timezone['country_code'] !== (string)$storedTimezone->country_code) {
			$diff['country_code'] = $timezone['country_code'];
		}
		if ($timezone['offset'] !== $storedTimezone->offset) {
			$diff['offset'] = $timezone['offset'];
		}
		if ($timezone['offset_dst'] !== $storedTimezone->offset_dst) {
			$diff['offset_dst'] = $timezone['offset_dst'];
		}
		if ($timezone['type'] !== $storedTimezone->type) {
			$diff['type'] = $timezone['type'];
		}
		if ((string)$timezone['covered'] !== (string)$storedTimezone->covered) {
			$diff['covered'] = $timezone['covered'];
		}

		return $diff;
	}

	/**
	 * @param array $rows
	 *
	 * @return array
	 */
	protected function parse(array $rows): array {
		$start = null;
		foreach ($rows as $i => $row) {
			if (strpos($row, '|-|-') !== false) {
				$start = $i;

				break;
			}
		}

		$start++;
		$count = count($rows);

		$data = [];
		$index = 0;
		$rowIndex = 0;
		$rowIndexMap = [
			'country_code',
			'lat_lng',
			'name',
			'covered',
			'status',
			'offset',
			'offset_dst',
			'notes',
		];
		for ($i = $start; $i < $count; $i++) {
			if ($rows[$i] === '|}') {
				break;
			}
			if ($rows[$i] === '|-') {
				$index++;
				$rowIndex = 0;

				continue;
			}

			if (!isset($rowIndexMap[$rowIndex])) {
				continue;
			}
			$field = $rowIndexMap[$rowIndex];
			$data[$index][$field] = substr($rows[$i], 2);
			$rowIndex++;
		}

		return $data;
	}

	/**
	 * -3600 => -01:00
	 * +3600 => +01:00
	 *
	 * @param int $offset
	 *
	 * @return string
	 */
	public static function intToString(int $offset): string {
		$rest = $offset % 3600;
		$hours = (int)floor($offset / 3600);
		$sign = $offset < 0 ? '-' : '+';
		$hours = abs($hours);

		$hourString = str_pad((string)$hours, 2, '0', STR_PAD_LEFT);
		$minuteString = str_pad((string)(int)floor($rest / 60), 2, '0', STR_PAD_LEFT);

		return $sign . $hourString . ':' . $minuteString;
	}

	/**
	 *  -01:00 => -3600
	 *  +01:00 => +3600
	 *
	 * @param string $offset
	 *
	 * @return int
	 */
	public static function stringToInt(string $offset): int {
		preg_match('/^([+-]?)(\d+):(\d+)$/', $offset, $matches);
		if (!$matches) {
			throw new InvalidArgumentException('Invalid offset');
		}

		$sign = $matches[1] ?: '+';
		$hours = (int)$matches[2];
		$minutes = (int)$matches[3];

		return ($hours * HOUR + $minutes * MINUTE) * ($sign === '-' ? -1 : 1);
	}

}
