<?php
App::uses('DataAppController', 'Data.Controller');

/**
 * @link http://en.wikipedia.org/wiki/List_of_file_formats_(alphabetical)
 * @link http://www.file-extensions.org/extensions/common
 * @link http://www.ace.net.nz/tech/TechFileFormat.html
 *
 */
class MimeTypesController extends DataAppController {

	public $paginate = array('order' => array('MimeType.modified' => 'DESC'));

	public function beforeFilter() {
		parent::beforeFilter();

		//$this->Auth->allow();
	}

/****************************************************************************************
 * USER functions
 ****************************************************************************************/
 /*
	public function index() {
		$this->MimeType->recursive = 0;
		$mimeTypes = $this->paginate();
		$this->set(compact('mimeTypes'));
	}
	public function view($id = null) {
		$this->MimeType->recursive = 0;
		if (empty($id)) {
			$this->Common->flashMessage(__('record invalid'),'error');
			return $this->Common->autoRedirect(array('action'=>'index'));
		}
		$mimeType = $this->MimeType->get($id);
		if (empty($mimeType)) {
			$this->Common->flashMessage(__('record not exists'),'error');
			return $this->Common->autoRedirect(array('action'=>'index'));
		}
		$this->set(compact('mimeType'));
	}

	public function add() {
		if ($this->Common->isPosted()) {
			$this->MimeType->create();
			if ($this->MimeType->save($this->request->data)) {
				$id = $this->MimeType->id;
				//$name = $this->request->data['MimeType']['name'];
				$this->Common->flashMessage(__('record add %s saved', $id),'success');
				return $this->redirect(array('action'=>'index'));
			} else {
				$this->Common->flashMessage(__('record add not saved'),'error');
			}
		}
	}

	public function edit($id = null) {
		if (empty($id)) {
			$this->Common->flashMessage(__('record invalid'),'error');
			return $this->Common->autoRedirect(array('action'=>'index'));
		}
		if ($this->Common->isPosted()) {
			if ($this->MimeType->save($this->request->data)) {
				//$name = $this->request->data['MimeType']['name'];
				$this->Common->flashMessage(__('record edit %s saved', $id),'success');
				return $this->redirect(array('action'=>'index'));
			} else {
				$this->Common->flashMessage(__('record edit not saved'),'error');
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->MimeType->get($id);
			if (empty($this->request->data)) { # still no record found
				$this->Common->flashMessage(__('record not exists'),'error');
				return $this->redirect(array('action'=>'index'));
			}
		}
	}

	public function delete($id = null) {
		if (!$this->Common->isPosted()) {
			throw new MethodNotAllowedException();
		}
		if (empty($id)) {
			$this->Common->flashMessage(__('record invalid'),'error');
			return $this->Common->autoRedirect(array('action'=>'index'));
		}
		$res = $this->MimeType->find('first', array('fields'=>array('id'),'conditions'=>array('MimeType.id'=>$id)));
		if (empty($res)) {
			$this->Common->flashMessage(__('record del not exists'),'error');
			return $this->Common->autoRedirect(array('action'=>'index'));
		}

		//$name = $res['MimeType']['name'];
		if ($this->MimeType->delete($id)) {
			$this->Common->flashMessage(__('record del %s done', $id),'success');
			return $this->Common->autoRedirect(array('action'=>'index'));
		} else {
			$this->Common->flashMessage(__('record del %s not done exception', $id),'error');
			return $this->Common->autoRedirect(array('action'=>'index'));
		}
	}
*/

/****************************************************************************************
 * ADMIN functions
 ****************************************************************************************/

