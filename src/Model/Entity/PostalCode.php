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
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Data\Model\Entity\Country $country
 */
class PostalCode extends Entity {
}
