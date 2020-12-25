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
 * @property \Cake\I18n\FrozenTime $modified
 * @property string $address_format
 * @property float|null $lng
 * @property float|null $lat
 * @property string $zip_regexp
 * @property int $status
 * @property \Data\Model\Entity\State[] $states
 * @property int|null $continent_id
 * @property \Data\Model\Entity\Continent $continent
 * @property string|null $phone_code
 * @property string|null $timezone
 * @property-read array $timezones
 * @property-read string|null $timezoneString
 * @property-read array $timezoneStrings
 */
class Country extends Entity {

	/**
	 * Fields that can be mass assigned using newEntity() or patchEntity().
	 *
	 * Note that when '*' is set to true, this allows all unspecified fields to
	 * be mass assigned. For security purposes, it is advised to set '*' to false
	 * (or remove it), and explicitly make individual fields accessible as needed.
	 *
	 * @var array
	 */
	protected $_accessible = [
		'*' => true,
		'id' => false,
	];

	public const STATUS_INACTIVE = 0;
	public const STATUS_ACTIVE = 1;

	/**
	 * @return int[]
	 */
	protected function _getTimezones(): array {
		if ($this->timezone === null) {
			return [];
		}

		$timezoneStrings = explode(',', $this->timezone);
		$timezones = [];
		foreach ($timezoneStrings as $value) {
			$timezones[$value] = (int)$value;
		}

		return $timezones;
	}

	/**
	 * @return string[]
	 */
	protected function _getTimezoneStrings(): array {
		if ($this->timezone === null) {
			return [];
		}

		$timezoneStrings = explode(',', $this->timezone);
		$timezones = [];
		foreach ($timezoneStrings as $value) {
			$timezones[$value] = Timezones::intToString((int)$value);
		}

		return $timezones;
	}

	/**
	 * @return string|null
	 */
	protected function _getTimezoneString(): ?string {
		if ($this->timezone === null) {
			return null;
		}

		$timezones = $this->_getTimezoneStrings();

		return implode(',', $timezones);
	}

}
