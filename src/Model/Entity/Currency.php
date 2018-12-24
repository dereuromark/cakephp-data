<?php
namespace Data\Model\Entity;

use Tools\Model\Entity\Entity;

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $symbol_left
 * @property string|null $symbol_right
 * @property string|null $decimal_places
 * @property float|null $value
 * @property bool $base
 * @property bool $active
 * @property \Cake\I18n\FrozenTime|null $modified
 */
class Currency extends Entity {
}
