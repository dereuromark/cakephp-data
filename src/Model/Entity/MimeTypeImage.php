<?php
declare(strict_types = 1);

namespace Data\Model\Entity;

use Cake\ORM\Entity;

/**
 * MimeTypeImage Entity
 *
 * @property int $id
 * @property string $name
 * @property string $ext
 * @property bool $active
 * @property string $details
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property array<\Data\Model\Entity\MimeType> $mime_types
 */
class MimeTypeImage extends Entity {

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

}
