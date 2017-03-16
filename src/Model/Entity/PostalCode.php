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
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class PostalCode extends Entity {
}
