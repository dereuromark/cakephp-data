<?php

namespace Data\Model\Entity;

use Tools\Model\Entity\Entity;

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $symbol_left
 * @property string|null $symbol_right
 * @property string|null $decimal_places
 * @property float|null $value
 * @property bool $base
 * @property bool $active
 * @property \Cake\I18n\DateTime $modified
 */
class Currency extends Entity {

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

}
