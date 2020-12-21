<?php

namespace Data\Controller\Admin;

use Data\Controller\DataAppController;
use RuntimeException;
use Tools\Utility\Mime;

/**
 * @link http://en.wikipedia.org/wiki/List_of_file_formats_(alphabetical)
 * @link http://www.file-extensions.org/extensions/common
 * @link http://www.ace.net.nz/tech/TechFileFormat.html
 *
 * @property \Data\Model\Table\MimeTypesTable $MimeTypes
 * @method \Data\Model\Entity\MimeType[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MimeTypesController extends DataAppController {

	/**
	 * @var array
	 */
	public $paginate = ['order' => ['MimeTypes.modified' => 'DESC']];

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
				//$data = array()
				if ($this->MimeTypes->saveField($id, 'mime_type_image_id', $image['id'])) {
					$addedIcon[] = $fileExt . ' ' . CHAR_ARROWS . ' ' . $image['name'] . '.' . (!empty($image['ext']) ? $image['ext'] : '?');
				}
			}
		}
		if (!empty($addedIcon)) {
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
			$mime = $this->MimeTypes->mimeTypeExists($ext);
			if ($mime) {
				$report['in'][] = ['ext' => $ext, 'type' => $mimeType, 'oldType' => $mime['type']];

				continue;
			}

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

		$mimeTypes = $this->paginate()->toArray();
		$this->set(compact('mimeTypes'));
	}

	/**
	 * @deprecated
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
		if (empty($mimeType)) {
			$this->Flash->error(__('record not exists'));

			return $this->Common->autoRedirect(['action' => 'index']);
		}
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
			$value = $this->MimeTypes->toggleActive($id);

		}

		$this->autoRender = false;
		if (!empty($value)) {
			$this->set('ajaxToggle', $value);
			$this->render('toggle_active', 'ajax');
		}
	}

	/**
	 * @throws \RuntimeException
	 * @return void
	 */
	public function manualNames() {
		$export = [];

		$result = [
			 'text/plain	Plain text. Default if data is primarily text and no other type detected.',
			 'text/html	HTML',
			 'text/xml	XML data',
			 'text/richtext	Rich Text Format (RTF).',
			 'text/scriptlet	Windows script component.',
			 'audio/x-aiff	Audio Interchange File, Macintosh.',
			 'audio/basic	Audio file, UNIX.',
			 'audio/mid	Internet Explorer 7 and later. MIDI sequence.',
			 'audio/wav	Pulse Code Modulation (PCM) Wave audio, Windows.',
			 'image/gif	Graphics Interchange Format (GIF).',
			 'image/jpeg	JPEG image.',
			 'image/pjpeg	Default type for JPEG images.',
			 'image/png	Internet Explorer 7 and later. Portable Network Graphics (PNG).',
			 'image/x-png	Internet Explorer 7 and later. Default type for PNG images.',
			 'image/tiff	Tagged Image File Format (TIFF) image.',
			 'image/bmp	Bitmap (BMP) image.',
			 'image/x-xbitmap	Removed from Internet Explorer 8.',
			 'image/x-jg	AOL Johnson-Grace compressed file.',
			 'image/x-emf	Enhanced Metafile (EMF).',
			 'image/x-wmf	Windows Metafile Format (WMF).',
			 'video/avi	Audio-Video Interleaved (AVI) file.',
			 'video/mpeg	MPEG stream file.',
			 'application/octet-stream	Binary file. Default if data is primarily binary.',
			 'application/postscript	PostScript (.ai, .eps, or .ps) file.',
			 'application/base64	Base64-encoded bytes.',
			 'application/macbinhex40	BinHex for Macintosh.',
			 'application/pdf	Portable Document Format (PDF).',
			 'application/xml	XML data. Must be server-supplied. See also "text/xml" type.',
			 'application/atom+xml	Internet Explorer 7 and later. Atom Syndication Format feed.',
			 'application/rss+xml	Internet Explorer 7 and later. Really Simple Syndication (RSS) feed.',
			 'application/x-compressed	UNIX tar file, Gzipped.',
			 'application/x-zip-compressed	Compressed archive file.',
			 'application/x-gzip-compressed	Gzip compressed archive file.',
			 'application/java	Java applet.',
			 'application/x-msdownload	Executable (.exe or .dll) file.',
		];
		foreach ($result as $r) {
			$array = explode("\ŧ", $r);

			$type = trim($array[0]);
			$name = trim($array[1]);

			$export[] = ['type' => $type];

			$record = $this->MimeTypes->find()->where(['type' => $type])->first();
			if (!$record) {
				continue;
			}

			$record['name'] = $name;
			$record['type'] = $type;

			$res = $this->MimeTypes->save($record);
			if (!$res) {
				throw new RuntimeException(print_r($record->getErrors(), true));
			}

			echo 'OK:';
			echo $res;
		}

		$this->autoRender = false;
	}

	/**
	 * @return void
	 */
	public function manualInput() {
		//$this->autoRender = false;
		$count = 0;
		$notSaved = 0;

		$result = [];

		$export = [];
		$data = [];

		foreach ($result as $r) {
			$array = explode("\t", $r);

				$type = trim($array[1]);
				$ext = trim($array[0]);
				$export[] = ['type' => $type, 'ext' => $ext];

						$data[] = ['name' => $type, 'type' => $type, 'ext' => $ext, 'active' => 0];

		}
		echo count($data);
		foreach ($data as $d) {

			$record = [];
			if (!empty($d['ext'])) {
				$record = $this->MimeTypes->find('all', ['conditions' => ['ext' => $d['ext']]])->first();
			}

			if (!empty($record['type']) && $record['type'] != $d['type']) {
				//echo '<br/>';
				echo '<b>' . $d['ext'] . ' (DIFF TYPES!):</b>';
				//pr($record);
				//pr($d);
				//echo '<br/>';
			}

			$mimeType = $this->MimeTypes->newEntity($d);
			if ($this->MimeTypes->save($mimeType)) {
				$count++;
				/*
				echo $data['name'].' (INSERTED!):';
				pr ($record);
				pr ($data);
				echo '<br/>';
				*/

			} else {
				$notSaved++;
			}
		}

		if ($count > 0) {
			echo $count . ' neue eingefügt!'; //BR;
		}
		if ($notSaved > 0) {
			echo $notSaved . ' nicht eingefügt!'; //BR;
		}

		if (!empty($export)) {
			$this->set('exportArray', $export);
			/*
				$file = new File(TMP.'mime_types_'.time().'.txt');
			$file->open('w', true);
			$file->write(serialize($export), 'w', true);
			*/
		}
	}

}
