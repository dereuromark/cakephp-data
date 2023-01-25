<?php

namespace Data\Model\Entity;

use Tools\Model\Entity\Entity;

/**
 * @property string $id
 * @property string $code
 * @property int $country_id
 * @property float $lat
 * @property float $lng
 * @property string $official_address
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 * @property \Data\Model\Entity\Country $country
 */
class PostalCode extends Entity {

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
