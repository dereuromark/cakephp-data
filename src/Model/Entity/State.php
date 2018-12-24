<?php
namespace Data\Model\Entity;

use Tools\Model\Entity\Entity;

/**
 * @property int $id
 * @property int|null $country_id
 * @property string $abbr
 * @property string $name
 * @property float $lat
 * @property float $lng
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Data\Model\Entity\Country $country
 */
class State extends Entity {
}
