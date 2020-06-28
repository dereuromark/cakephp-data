<?php

namespace Data\Model\Entity;

use Tools\Model\Entity\Entity;

/**
 * @property int $id
 * @property int $category_id
 * @property int $address_type_id
 * @property int $location_id
 * @property string $c_o
 * @property string $details
 * @property string $admin_details
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string $contact_id
 * @property string $address
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
