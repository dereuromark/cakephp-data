<?php

namespace Data\Model\Entity;

use Data\Sync\Timezones;
use Tools\Model\Entity\Entity;

/**
 * @property int $id
 * @property string $name
 * @property string $ori_name
 * @property string $iso2
 * @property string $iso3
 * @property bool $eu_member
 * @property string $special
 * @property int $zip_length
 * @property int $sort
 * @property \Cake\I18n\DateTime $modified
 * @property string $address_format
 * @property float|null $lng
 * @property float|null $lat
 * @property string $zip_regexp
 * @property int $status
 * @property array<\Data\Model\Entity\State> $states
 * @property int|null $continent_id
 * @property \Data\Model\Entity\Continent $continent
 * @property string|null $phone_code
 * @property string|null $timezone_offset
 * @property-read array $timezones_offsets
 * @property-read string|null $timezone_offset_string
 * @property-read array<string> $timezone_offset_strings
 * @property array<int> $timezone_offsets
 * @property array<\Data\Model\Entity\Timezone> $timezones
 */
class Country extends Entity {

	/**
	 * Fields that can be mass assigned using newEntity() or patchEntity().
	 *
	 * Note that when '*' is set to true, this allows all unspecified fields to
	 * be mass assigned. For security purposes, it is advised to set '*' to false
	 * (or remove it), and explicitly make individual fields accessible as needed.
	 *
	 * @var array<string, bool>
	 */
	protected array $_accessible = [
		'*' => true,
		'id' => false,
	];

	/**
	 * List of computed or virtual fields that **should** be included in JSON or array
	 * representations of this Entity. If a field is present in both _hidden and _virtual
	 * the field will **not** be in the array/JSON versions of the entity.
	 *
	 * @var array<string>
	 */
	protected array $_virtual = [
		'timezone_offset_string',
	];

	/**
	 * @var int
	 */
	public const STATUS_INACTIVE = 0;

	/**
	 * @return array<int>
	 * @var int
	 */
	public const STATUS_ACTIVE = 1;

	/**
	 * @return array<int>
	 */
	protected function _getTimezoneOffsets(): array {
		if ($this->timezone_offset === null) {
			return [];
		}

		$timezoneStrings = explode(',', $this->timezone_offset);
		$timezones = [];
		foreach ($timezoneStrings as $value) {
			$timezones[$value] = (int)$value;
		}

		return $timezones;
	}

	/**
	 * @return array<string>
	 */
	protected function _getTimezoneOffsetStrings(): array {
		if ($this->timezone_offset === null) {
			return [];
		}

		$timezoneStrings = explode(',', $this->timezone_offset);
		$timezones = [];
		foreach ($timezoneStrings as $value) {
			$timezones[$value] = Timezones::intToString((int)$value);
		}

		return $timezones;
	}

	/**
	 * @return string|null
	 */
	protected function _getTimezoneOffsetString(): ?string {
		if ($this->timezone_offset === null) {
			return null;
		}

		$timezones = $this->_getTimezoneOffsetStrings();

		return implode(',', $timezones);
	}

}
