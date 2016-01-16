<?php
App::uses('File', 'Utility');
App::uses('AppHelper', 'View/Helper');

class MimeTypeHelper extends AppHelper {

	public $helpers = ['Html'];

	public $types = null;

	/**
	 * Special attr: filename (is then used in title instead of *)
	 *
	 * @return string
	 */
	public function icon($ext = null, $attr = null) {
		if (empty($ext)) {
			return '';
		}
		if ($this->types === null) {
			$this->getTypes();
		}

		$default = ['ext' => $ext, 'name' => 'Datei'];

		foreach ($this->types as $t) {

			if ($t['ext'] == $ext) {
				if (!empty($t['img'])) {
					return $this->formatIcon($t, $attr);
				} else {
					if (!empty($t['name'])) {
						$default['name'] = $t['name'];
					}
					return $this->formatIcon($default, $attr);
				}
			}

		}
		return $this->formatIcon($default, $attr);
	}

	/**
	 * MimeTypeHelper::formatIcon()
	 *
	 * @param mixed $icon
	 * @param mixed $attr
	 * @return string
	 */
	public function formatIcon($icon = null, $attr = null) {
		$filename = '*';
		if (!empty($attr['filename'])) {
			$filename = $attr['filename'];
			unset($attr['filename']);
		}
		$imageAttr = ['class' => 'help', 'title' => $icon['name'] . ' (' . $filename . '.' . $icon['ext'] . ')', 'alt' => $icon['ext'], 'height' => '16'];
		if (!empty($attr) && is_array($attr)) {
			$imageAttr = array_merge($imageAttr, $attr);
		}
		if (!empty($icon['img'])) {
			$image = IMG_MIMETYPES . $icon['img'];
		} else {
			$image = IMG_ICONS . ICON_FILE;
		}

		return $this->Html->image($image, $imageAttr);
	}

	public function types() {
		$this->getTypes();
		return $this->types;
	}

	/**
	 * @return bool
	 */
	public function getTypes() {
		if ($this->types === null) {
			$this->types = (array)$this->_getTypes();
		}
		if (!empty($this->types)) {
			return true;
		}
		return false;
	}

	/**
	 * MimeTypeHelper::_getTypes()
	 *
	 * @return array
	 */
	protected function _getTypes() {
		$handle = new File(FILES . 'mime_types.txt');
		if (!$handle->exists()) {
			# create and fill: ext||type||name||img (array serialized? separated by ||?)
			$MimeType = ClassRegistry::init('Data.MimeType');
			$mimeTypes = $MimeType->find('all', ['fields' => ['name', 'ext', 'type'], 'conditions' => ['MimeType.active' => 1], 'contain' => ['MimeTypeImage' => ['name', 'ext']]]);

			$content = [];
			foreach ($mimeTypes as $m) {
				$img = (!empty($m['MimeTypeImage']['ext']) ? $m['MimeTypeImage']['name'] . '.' . $m['MimeTypeImage']['ext'] : '');
				$content[] = [
					'ext' => $m['MimeType']['ext'],
					'name' => $m['MimeType']['name'],
					'type' => $m['MimeType']['type'],
					'img' => $img,
				];
			}
			# add special types? (file not found icon, default fallback icon, generic file ext icon...)

			if (!$handle->write(serialize($content), 'w', true)) {
				throw new CakeException('ERROR writing');
			}
		} else {
			//$handle->open('r', true);
			$content = $handle->read();
			if ($content === false) {
				return [];
			}
			$content = @unserialize($content);
			if ($content === false || !is_array($content)) {
				return [];
			}
		}
		return $content;
	}

}
