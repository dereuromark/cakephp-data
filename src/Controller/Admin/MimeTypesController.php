<?php
namespace Data\Controller\Admin;

use Data\Controller\DataAppController;
use Tools\Utility\Mime;

/**
 * @link http://en.wikipedia.org/wiki/List_of_file_formats_(alphabetical)
 * @link http://www.file-extensions.org/extensions/common
 * @link http://www.ace.net.nz/tech/TechFileFormat.html
 *
 * @property \Data\Model\Table\MimeTypesTable $MimeTypes
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
	 * @return void
	 */
	public function detect_by_extension() {
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
	 * @return void
	 */
	public function allocateByType() {
		# get unused extensions?
		$unusedIds = $this->MimeTypes->MimeTypeImages->unusedRecords($this->MimeTypes->table);

		$unused = $this->MimeTypes->MimeTypeImages->find('all', ['conditions' => ['MimeTypeImages.id' => $unusedIds]]);

		$this->set(compact('unused'));
	}

	/**
	 * @return void
	 */
	public function allocate() {
		# get unused extensions
		// TODO

		//$images = $this->MimeTypes->MimeTypeImages->find('all', array('conditions'=>array('active'=>1)));
		$addedIcon = [];
		$types = $this->MimeTypes->find('all', ['conditions' => ['MimeTypes.mime_type_image_id' => 0]]);
		foreach ($types as $type) {
			$fileExt = $type['ext'];
			$image = $this->MimeTypes->MimeTypeImages->find('first', ['conditions' => ['MimeTypeImages.name' => $fileExt]]);
			if (!empty($image)) {
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
	 * @return void
	 */
	public function fromFile() {
	}

	/**
	 * @return void
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
			if ($mime = $this->MimeTypes->mimeTypeExists($ext)) {
				$report['in'][] = ['ext' => $ext, 'type' => $mimeType, 'oldType' => $mime['type']];
				continue;
			}

			//$this->MimeTypes->create();
			$data = [
				'name' => $mimeType,
				'ext' => $ext,
				'type' => $mimeType,
				'active' => 1,
				'core' => 1
			];
			$mimeType = $this->MimeTypes->newEntity($data);

			if ($this->MimeTypes->save($mimeType)) {
				$report['success'][] = ['ext' => $ext, 'type' => $mimeType];
			} else {
				$report['error'][] = ['ext' => $ext, 'type' => $mimeType, 'errors' => $MimeTypes->errors()];
			}
		}

		$this->set(compact('report', 'mimeTypes'));
	}

	/**
	 * @return void
	 */
	public function index() {
		$conditions = $this->_searchConditions([]);
		$this->paginate['conditions'] = $conditions;

		$mimeTypes = $this->paginate();
		$this->set(compact('mimeTypes'));
	}

	/**
	 * @deprecated
	 *
	 * @param array $conditions
	 * @return array
	 */
	protected function _searchConditions($conditions = []) {
		$model = $this->MimeTypes->alias;

		$sessionSearch = $this->request->session()->read($model . '.search');
		$fieldStr = '';
		$searchStr = '';

		if (!empty($this->request->query['clear']) && $this->request->query['clear'] === 'search') {
			$this->request->session()->delete($model . '.search');
		} else {

		if (!empty($this->request->data) && !empty($this->request->data['Form']['field'])) {
			$fieldStr = $this->request->data['Form']['field'];
		} elseif (!empty($this->request->query['field'])) {
			$fieldStr = $this->request->query['field'];
		} elseif (!empty($sessionSearch['field'])) {
			$fieldStr = $sessionSearch['field'];
		}

		if (!empty($this->request->data) && !empty($this->request->data['Form']['search'])) {
			$searchStr = $this->request->data['Form']['search'];
		} elseif (!empty($this->request->query['search'])) {
			$searchStr = $this->request->query['search'];
		} elseif (!empty($sessionSearch['search'])) {
			$searchStr = $sessionSearch['search'];
		}

		}
		$this->set(compact('fields', 'searchStr'));

		if (!empty($searchStr)) {
			$this->request->session()->write($model . '.search', ['search' => $searchStr, 'field' => $fieldStr]);

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
	 * @return \Cake\Network\Response|null
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

	public function add() {
		if ($this->Common->isPosted()) {
			$this->request->data['name'] = ucwords($this->request->data['name']); //ucfirst()
			$this->request->data['mime_type_image_id'] = (int)$this->request->data['mime_type_image_id'];

			$this->MimeTypes->create();
			if ($this->MimeTypes->save($this->request->data)) {
				$id = $this->MimeTypes->id;
				//$name = $this->request->data['name'];
				$this->Flash->success(__('record add {0} saved', $id));
				return $this->redirect(['action' => 'index']);
			}

			$this->Flash->error(__('record add not saved'));
		} else {
			$this->request->data['active'] = 1;
		}
		$mimeTypeImages = $this->MimeTypes->MimeTypeImages->find('list');
		$this->set(compact('mimeTypeImages'));
	}

	public function edit($id = null) {
		if (empty($id)) {
			$this->Flash->error(__('record invalid'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		if ($this->Common->isPosted()) {
			$this->request->data['name'] = ucwords($this->request->data['name']); //ucfirst()
			$this->request->data['mime_type_image_id'] = (int)$this->request->data['mime_type_image_id'];

			if ($this->MimeTypes->save($this->request->data)) {
				//$name = $this->request->data['name'];
				$this->Flash->success(__('record edit {0} saved', $id));
				return $this->redirect(['action' => 'index']);
			}

			$this->Flash->error(__('record edit not saved'));
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->MimeTypes->get($id);
			if (empty($this->request->data)) { # still no record found
				$this->Flash->error(__('record not exists'));
				return $this->redirect(['action' => 'index']);
			}
		}
		$mimeTypeImages = $this->MimeTypes->MimeTypeImages->find('list');
		$this->set(compact('mimeTypeImages'));
	}

	public function delete($id = null) {
		$this->request->allowMethod('post');

		$mimeType = $this->MimeTypes->find('first', ['fields' => ['id'], 'conditions' => ['MimeType.id' => $id]]);
		if (empty($res)) {
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

	public function manualNames() {
		$export = [];
		$data = [];

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
			$array = explode(TB, $r);

			$type = trim($array[0]);
			$name = trim($array[1]);

			$export[] = ['type' => $type];

			$data = ['name' => $name, 'type' => $type];

			$record = $this->MimeTypes->find('first', ['conditions' => ['type' => $type]]);
			pr($record);
			pr($name);

			if (empty($record)) {
				continue;
			}

			if (empty($record['name']) || strtolower($record['name']) == strtolower($record['type'])) {
				//$this->MimeTypes->create();
				$this->MimeTypes->id = $record['id'];
				if (true && $res = $this->MimeTypes->save($data)) {
					echo 'OK:';
					echo $res;
					//echo '<br/>';
				} else {
					pr($this->MimeTypes->validationErrors);
					//echo '<br/>';
				}
			}
			//echo '<br/>';
		}

		$this->autoRender = false;
	}

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
				$record = $this->MimeTypes->find('first', ['conditions' => ['ext' => $d['ext']]]);
			}

			if (!empty($record['type']) && $record['type'] != $d['type']) {
				//echo '<br/>';
				echo '<b>' . $d['ext'] . ' (DIFF TYPES!):</b>';
				//pr($record);
				//pr($d);
				//echo '<br/>';
			}

			if (true) {
				$this->MimeTypes->create();
				if ($this->MimeTypes->save($d)) {
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
