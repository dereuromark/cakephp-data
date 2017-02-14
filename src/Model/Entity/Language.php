<?php
namespace Data\Model\Entity;

use Tools\Model\Entity\Entity;

class Language extends Entity {

	/**
	 * Language::directions()
	 *
	 * @param mixed $value
	 * @return mixed
	 */
	public static function directions($value = null) {
		$options = [
			static::DIR_LTR => 'LTR',
			static::DIR_RTL => 'RTL'
		];
		return parent::enum($value, $options);
	}

	const DIR_LTR = 0;

	const DIR_RTL = 1;

	const STATUS_ACTIVE = 1;

	const STATUS_INACTIVE = 0;

}
