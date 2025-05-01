<?php

namespace Data\Model\Table;

use ArrayObject;
use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Tools\Mailer\Mailer;
use Tools\Model\Table\Table;

/**
 * @property \Data\Model\Table\MimeTypeImagesTable|\Cake\ORM\Association\BelongsTo $MimeTypeImages
 * @method \Data\Model\Entity\MimeType newEmptyEntity()
 * @method \Data\Model\Entity\MimeType newEntity(array $data, array $options = [])
 * @method array<\Data\Model\Entity\MimeType> newEntities(array $data, array $options = [])
 * @method \Data\Model\Entity\MimeType get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \Data\Model\Entity\MimeType findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Data\Model\Entity\MimeType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\Data\Model\Entity\MimeType> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Data\Model\Entity\MimeType|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Data\Model\Entity\MimeType saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\MimeType>|false saveMany(iterable $entities, $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\MimeType> saveManyOrFail(iterable $entities, $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\MimeType>|false deleteMany(iterable $entities, $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\MimeType> deleteManyOrFail(iterable $entities, $options = [])
 */
class MimeTypesTable extends Table {

	/**
	 * @var array<int|string, mixed>
	 */
	protected array $order = ['modified' => 'DESC'];

	/**
	 * @var array
	 */
	public $validate = [
		'name' => [
			'notBlank' => [
				'rule' => ['notBlank'],
				'message' => 'valErrMandatoryField',
			],
		],
		'ext' => [
			'notBlank' => [
				'rule' => ['notBlank'],
				'message' => 'valErrMandatoryField',
				'allowEmpty' => false,
				'last' => true,
			],
			'isUnique' => [
				'rule' => 'validateUnique',
				'message' => 'Already exists',
			],
		],
		'type' => [
			'notBlank' => [
				'rule' => ['notBlank'],
				'message' => 'valErrMandatoryField',
			],
		],
		'active' => ['numeric'],
		'mime_type_image_id' => ['numeric'],
	];

	/**
	 * @var array
	 */
	public $belongsTo = [
		'MimeTypeImage' => [
			'className' => 'Data.MimeTypeImage',
			'foreignKey' => 'mime_type_image_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
		],
	];

	/**
	 * @param \Cake\Event\EventInterface $event
	 * @param \Data\Model\Entity\MimeType $entity
	 * @param \ArrayObject $options
	 *
	 * @return void
	 */
	public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options) {
		if (isset($entity['ext'])) {
			$entity['ext'] = mb_strtolower($entity['ext']);
		}
		if (isset($entity['name'])) {
			$entity['name'] = ucwords($entity['name']);
		}
	}

	/**
	 * @param bool $created
	 * @param array<string, mixed> $options
	 * @return void
	 */
	public function _afterSave($created, $options = []): void {
		$this->cleanUp();
	}

	/**
	 * @param \Cake\Event\EventInterface $event
	 * @param \Data\Model\Entity\MimeType $entity
	 * @param \ArrayObject $options
	 * @return void
	 */
	public function afterDelete(EventInterface $event, EntityInterface $entity, ArrayObject $options): void {
		$this->cleanUp();
	}

	/**
	 * @return void
	 */
	public function cleanUp() {
		//$Handle = new File(FILES . 'mime_types.txt');
		//$Handle->delete();
	}

	/**
	 * @param bool $inactiveOnes
	 *
	 * @return \Cake\ORM\Query\SelectQuery
	 */
	public function mimeTypes($inactiveOnes = false) {
		$options = ['conditions' => []];
		if ($inactiveOnes !== true) {
			$options['conditions'][$this->getAlias() . '.active'] = 1;
		}

		return $this->find('all', ...$options);
	}

	/**
	 * @param string|null $ext
	 *
	 * @return \Data\Model\Entity\MimeType|null
	 */
	public function findMimeType($ext = null) {
		if (empty($ext)) {
			return null;
		}

		return $this->find('all', ...['conditions' => [$this->getAlias() . '.ext' => $ext]])->first();
	}

	/**
	 * Push this type up in the "usage ranking" (sort)
	 * could be done on every upload/download = automagic sort by priority
	 *
	 * @param string|null $ext
	 * @return bool
	 */
	public function push($ext = null) {
		/** @var \Data\Model\Entity\MimeType|null $type */
		$type = $this->findMimeType($ext);
		if ($type) {
			$id = $type->id;

			return (bool)$this->updateAll(['sort' => $type['sort'] + 1], ['id' => $id]);
		}
		# insert this new extension
		$data = ['ext' => $ext, 'name' => 'auto-added', 'sort' => 1];
		$mimeType = $this->newEntity($data);
		if (!$this->save($mimeType)) {
			//$this->log('problem with pushing new mimeType');
			return false;
		}
		# notify admin
		$email = new Mailer();
		$email->setTo(Configure::read('Config.adminEmail'), Configure::read('Config.adminEmailname'));
		$email->setReplyTo(Configure::read('Config.adminEmail'), Configure::read('Config.adminEmailname'));

		$email->setSubject(Configure::read('Config.page_name') . ' - ' . __('MimeType'));
		$email->viewBuilder()->setTemplate('simple_email');

		$text = 'MimeType added: ' . $ext . '';
		$email->setViewVars(compact('text'));

		$email->send();

		return true;
	}

}