		/**
	  * Experimental
	  * needs writing rights on {webroot}/files/tmp
	  */
	public function admin_detect_by_extension() {

		/*
		# Warning (2): finfo_file(): supplied argument is not a valid file_info resource...
		$file = WWW_ROOT.'files'.DS.'tmp'.DS.'test.7z';
		//$file = '/tel/p/tel/files/tmp/test.7z';
		$handle = finfo_open(FILEINFO_MIME,'/usr/share/file/magic');
		$mimeType = finfo_file($handle, $file); //gives "video/mpeg"
		*/

		# try to let PHP detect the mime type by ajax uploading some on the fly created files
		App::uses('File', 'Utility');
		$extensions = array('gif', 'pdf', 'exe', 'ooooooo', '7z', 'vcf', 'csv');
		foreach ($extensions as $extension) {
			//$handler = new File(WWW_ROOT.'files'.DS.'tmp'.DS.'test.'.$extension, true, 0777);
			//pr(WWW_ROOT.'files'.DS.'tmp'.DS.'test.'.$extension);
		}

		$this->set(compact('extensions'));
	}

	public function admin_allocateByType() {
		# get unused extensions?
		$unusedIds = $this->MimeType->MimeTypeImage->unusedRecords($this->MimeType->table);

		$unused = $this->MimeType->MimeTypeImage->find('all', array('conditions' => array('MimeTypeImage.id' => $unusedIds)));

		$this->set(compact('unused'));
	}

	public function admin_allocate() {
		# get unused extensions
		// TODO

		//$images = $this->MimeType->MimeTypeImage->find('all', array('conditions'=>array('active'=>1)));
		$addedIcon = array();
		$types = $this->MimeType->find('all', array('conditions' => array('MimeType.mime_type_image_id' => 0)));
		foreach ($types as $type) {
			$fileExt = $type['MimeType']['ext'];
			$image = $this->MimeType->MimeTypeImage->find('first', array('conditions' => array('MimeTypeImage.name' => $fileExt)));
			if (!empty($image)) {
				$this->MimeType->id = $type['MimeType']['id'];
				//$data = array()
				if ($this->MimeType->saveField('mime_type_image_id', $image['MimeTypeImage']['id'])) {
					$addedIcon[] = $fileExt . ' ' . CHAR_ARROWS . ' ' . $image['MimeTypeImage']['name'] . '.' . (!empty($image['MimeTypeImage']['ext']) ? $image['MimeTypeImage']['ext'] : '?');
				}
			}
		}
		if (!empty($addedIcon)) {
			$this->Common->flashMessage(count($addedIcon) . ' File Extension Images added: ' . implode(', ', $addedIcon), 'success');
		}
	}

	public function admin_fromFile() {
	}

	public function admin_fromCore() {

		if ($this->Common->isPosted()) {
			# manual resolvement

		}

		App::uses('MimeLib', 'Tools.Lib');
		$Mime = new MimeLib();
		$mimeTypes = $Mime->getMimeTypes(true);

		$report = array('success' => array(), 'error' => array(), 'in' => array());
		foreach ($mimeTypes as $ext => $mimeType) {
			if (is_array($mimeType)) {
				$mimeType = array_shift($mimeType);
			}
			if ($mime = $this->MimeType->mimeTypeExists($ext)) {
				$report['in'][] = array('ext' => $ext, 'type' => $mimeType, 'oldType' => $mime['MimeType']['type']);
				continue;
			}

			$this->MimeType->create();
			$data = array(
				'name' => $mimeType,
				'ext' => $ext,
				'type' => $mimeType,
				'active' => 1,
				'core' => 1
			);

			if ($this->MimeType->save($data)) {
				$report['success'][] = array('ext' => $ext, 'type' => $mimeType);
			} else {
				$report['error'][] = array('ext' => $ext, 'type' => $mimeType, 'errors' => $this->MimeType->validationErrors);
			}
		}

		$this->set(compact('report', 'mimeTypes'));
	}

	public function admin_index() {
		$this->MimeType->recursive = 0;

		$conditions = $this->_searchConditions(array());
		$this->paginate['conditions'] = $conditions;

		$mimeTypes = $this->paginate();
		$this->set(compact('mimeTypes'));
	}

