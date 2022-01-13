<?php

namespace Data\Model\Entity;

use Tools\Model\Entity\Entity;

/**
 * @property int $id
 * @property string $name
 * @property string $ori_name
 * @property string|null $code
 * @property int|null $parent_id
 * @property int|null $lft
 * @property int|null $rght
 * @property int $status
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Data\Model\Entity\Continent|null $parent_continent
 * @property array<\Cake\ORM\Entity> $child_continents
 * @property array<\Cake\ORM\Entity> $countries
 */
class Continent extends Entity {

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

	/**
	 * @param array<int>|int|null $value
	 * @return array<string>|string
	 */
	public static function directions($value = null) {
		$options = [
			static::STATUS_INACTIVE => __('Inactive'),
			static::STATUS_ACTIVE => __('Active'),
		];

		return parent::enum($value, $options);
	}

	/**
	 * @var int
	 */
	public const STATUS_INACTIVE = 0;

	/**
	 * @var int
	 */
	public const STATUS_ACTIVE = 1;

}
