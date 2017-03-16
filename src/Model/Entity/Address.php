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
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property string $contact_id
 * @property string $address
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

	const TYPE_MAIN = 1;
	const TYPE_OTHER = 9;

}