	 function _searchConditions($conditions = array()) {
		$model = $this->MimeType->alias;

		$sessionSearch = $this->Session->read($model . '.search');
		$fieldStr = '';
		$searchStr = '';

		if (!empty($this->request->params['named']['clear']) && $this->request->params['named']['clear'] === 'search') {
			$this->Session->delete($model . '.search');
		} else {

		if (!empty($this->request->data) && !empty($this->request->data['Form']['field'])) {
			$fieldStr = $this->request->data['Form']['field'];
		} elseif (!empty($this->request->params['named']['field'])) {
			$fieldStr = $this->request->params['named']['field'];
		} elseif (!empty($sessionSearch['field'])) {
			$fieldStr = $sessionSearch['field'];
		}

		if (!empty($this->request->data) && !empty($this->request->data['Form']['search'])) {
			$searchStr = $this->request->data['Form']['search'];
		} elseif (!empty($this->request->params['named']['search'])) {
			$searchStr = $this->request->params['named']['search'];
		} elseif (!empty($sessionSearch['search'])) {
			$searchStr = $sessionSearch['search'];
		}

		}
		$this->set(compact('fields', 'searchStr'));

		if (!empty($searchStr)) {
			$this->Session->write($model . '.search', array('search' => $searchStr, 'field' => $fieldStr));

			$conditions['or'][$model . '.name LIKE'] = '%' . $searchStr . '%';
			$conditions['or'][$model . '.ext LIKE'] = '%' . $searchStr . '%';
			$conditions['or'][$model . '.type LIKE'] = '%' . $searchStr . '%';
			$conditions['or'][$model . '.alt_type LIKE'] = '%' . $searchStr . '%';
		}
		return $conditions;
	 }

	public function prepSearchString($string = null, $allowWildCard = false) {
		# not working due to cakes \ => \\ safe string modifications (extra escaping) prior to db query...
		$string = str_replace('%', '\%', $string);
		$string = str_replace('_', '\_', $string);
		return $string;
	}

