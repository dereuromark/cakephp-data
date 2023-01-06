<?php
declare(strict_types = 1);

namespace Data\Model\Entity;

use Cake\ORM\Entity;
use Data\Sync\Timezones;

/**
 * Timezone Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $country_code
 * @property int $offset
 * @property int $offset_dst
 * @property string $type
 * @property bool $active
 * @property float|null $lat
 * @property float|null $lng
 * @property string|null $covered
 * @property string|null $notes
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Data\Model\Entity\Timezone|null $canonical_timezone
 * @property int|null $linked_id
 * @property-read string|null $offset_string
 * @property-read string|null $offset_dst_string
 */
class Timezone extends Entity {

	/**
	 * Fields that can be mass assigned using newEntity() or patchEntity().
	 *
	 * Note that when '*' is set to true, this allows all unspecified fields to
	 * be mass assigned. For security purposes, it is advised to set '*' to false
	 * (or remove it), and explicitly make individual fields accessible as needed.
	 *
	 * @var array<string, bool>
	 */
	protected array $_accessible = [
		'*' => true,
		'id' => false,
	];

	/**
	 * List of computed or virtual fields that **should** be included in JSON or array
	 * representations of this Entity. If a field is present in both _hidden and _virtual
	 * the field will **not** be in the array/JSON versions of the entity.
	 *
	 * @var array<string>
	 */
	protected array $_virtual = [
		'offset_string',
		'offset_dst_string',
	];

	/**
	 * @return string|null
	 */
	protected function _getOffsetString(): ?string {
		if ($this->offset === null) {
			return null;
		}

		return Timezones::intToString($this->offset);
	}

	/**
	 * @return string|null
	 */
	protected function _getOffsetDstString(): ?string {
		if ($this->offset_dst === null) {
			return null;
		}

		return Timezones::intToString($this->offset_dst);
	}

}
