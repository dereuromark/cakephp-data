<?php
namespace Data\Model\Entity;

use Tools\Model\Entity\Entity;

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
