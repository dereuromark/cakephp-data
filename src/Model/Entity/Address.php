<?php

namespace Data\Model\Entity;

use Tools\Model\Entity\Entity;

/**
 * @property int $id
 * @property int|null $category_id
 * @property int|null $address_type_id
 * @property int|null $location_id
 * @property string|null $c_o
 * @property string|null $details
 * @property string|null $admin_details
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string $contact_id
 * @property string|null $address
 * @property int|null $state_id
 * @property int|null $country_id
 * @property string $zip_code
 * @property string $city
 * @property string $street
 * @property float $lat
 * @property float $lng
 * @property \Data\Model\Entity\Country $country
 * @property \Data\Model\Entity\State $state
 * @property \App\Model\Entity\User $user
 */
class Address extends Entity {

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
	 * @param int|null $value
	 * @return array|string
	 */
	public static function addressTypes($value = null) {
		$options = [
			static::TYPE_MAIN => __('Main Residence'),
			static::TYPE_OTHER => __('Other'),

		];

		return parent::enum($value, $options);
	}

	public const TYPE_MAIN = 1;
	public const TYPE_OTHER = 9;

}
