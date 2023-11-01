<?php

namespace Data\Controller\Admin;

use Data\Controller\DataAppController;
use Data\Utility\Mime;
use Shim\Datasource\Paging\NumericPaginator;

/**
 * @link http://en.wikipedia.org/wiki/List_of_file_formats_(alphabetical)
 * @link http://www.file-extensions.org/extensions/common
 * @link http://www.ace.net.nz/tech/TechFileFormat.html
 *
 * @property \Data\Model\Table\MimeTypesTable $MimeTypes
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\MimeType> paginate($object = null, array $settings = [])
 */
class MimeTypesController extends DataAppController {

	/**
	 * @var array<string, mixed>
	 */
	protected array $paginate = [
		'order' => ['MimeTypes.modified' => 'DESC'],
		'className' => NumericPaginator::class,
	];

	/**
	 * Experimental
	 * needs writing rights on {webroot}/files/tmp
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function detectByExtension() {
		/*
		# Warning (2): finfo_file(): supplied argument is not a valid file_info resource...
		$file = WWW_ROOT.'files'.DS.'tmp'.DS.'test.7z';
		//$file = '/tel/p/tel/files/tmp/test.7z';
		$handle = finfo_open(FILEINFO_MIME,'/usr/share/file/magic');
		$mimeType = finfo_file($handle, $file); //gives "video/mpeg"
		*/

		# try to let PHP detect the mime type by ajax uploading some on the fly created files
		$extensions = ['gif', 'pdf', 'exe', 'ooooooo', '7z', 'vcf', 'csv'];
		foreach ($extensions as $extension) {
			//$handler = new File(WWW_ROOT.'files'.DS.'tmp'.DS.'test.'.$extension, true, 0777);
			//pr(WWW_ROOT.'files'.DS.'tmp'.DS.'test.'.$extension);
		}

