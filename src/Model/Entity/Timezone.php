<?php
declare(strict_types = 1);

namespace Data\Model\Entity;

use Cake\ORM\Entity;

/**
 * Timezone Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $country_code
 * @property string $offset
 * @property string $offset_dst
 * @property string $type
 * @property bool $active
 * @property float|null $lat
 * @property float|null $lng
 * @property string|null $covered
 * @property string|null $notes
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class Timezone extends Entity {

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
