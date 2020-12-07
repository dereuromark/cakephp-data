<?php

namespace Data\Model\Entity;

use Tools\Model\Entity\Entity;

/**
 * @property int $id
 * @property string $name
 * @property string $ori_name
 * @property string $iso2
 * @property string $iso3
 * @property int $country_code
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

}