		$this->set(compact('extensions'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function allocateByType() {
		# get unused extensions?
		$unusedIds = $this->MimeTypes->MimeTypeImages->unusedRecords($this->MimeTypes->getTable());

		$unused = $this->MimeTypes->MimeTypeImages->find('all', ['conditions' => ['MimeTypeImages.id' => $unusedIds]]);

		$this->set(compact('unused'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function allocate() {
		# get unused extensions
		// TODO

		//$images = $this->MimeTypes->MimeTypeImages->find('all', array('conditions'=>array('active'=>1)));
		$addedIcon = [];
		$types = $this->MimeTypes->find('all', ['conditions' => ['MimeTypes.mime_type_image_id' => 0]]);
		foreach ($types as $type) {
			$fileExt = $type['ext'];
			$image = $this->MimeTypes->MimeTypeImages->find('all', ['conditions' => ['MimeTypeImages.name' => $fileExt]])->first();
			if ($image) {
				$id = $type['id'];
				if ($this->MimeTypes->updateAll(['mime_type_image_id' => $image['id']], ['id' => $id])) {
					$addedIcon[] = $fileExt . ' ' . CHAR_ARROWS . ' ' . $image['name'] . '.' . (!empty($image['ext']) ? $image['ext'] : '?');
				}
			}
		}
		if ($addedIcon) {
			$this->Flash->success(count($addedIcon) . ' File Extension Images added: ' . implode(', ', $addedIcon));
		}
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function fromFile() {
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function fromCore() {
		if ($this->Common->isPosted()) {
			# manual resolvement

		}

		$Mime = new Mime();
		$mimeTypes = $Mime->mimeTypes(true);

		$report = ['success' => [], 'error' => [], 'in' => []];
		foreach ($mimeTypes as $ext => $mimeType) {
			if (is_array($mimeType)) {
				$mimeType = array_shift($mimeType);
			}
			$mime = null; // $this->MimeTypes->mimeTypeExists($ext);
			/*
			if ($mime) {
				$report['in'][] = ['ext' => $ext, 'type' => $mimeType, 'oldType' => $mime['type']];

				continue;
			}
			*/

			//$this->MimeTypes->create();
			$data = [
				'name' => $mimeType,
				'ext' => $ext,
				'type' => $mimeType,
				'active' => 1,
				'core' => 1,
			];
			$mimeType = $this->MimeTypes->newEntity($data);

			if ($this->MimeTypes->save($mimeType)) {
				$report['success'][] = ['ext' => $ext, 'type' => $mimeType];
			} else {
				$report['error'][] = ['ext' => $ext, 'type' => $mimeType, 'errors' => $mimeType->getErrors()];
			}
		}

		$this->set(compact('report', 'mimeTypes'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function index() {
		$conditions = $this->_searchConditions([]);
		$this->paginate['conditions'] = $conditions;

		$mimeTypes = $this->paginate();
		$this->set(compact('mimeTypes'));
	}

	/**
	 * @deprecated To be replaced soon
	 *
	 * @param array $conditions
	 * @return array
	 */
	protected function _searchConditions($conditions = []) {
		$model = $this->MimeTypes->getAlias();

		$sessionSearch = $this->request->getSession()->read($model . '.search');
		$fieldStr = '';
		$searchStr = '';

		if ($this->request->getQuery('clear') && $this->request->getQuery('clear') === 'search') {
			$this->request->getSession()->delete($model . '.search');
		} else {
			if ($this->request->getData() && $this->request->getData('field')) {
				$fieldStr = $this->request->getData('field');
			} elseif ($this->request->getQuery('field')) {
				$fieldStr = $this->request->getQuery('field');
			} elseif (!empty($sessionSearch['field'])) {
				$fieldStr = $sessionSearch['field'];
			}

			if ($this->request->getData() && $this->request->getData('search')) {
				$searchStr = $this->request->getData('search');
			} elseif ($this->request->getQuery('search')) {
				$searchStr = $this->request->getQuery('search');
			} elseif (!empty($sessionSearch['search'])) {
				$searchStr = $sessionSearch['search'];
			}
		}
		$this->set(compact('searchStr'));

		if (!empty($searchStr)) {
			$this->request->getSession()->write($model . '.search', ['search' => $searchStr, 'field' => $fieldStr]);

			$conditions['or'][$model . '.name LIKE'] = '%' . $searchStr . '%';
			$conditions['or'][$model . '.ext LIKE'] = '%' . $searchStr . '%';
			$conditions['or'][$model . '.type LIKE'] = '%' . $searchStr . '%';
			$conditions['or'][$model . '.alt_type LIKE'] = '%' . $searchStr . '%';
		}

		return $conditions;
	}

	/**
	 * @param int|null $id
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function view($id = null) {
		if (empty($id)) {
			$this->Flash->error(__('record invalid'));

			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$mimeType = $this->MimeTypes->get($id);

		$this->set(compact('mimeType'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function add() {
		$mimeType = $this->MimeTypes->newEmptyEntity();

		if ($this->Common->isPosted()) {
			//FIXME: move to beforeMarshal
			//$this->request->data['name'] = ucwords($this->request->data['name']); //ucfirst()
			//$this->request->data['mime_type_image_id'] = (int)$this->request->data['mime_type_image_id'];

			$mimeType = $this->MimeTypes->patchEntity($mimeType, $this->request->getData());
			if ($this->MimeTypes->save($mimeType)) {
				$id = $mimeType->id;
				//$name = $this->request->data['name'];
				$this->Flash->success(__('record add {0} saved', $id));

				return $this->redirect(['action' => 'index']);
			}

			$this->Flash->error(__('record add not saved'));
		} else {
			$this->request = $this->request->withData('active', true);
		}
		$mimeTypeImages = $this->MimeTypes->MimeTypeImages->find('list');
		$this->set(compact('mimeType', 'mimeTypeImages'));
	}

	/**
	 * @param int|null $id
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function edit($id = null) {
		$mimeType = $this->MimeTypes->get($id);
		if ($this->Common->isPosted()) {
			//$this->request->data['name'] = ucwords($this->request->data['name']); //ucfirst()
			//$this->request->data['mime_type_image_id'] = (int)$this->request->data['mime_type_image_id'];
			$mimeType = $this->MimeTypes->patchEntity($mimeType, $this->request->getData());

			if ($this->MimeTypes->save($mimeType)) {
				//$name = $this->request->data['name'];
				$this->Flash->success(__('record edit {0} saved', $id));

				return $this->redirect(['action' => 'index']);
			}

			$this->Flash->error(__('record edit not saved'));
		}

		$mimeTypeImages = $this->MimeTypes->MimeTypeImages->find('list');
		$this->set(compact('mimeType', 'mimeTypeImages'));
	}

	/**
	 * @param int|null $id
	 *
	 * @return \Cake\Http\Response
	 */
	public function delete($id = null) {
		$this->request->allowMethod('post');

		$mimeType = $this->MimeTypes->find('all', ['fields' => ['id'], 'conditions' => ['MimeTypes.id' => $id]])->first();
		if (!$mimeType) {
			$this->Flash->error(__('record del not exists'));

			return $this->Common->autoRedirect(['action' => 'index']);
		}

		if ($this->MimeTypes->delete($mimeType)) {
			$this->Flash->success(__('record del {0} done', $id));

			return $this->Common->autoRedirect(['action' => 'index']);
		}

		$this->Flash->error(__('record del {0} not done exception', $id));

		return $this->Common->autoRedirect(['action' => 'index']);
	}

	/**
	 * @param int|null $id
	 *
	 * @return void
	 */
	public function toggleActive($id = null) {
		$id = (int)$id;

		if ($id > 0 && $this->request->isAll(['post', 'ajax'])) {
			$value = null; // $this->MimeTypes->toggleActive($id);

		}

		$this->autoRender = false;
		if (!empty($value)) {
			$this->set('ajaxToggle', $value);
			$this->render('toggle_active', 'ajax');
		}
	}

}
