<?php

namespace Data\View\Helper;

use Cake\View\Helper;

class ContinentHelper extends Helper {

	/**
	 * @param array $data
	 * @return string
	 */
	public function format(array $data): string {
		/** @var \Data\Model\Entity\Continent $continent */
		$continent = $data['data'];

		$text = h($continent->name);
		$countriesPerContinent = (array)$this->getConfig('countries');
		if (!empty($countriesPerContinent[$continent->id])) {
			$text .= ' (' . $countriesPerContinent[$continent->id] . ')';
		}

		if ($continent->status === $continent::STATUS_INACTIVE) {
			$text = '<span class="disabled">' . $text .'</span>';
		}

		return $text;
	}

}
