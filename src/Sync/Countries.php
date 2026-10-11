<?php

namespace Data\Sync;

use Cake\Http\Client;
use Cake\Http\Exception\NotFoundException;
use Cake\Utility\Exception\XmlException;
use Cake\Utility\Xml;
use Data\Model\Entity\Country;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * @see https://github.com/dr5hn/countries-states-cities-database/blob/master/xml/countries.xml
 */
class Countries {

	protected bool $sourceAvailable = true;

	public function __construct(protected ?Client $client = null) {
	}

	/**
	 * @var string
	 */
	public const URL_XML = 'https://raw.githubusercontent.com/dr5hn/countries-states-cities-database/master/xml/countries.xml';

	/**
	 * @return array
	 */
	public function all(): array {
		$this->sourceAvailable = true;
		try {
			$content = $this->fetchContent();
			$xml = Xml::build($content, ['readFile' => false]);
		} catch (ClientExceptionInterface | NotFoundException | XmlException) {
			$this->sourceAvailable = false;

			return [];
		}

		$array = Xml::toArray($xml);
		$countries = $array['countries']['country'] ?? [];
		if (isset($countries['iso3'])) {
			$countries = [$countries];
		}

		$result = [];
		foreach ($countries as $element) {
			if (!is_array($element) || empty($element['iso3']) || empty($element['iso2']) || empty($element['name'])) {
				continue;
			}
			if (!empty($element['timezones']) && !isset($element['timezones'][0])) {
				$element['timezones'] = [$element['timezones']];
			}

			$result[$element['iso3']] = $element;
		}

		$this->sourceAvailable = (bool)$result;

		return $result;
	}

	/**
	 * @param array<\Data\Model\Entity\Country> $storedCountries
	 * @param array<string> $fields
	 *
	 * @return array
	 */
	public function diff(array $storedCountries, array $fields = []): array {
		$all = $this->all();
		if (!$all) {
			$this->sourceAvailable = false;

			return [];
		}

		$completeDiff = [];
		foreach ($storedCountries as $key => $storedCountry) {
			if (!isset($all[$key])) {
				continue;
			}

			$diff = $this->getDifferences($storedCountry, $all[$key]);
			if ($fields) {
				$diff = array_intersect_key($diff, array_combine($fields, $fields));
			}
			if (!$diff) {
				unset($all[$key]);

				continue;
			}

			$completeDiff['edit'][] = [
				'label' => $storedCountry->name,
				'entity' => $storedCountry,
				'fields' => $diff,
			];

			unset($all[$key]);
		}

		foreach ($all as $new) {
			$completeDiff['add'][] = [
				'label' => $new['name'],
				'data' => [
					'name' => $new['name'],
					'ori_name' => ($new['native'] ?? '') ?: $new['name'],
					'iso2' => $new['iso2'],
					'iso3' => $new['iso3'],
					'phone_code' => $this->normalizePhoneCode($new['phonecode'] ?? $new['phone_code'] ?? ''),
					'timezone_offset' => $this->normalizeTimeZones($new['timezones'] ?? []),
				],
			];
		}

		return $completeDiff;
	}

	/**
	 * @param \Data\Model\Entity\Country $storedCountry
	 * @param array $country
	 *
	 * @return array
	 */
	protected function getDifferences(Country $storedCountry, array $country): array {
		$diff = [];

		if ($country['name'] !== $storedCountry->name) {
			$diff['name'] = $country['name'];
		}
		if ($country['native'] !== $storedCountry->ori_name) {
			$diff['ori_name'] = $country['native'];
		}
		if ($country['iso2'] !== $storedCountry->iso2) {
			$diff['iso2'] = $country['iso2'];
		}

		$phoneCode = $this->normalizePhoneCode($country['phonecode'] ?? $country['phone_code'] ?? '');
		if ($phoneCode !== $storedCountry->phone_code) {
			$diff['phone_code'] = $phoneCode;
		}
		$timezones = $this->normalizeTimeZones($country['timezones'] ?? []);
		if ($timezones !== $storedCountry->timezone_offset) {
			$diff['timezone_offset'] = $timezones;
		}

		return $diff;
	}

	/**
	 * @param string $phoneCode
	 *
	 * @return string|null
	 */
	protected function normalizePhoneCode(string $phoneCode): ?string {
		if (!$phoneCode) {
			return null;
		}

		if (str_starts_with($phoneCode, '+')) {
			$phoneCode = substr($phoneCode, 1);
		}
		if (str_starts_with($phoneCode, '00')) {
			$phoneCode = substr($phoneCode, 2);
		}

		if (str_contains($phoneCode, ' and ')) {
			$phoneCodePieces = explode(' and ', $phoneCode);
			$phoneCode = implode(',', $phoneCodePieces);
		}

		return $phoneCode;
	}

	/**
	 * @param array $timezones
	 *
	 * @return string|null
	 */
	protected function normalizeTimeZones(array $timezones): ?string {
		$array = [];
		foreach ($timezones as $timezone) {
			$array[] = $timezone['gmtOffset'];
		}
		$array = array_unique($array);

		if (!$array) {
			return null;
		}

		return implode(',', $array);
	}

	/**
	 * @return string
	 */
	protected function fetchContent(): string {
		$client = $this->client ?? new Client(['timeout' => 3]);
		$response = $client->get(static::URL_XML);
		if (!$response->isOk()) {
			throw new NotFoundException('Cannot load countries.xml from GitHub');
		}

		return $response->getBody()->getContents();
	}

	public function isSourceAvailable(): bool {
		return $this->sourceAvailable;
	}

}
