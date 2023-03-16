<?php

namespace Data\Model\Entity;

use Tools\Model\Entity\Entity;

/**
 * @property int $id
 * @property string $name
 * @property string $ori_name
 * @property string $code
 * @property string $iso3
 * @property string $iso2
 * @property string $locale
 * @property string $locale_fallback
 * @property int $status
 * @property int $sort
 * @property int $direction
 * @property \Cake\I18n\FrozenTime $modified
 */
class Language extends Entity {

	/**
	 * Fields that can be mass assigned using newEntity() or patchEntity().
	 *
	 * Note that when '*' is set to true, this allows all unspecified fields to
	 * be mass assigned. For security purposes, it is advised to set '*' to false
	 * (or remove it), and explicitly make individual fields accessible as needed.
	 *
	 * @var array<string, bool>
	 */
	protected $_accessible = [
		'*' => true,
		'id' => false,
	];

	/**
	 * Language::directions()
	 *
	 * @param mixed $value
	 * @return mixed
	 */
	public static function directions($value = null) {
		$options = [
			static::DIR_LTR => 'LTR',
			static::DIR_RTL => 'RTL',
		];

		return parent::enum($value, $options);
	}

	/**
	 * @var int
	 */
	public const DIR_LTR = 0;

	/**
	 * @var int
	 */
	public const DIR_RTL = 1;

	/**
	 * @var int
	 */
	public const STATUS_ACTIVE = 1;

	/**
	 * @var int
	 */
	public const STATUS_INACTIVE = 0;

}
