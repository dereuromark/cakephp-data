<?php

namespace Data\Model\Entity;

use Tools\Model\Entity\Entity;

/**
 * @property int $id
 * @property int $country_id
 * @property string $name
 * @property string|null $country_name
 * @property string|null $formatted_address
 * @property string|null $locality
 * @property string|null $sublocality
 * @property float|null $lat
 * @property float|null $lng
 * @property bool|null $inconclusive
 * @property array<string, mixed>|null $geocoder_result
 */
class Location extends Entity {

	/**
	 * @var array<string, bool>
	 */
	protected array $_accessible = [
		'*' => true,
		'id' => false,
	];

}