	public function admin_view($id = null) {
		$this->MimeType->recursive = 0;
		if (empty($id)) {
			$this->Common->flashMessage(__('record invalid'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$mimeType = $this->MimeType->get($id);
		if (empty($mimeType)) {
			$this->Common->flashMessage(__('record not exists'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$this->set(compact('mimeType'));
	}

	public function admin_add() {
		if ($this->Common->isPosted()) {
			$this->request->data['MimeType']['name'] = ucwords($this->request->data['MimeType']['name']); //ucfirst()
			$this->request->data['MimeType']['mime_type_image_id'] = (int)$this->request->data['MimeType']['mime_type_image_id'];

			$this->MimeType->create();
			if ($this->MimeType->save($this->request->data)) {
				$id = $this->MimeType->id;
				//$name = $this->request->data['MimeType']['name'];
				$this->Common->flashMessage(__('record add %s saved', $id), 'success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Common->flashMessage(__('record add not saved'), 'error');
			}
		} else {
			$this->request->data['MimeType']['active'] = 1;
		}
		$mimeTypeImages = $this->MimeType->MimeTypeImage->findList();
		$this->set(compact('mimeTypeImages'));
	}

	public function admin_edit($id = null) {
		if (empty($id)) {
			$this->Common->flashMessage(__('record invalid'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		if ($this->Common->isPosted()) {
			$this->request->data['MimeType']['name'] = ucwords($this->request->data['MimeType']['name']); //ucfirst()
			$this->request->data['MimeType']['mime_type_image_id'] = (int)$this->request->data['MimeType']['mime_type_image_id'];

			if ($this->MimeType->save($this->request->data)) {
				//$name = $this->request->data['MimeType']['name'];
				$this->Common->flashMessage(__('record edit %s saved', $id), 'success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Common->flashMessage(__('record edit not saved'), 'error');
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->MimeType->get($id);
			if (empty($this->request->data)) { # still no record found
				$this->Common->flashMessage(__('record not exists'), 'error');
				return $this->redirect(array('action' => 'index'));
			}
		}
		$mimeTypeImages = $this->MimeType->MimeTypeImage->findList();
		$this->set(compact('mimeTypeImages'));
	}

	public function admin_delete($id = null) {
		if (!$this->Common->isPosted()) {
			throw new MethodNotAllowedException();
		}
		if (empty($id)) {
			$this->Common->flashMessage(__('record invalid'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$res = $this->MimeType->find('first', array('fields' => array('id'), 'conditions' => array('MimeType.id' => $id)));
		if (empty($res)) {
			$this->Common->flashMessage(__('record del not exists'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}

		//$name = $res['MimeType']['name'];
		if ($this->MimeType->delete($id)) {
			$this->Common->flashMessage(__('record del %s done', $id), 'success');
			return $this->Common->autoRedirect(array('action' => 'index'));
		} else {
			$this->Common->flashMessage(__('record del %s not done exception', $id), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
	}

	public function admin_toggleActive($id = null) {
		$this->toggleActive($id);
	}

	public function toggleActive($id = null) {
		$id = (int)$id;

		if ($id > 0 && $this->request->isAll(array('post', 'ajax'))) {
			$value = $this->MimeType->toggleActive($id);

		}

		$this->autoRender = false;
		if (!empty($value)) {
			$this->set('ajaxToggle', $value);
			$this->render('toggle_active', 'ajax');
		}
	}

	public function admin_manual_names() {
		$export = array();
		$data = array();

		$result = array(
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
		);
		foreach ($result as $r) {
			$array = explode(TB, $r);

			$type = trim($array[0]);
			$name = trim($array[1]);

			$export[] = array('type' => $type);

			$data = array('name' => $name, 'type' => $type);

			$record = $this->MimeType->find('first', array('conditions' => array('type' => $type)));
			pr($record);
			pr($name);

			if (empty($record)) {
				continue;
			}

			if (empty($record['MimeType']['name']) || strtolower($record['MimeType']['name']) == strtolower($record['MimeType']['type'])) {
				//$this->MimeType->create();
				$this->MimeType->id = $record['MimeType']['id'];
				if (true && $res = $this->MimeType->save($data)) {
					echo 'OK:';
					echo $res;
					echo BR;
				} else {
					pr($this->MimeType->validationErrors);
					echo BR;
				}
			}
			echo BR;
		}

		$this->autoRender = false;
	}

	public function admin_manual_input() {
		//$this->autoRender = false;
		$count = 0;
		$notSaved = 0;

		$result = array();

		$export = array();
		$data = array();

		foreach ($result as $r) {
			$array = explode(TB, $r);

				$type = trim($array[1]);
				$ext = trim($array[0]);
				$export[] = array('type' => $type, 'ext' => $ext);

						$data[] = array('name' => $type, 'type' => $type, 'ext' => $ext, 'active' => 0);

		}
		echo count($data);
		foreach ($data as $d) {

			$record = array();
			if (!empty($d['ext'])) {
				$record = $this->MimeType->find('first', array('conditions' => array('ext' => $d['ext'])));
			}

			if (!empty($record['MimeType']['type']) && $record['MimeType']['type'] != $d['type']) {
				echo BR;
				echo '<b>' . $d['ext'] . ' (DIFF TYPES!):</b>';
				pr($record);
				pr($d);
				echo BR;
			}

			if (true) {
				$this->MimeType->create();
				if ($this->MimeType->save($d)) {
					$count++;
					/*
					echo $data['name'].' (INSERTED!):';
					pr ($record);
					pr ($data);
					echo BR;
					*/

				} else {
					$notSaved++;
				}
			}
		}

		if ($count > 0) {
			echo $count . ' neue eingefügt!' . BR;
		}
		if ($notSaved > 0) {
			echo $notSaved . ' nicht eingefügt!' . BR;
		}

		if (!empty($export)) {
			$this->set('exportArray', $export);
			/*
			App::uses('File', 'Utility');
			$file = new File(TMP.'mime_types_'.time().'.txt');
			$file->open('w', true);
			$file->write(serialize($export), 'w', true);
			*/
		}
	}

}
