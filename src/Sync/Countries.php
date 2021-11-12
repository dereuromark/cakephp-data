<?php

namespace Data\Sync;

use Cake\Http\Client;
use Cake\Http\Exception\NotFoundException;
use Cake\Utility\Xml;
use Data\Model\Entity\Country;

/**
 * @see https://github.com/dr5hn/countries-states-cities-database/blob/master/xml/countries.xml
 */
class Countries {

    /**
     * @var string
     */
	public const URL_XML = 'https://raw.githubusercontent.com/dr5hn/countries-states-cities-database/master/xml/countries.xml';

	/**
	 * @return array
	 */
	public function all(): array {
		$client = new Client();
		$response = $client->get(static::URL_XML);
		if (!$response->isOk()) {
			throw new NotFoundException('Cannot load countries.csv from GitHub');
		}

		$content = $response->getBody()->getContents();
		$xml = Xml::build($content);

		$array = Xml::toArray($xml);
		$countries = $array['countries']['country'] ?? [];

		$result = [];
		foreach ($countries as $key => $element) {
			if (!empty($element['timezones']) && !isset($element['timezones'][0])) {
				$element['timezones'] = [$element['timezones']];
			}

			$result[$element['iso3']] = $element;
		}

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

		$completeDiff = [];
		foreach ($storedCountries as $key => $storedCountry) {
			if (!isset($all[$key])) {
				$completeDiff['delete'][] = [
					'label' => $storedCountry->name,
					'entity' => $storedCountry,
				];

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
				'data' => $new,
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

		$phoneCode = $this->normalizePhoneCode($country['phone_code']);
		if ($phoneCode !== $storedCountry->phone_code) {
			$diff['phone_code'] = $phoneCode;
		}
		$timezones = $this->normalizeTimeZones($country['timezones']);
		if ($timezones !== $storedCountry->timezone_offset) {
			$diff['timezone'] = $timezones;
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

		if (substr($phoneCode, 0, 1) === '+') {
			$phoneCode = substr($phoneCode, 1);
		}
		if (substr($phoneCode, 0, 2) === '00') {
			$phoneCode = substr($phoneCode, 2);
		}

		if (strpos($phoneCode, ' and ') !== false) {
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

}
