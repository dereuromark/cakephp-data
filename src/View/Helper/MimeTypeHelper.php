<?php
namespace Data\View\Helper;

use Cake\View\Helper;
use Cake\Filesystem\File;
use Cake\ORM\TableRegistry;

if (!defined('FILE_CACHE')) {
	define('FILE_CACHE', TMP);
}

class MimeTypeHelper extends Helper {

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
	 * get Types with file cache?
	 * //TODO: use normal cache
	 *
	 * @return array
	 */
	protected function _getTypes() {
		$handle = new File(FILE_CACHE . 'mime_types.txt', true, 0770);
		if (!$handle->exists()) {
			# create and fill: ext||type||name||img (array serialized? separated by ||?)
			$MimeTypes = TableRegistry::get('Data.MimeTypes');
			$mimeTypes = $MimeTypes->find('all', ['fields' => ['name', 'ext', 'type', 'MimeTypeImages.name', 'MimeTypeImages.ext'], 'conditions' => ['MimeTypes.active' => 1], 'contain' => ['MimeTypeImages']]);

			$content = [];
			foreach ($mimeTypes as $m) {
				$img = (!empty($m->mime_type_image['ext']) ? $m->mime_type_image['name'] . '.' . $m->mime_type_image['ext'] : '');
				$content[] = [
					'ext' => $m['ext'],
					'name' => $m['name'],
					'type' => $m['type'],
					'img' => $img,
				];
			}
			# add special types? (file not found icon, default fallback icon, generic file ext icon...)

			if (!$handle->write(serialize($content), 'w', true)) {
				throw new \Exception('Write error');
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
