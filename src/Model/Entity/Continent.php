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
 * @property \Cake\ORM\Entity[] $child_continents
 * @property \Cake\ORM\Entity[] $countries
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

	public const STATUS_INACTIVE = 0;
	public const STATUS_ACTIVE = 1;

}
