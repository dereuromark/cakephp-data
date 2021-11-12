<?php

namespace Data\Model\Entity;

use Tools\Model\Entity\Entity;

/**
 * @property int $id
 * @property int $country_id
 * @property string $name
 * @property string $code
 * @property float|null $lat
 * @property float|null $lng
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Data\Model\Entity\Country $country
 * @property array<\Cake\ORM\Entity> $counties
 */
class State extends Entity {

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

}
