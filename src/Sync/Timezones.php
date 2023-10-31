<?php

namespace Data\Sync;

use Cake\Http\Client;
use Cake\Http\Exception\NotFoundException;
use Data\Model\Entity\Timezone;
use InvalidArgumentException;

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
		$content = $this->fetchContent();

		$data = json_decode($content, true);
		$data = $data['parse']['wikitext']['*'];

		if (!is_dir(TMP)) {
			mkdir(TMP, 0770, true);
		}
		$rows = explode(PHP_EOL, $data);

		$rows = $this->parse($rows);
		$timezones = [];
		foreach ($rows as $row) {
			preg_match('#\|([^\|]+)]]$#', $row['name'], $nameMatches);
			if ($nameMatches) {
				$name = trim($nameMatches[1]);
				while (strpos($name, '[') === 0) {
					$name = substr($name, 1);
				}
			} else {
				preg_match('#\[\[([^\[]+)]]$#', $row['name'], $nameMatches);
				$name = $nameMatches[1] ?? str_replace(['[[', ']]'], '', $row['name']);
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
				preg_match_all('#\|(\w+)]]#', $row['country_code'], $countryCodeMatches);
				if ($countryCodeMatches[1]) {
					$countryCode = implode(',', $countryCodeMatches[1]);
				} else {
					$countryCode = null;
				}
			}

			/*
			$lat = $lng = null;
			if ($row['lat_lng']) {
				preg_match('#^([+−]\d+)([+−]\d+)$#u', $row['lat_lng'], $latLngMatches);
				if ($latLngMatches) {
					$lat = $latLngMatches[1];
					$lng = $latLngMatches[2];

					$lat = str_replace(['+', '−'], ['+', '-'], $lat);
					$lng = str_replace(['+', '−'], ['+', '-'], $lng);

					$lat = (float)((int)substr($lat, 0, 3) . '.' . substr($lat, 3));
					$lng = (float)((int)substr($lng, 0, 4) . '.' . substr($lng, 4));
				}
			}
			*/

			if ($offset) {
				$offset = static::stringToInt($offset);
			}
			if ($offsetDst) {
				$offsetDst = static::stringToInt($offsetDst);
			}

			$notes = trim($row['notes']);
			preg_match('#\|data-sort-value=[a-z0-9.]+\|(.*)$#i', $row['notes'], $notesMatches);
			if ($notesMatches) {
				$notes = trim($notesMatches[1]);
			}

			$status = null;
			if (strpos($row['status'], 'Canonical') !== false) {
				$status = 'Canonical';
			} elseif (strpos($row['status'], 'Link') !== false) {
				$status = 'Link';
			}

			$abbr = null;
			$alias = null;
			if ($row['abbr']) {
				preg_match('#\|(\w+)]]#', $row['abbr'], $abbrMatches);
				$abbr = $abbrMatches[1] ?? null;

				preg_match('#\[\[([^\|]+)\|#', $row['abbr'], $aliasMatches);
				$alias = $aliasMatches[1] ?? null;
			}

			$timezones[$name] = [
				'name' => $name,
				'country_code' => $countryCode,
				//'lat' => $lat,
				//'lng' => $lng,
				'offset' => $offset,
				'offset_dst' => $offsetDst,
				'type' => $status,
				'covered' => trim($row['covered'], '| ') ?: null,
				'notes' => $notes,
				'alias' => $alias,
				'abbr' => $abbr,
			];
			if ($name === 'Europe/Berlin') {
			}
		}

		ksort($timezones);

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
		$junks = $this->parseJunks($rows);

		$data = [];

		foreach ($junks as $i => $junk) {
			$rowIndex = 0;
			$rowIndexMap = [
				'country_code' => 0,
				'name' => 1,
				'covered' => 2,
				'status' => 3,
				'offset' => 4,
				'offset_dst' => 5,
				'abbr' => 6,
				'notes' => 8,
			];
			$hasDst = count($junk) > 9;
			if ($hasDst) {
				$rowIndexMap['abbr'] = 7;
				$rowIndexMap['notes'] = 9;
			}

			foreach ($rowIndexMap as $field => $pos) {
				$data[$i][$field] = $junk[$pos];
				if ($hasDst && $field === 'abbr') {
					$data[$i][$field] .= '/' . $junk[$pos + 1];
				}

				$rowIndex++;
			}
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

	/**
	 * @param array $rows
	 *
	 * @return array
	 */
	protected function parseJunks(array $rows): array {
		$start = null;
		foreach ($rows as $i => $row) {
			if (strpos($row, '| [[ISO_3166-1:') !== false) {
				$start = $i;

				break;
			}
		}

		$count = count($rows);

		$data = [];
		$index = 0;
		$rowIndex = 0;
		for ($i = $start; $i < $count; $i++) {
			if (!isset($rows[$i])) {
				continue;
			}

			if (strpos($rows[$i], '|- style') === 0 || strpos($rows[$i], '|- id=') === 0) {
				$index++;
				$rowIndex = 0;

				continue;
			}

			$data[$index][] = $rows[$i];
			$rowIndex++;
		}

		return $data;
	}

	protected function fetchContent(): string
	{
		if (file_exists(TMP . 'wiki-timezones.txt')) {
			return (string)file_get_contents(TMP . 'wiki-timezones.txt');
		}

		$client = new Client();
		$client->setConfig(['timeout' => 3]);
		$response = $client->get(sprintf(static::URL, static::PAGE));
		if (!$response->isOk()) {
			throw new NotFoundException('Cannot load timezones HTML from Wikipedia');
		}

		$content = $response->getBody()->getContents();
		file_put_contents(TMP . 'wiki-timezones.txt', $content);

		return $content;
	}

}
