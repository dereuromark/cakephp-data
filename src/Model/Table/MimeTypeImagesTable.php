<?php

namespace Data\Model\Table;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\Filesystem\File;
use Tools\Model\Table\Table;

/**
 * @property \Data\Model\Table\MimeTypesTable&\Cake\ORM\Association\HasMany $MimeTypes
 * @method \Data\Model\Entity\MimeTypeImage newEmptyEntity()
 * @method \Data\Model\Entity\MimeTypeImage newEntity(array $data, array $options = [])
 * @method array<\Data\Model\Entity\MimeTypeImage> newEntities(array $data, array $options = [])
 * @method \Data\Model\Entity\MimeTypeImage get($primaryKey, $options = [])
 * @method \Data\Model\Entity\MimeTypeImage findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Data\Model\Entity\MimeTypeImage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\Data\Model\Entity\MimeTypeImage> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Data\Model\Entity\MimeTypeImage|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Data\Model\Entity\MimeTypeImage saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Data\Model\Entity\MimeTypeImage[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Data\Model\Entity\MimeTypeImage[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Data\Model\Entity\MimeTypeImage[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Data\Model\Entity\MimeTypeImage[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class MimeTypeImagesTable extends Table {

	/**
	 * @var array
	 */
	protected $order = ['modified' => 'DESC'];

	/**
	 * @var array
	 */
	public $validate = [
		'name' => [ # e.g. "exe"
			'isUnique' => [
				'rule' => ['isUnique'],
				'message' => 'valErrMandatoryField',
				//'required' => true
			],
			'notBlank' => [
				'rule' => ['notBlank'],
				'message' => 'valErrMandatoryField',
				//'required' => true
			],
		],
		'ext' => [], # e.g. "jpg" on a file "exe.jpg"
		'active' => ['numeric'],
	];

	/**
	 * @var array
	 */
	public $hasMany = [
		'MimeType' => [
			'className' => 'Data.MimeType',
			'foreignKey' => 'mime_type_image_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
		],
	];

	/**
	 * @var \Cake\Datasource\EntityInterface|null
	 */
	protected $_del;

	/**
	 * @param \Cake\Event\EventInterface $event
	 * @param \Data\Model\Entity\MimeTypeImage $entity
	 * @param \ArrayObject $options
	 *
	 * @return void
	 */
	public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options) {
		if (isset($entity['name'])) {
			$entity['name'] = mb_strtolower($entity['name']);
		}
		if (isset($entity['ext'])) {
			$entity['ext'] = mb_strtolower($entity['ext']);
		}
	}

	/**
	 * @param \Cake\Event\EventInterface $event
	 * @param \Data\Model\Entity\MimeTypeImage $entity
	 * @param \ArrayObject $options
	 *
	 * @return void
	 */
	public function afterSave(EventInterface $event, EntityInterface $entity, ArrayObject $options) {
		$this->cleanUp();
	}

	/**
	 * @param \Cake\Event\EventInterface $event
	 * @param \Data\Model\Entity\MimeTypeImage $entity
	 * @param \ArrayObject $options
	 *
	 * @return void
	 */
	public function beforeDelete(EventInterface $event, EntityInterface $entity, ArrayObject $options) {
		$this->_del = $entity;
	}

	/**
	 * @param \Cake\Event\EventInterface $event
	 * @param \Data\Model\Entity\MimeTypeImage $entity
	 * @param \ArrayObject $options
	 *
	 * @return void
	 */
	public function afterDelete(EventInterface $event, EntityInterface $entity, ArrayObject $options) {
		if (!empty($this->_del)) {
			# todo: ...
			$image = $this->_del['name'] . '.' . $this->_del['ext'];

			# delete image (right now: move to archive)
			if (file_exists(PATH_MIMETYPES . $image)) {
				if (!rename(PATH_MIMETYPES . $image, PATH_MIMETYPES . 'archive' . DS . $image)) {
					return;
				}
			}

			# remove id from mime_types table

			/** @var array<\Cake\Datasource\EntityInterface> $types */
			$types = $this->MimeTypes->find('all', ['fields' => ['id'], 'conditions' => ['mime_type_image_id' => $this->_del->id]])->toArray();
			foreach ($types as $type) {
				$id = $type['id'];
				$this->MimeTypes->updateAll(['mime_type_image_id' => null], ['id' => $id]);
				//pr ($type[$this->MimeTypes->alias]['id'].' del success');
			}
		}

		# clean up!
		$this->cleanUp();
	}

	/**
	 * @return void
	 */
	public function cleanUp() {
		$handle = new File(FILES . 'mime_types.txt');
		$handle->delete();
	}

	/**
	 * @return array
	 */
	public function findAsList() {
		$list = [];
		$images = $this->find('all', ['conditions' => ['active' => 1]]); // ,'contain'=>'MimeType.id'
		foreach ($images as $image) {
			//$count = count($image['MimeType']);
			$list[$image['id']] = $image['name'] . '.' . (!empty($image['ext']) ? $image['ext'] : '?');
		}

		return $list;
	}

	/**
	 * @param int|null $id
	 * @param string|null $fileName
	 * @param string|null $ext
	 *
	 * @return bool
	 */
	public function allocate($id = null, $fileName = null, $ext = null) {
		if (empty($fileName) && empty($id) || empty($ext)) {
			return false;
		}

		if (empty($id)) {
			# new entry
			$data = ['name' => $fileName, 'ext' => $ext, 'active' => 1];
			$mimeTypeImage = $this->newEntity($data);
			if ($this->save($mimeTypeImage)) {
				return true;
			}
		} else {
			$data = ['ext' => $ext];
			if ($this->updateAll($data, ['id' => $id])) {
				return true;
			}
		}

		return false;
	}

	/**
	 * ALLOWED EXTENSIONS
	 *
	 * @param string|null $value
	 * @return mixed|array|string
	 */
	public static function extensions($value = null) {
		$options = [
			'gif' => __('GIF (*.gif)'),
			'png' => __('PNG (*.png)'),
			'jpg' => __('JPG (*.jpg)'),
		];

		if ($value !== null) {
			if (array_key_exists($value, $options)) {
				return $options[$value];
			}

			return '';
		}

		return $options;
	}

}
