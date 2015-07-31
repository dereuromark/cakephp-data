<?php
namespace Data\Model\Table;

use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Filesystem\File;
use Tools\Network\Email\Email;
use Tools\Model\Table\Table;

class MimeTypesTable extends Table {

	public $order = array('modified' => 'DESC');

	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'valErrMandatoryField',
			),
		),
		'ext' => array(
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'Already exists',
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'valErrMandatoryField',
				'allowEmpty' => false,
				//'required' => true
			),
		),
		'type' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'valErrMandatoryField',
			),
		),
		'active' => array('numeric'),
		'mime_type_image_id' => array('numeric'),
	);

	public $belongsTo = array(
		'MimeTypeImage' => array(
			'className' => 'Data.MimeTypeImage',
			'foreignKey' => 'mime_type_image_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

	public function beforeSave($options = array()) {
		parent::beforeSave($options);
		if (isset($this->data['ext'])) {
			$this->data['ext'] = mb_strtolower($this->data['ext']);
		}
		if (isset($this->data['name'])) {
			$this->data['name'] = ucwords($this->data['name']);
		}

		return true;
	}

	public function afterSave($created, $options = array()) {
		parent::afterSave($created, $options);

		$this->cleanUp();
	}

	public function afterDelete(Event $event, Entity $entity, ArrayObject $options) {
		parent::afterDelete();

		$this->cleanUp();
	}

	public function cleanUp() {
		$Handle = new File(FILES . 'mime_types.txt');
		$Handle->delete();
	}

	public function mimeTypes($inactiveOnes = false) {
		$options = array('conditions' => array($this->alias() . '.ext' => $ext));
		if ($inactiveOnes !== true) {
			$options['conditions'][$this->alias() . '.active'] = 1;
		}
		return $this->find('first', $options);
	}

	public function mimeTypeExists($ext = null) {
		if (empty($ext)) {
			return array();
		}
		return $this->find('first', array('conditions' => array($this->alias() . '.ext' => $ext)));
	}

	/**
	 * Push this type up in the "usage ranking" (sort)
	 * could be done on every upload/download = automagic sort by priority
	 *
	 * @param string $ext
	 * @return void
	 */
	public function push($ext = null) {
		$type = $this->mimeTypeExists($ext);
		if (!empty($type)) {
			$this->id = $type['id'];
			return $this->saveField('sort', $type['sort'] + 1);
		}
		# insert this new extension
		$data = array('ext' => $ext, 'name' => 'auto-added', 'sort' => 1);
		$this->create();
		if (!$this->save($data)) {
			$this->log('problem with pushing new mimeType');
			return false;
		}
		# notify admin
		//App::import('Controller', 'Data.MimeTypes');
		$this->Email = new Email();
		$this->Email->to(Configure::read('Config.adminEmail'), Configure::read('Config.adminEmailname'));
		$this->Email->replyTo(Configure::read('Config.adminEmail'), Configure::read('Config.adminEmailname'));

		$this->Email->subject(Configure::read('Config.page_name') . ' - ' . __('MimeType'));
		$this->Email->template('simple_email');

		$text = 'MimeType hinzugefügt: ' . $ext . '';
		$this->Email->viewVars(compact('text'));

		if (!$this->Email->send()) {
			$this->log('problem with mailing to admin after pushing mimeType');
		}

		return true;
	}

}
