<?php

namespace Data\View\Helper;

use Cake\ORM\TableRegistry;
use Cake\View\Helper;
use Exception;
use Shim\Filesystem\File;

if (!defined('FILE_CACHE')) {
	define('FILE_CACHE', TMP);
}

/**
 * @property \Cake\View\Helper\HtmlHelper $Html
 */
class MimeTypeHelper extends Helper {

	/**
	 * @var array<mixed>
	 */
	protected array $helpers = ['Html'];

	/**
	 * @var array|null
	 */
	public $types;

	/**
	 * Special attr: filename (is then used in title instead of *)
	 *
	 * @param string|null $ext
	 * @param array<string, mixed> $attr
	 * @return string
	 */
	public function icon($ext = null, array $attr = []) {
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
				}

				if (!empty($t['name'])) {
					$default['name'] = $t['name'];
				}

				return $this->formatIcon($default, $attr);
			}
		}

		return $this->formatIcon($default, $attr);
	}

	/**
	 * @param array|null $icon
	 * @param array<string, mixed> $attr
	 * @return string
	 */
	public function formatIcon($icon = null, array $attr = []) {
		$filename = '*';
		if (!empty($attr['filename'])) {
			$filename = $attr['filename'];
			unset($attr['filename']);
		}
		$imageAttr = ['class' => 'help', 'title' => $icon['name'] . ' (' . $filename . '.' . $icon['ext'] . ')', 'alt' => $icon['ext'], 'height' => '16'];
		if ($attr) {
			$imageAttr = array_merge($imageAttr, $attr);
		}
		if (!empty($icon['img'])) {
			$image = IMG_MIMETYPES . $icon['img'];
		} else {
			$image = IMG_ICONS . ICON_FILE;
		}

		return $this->Html->image($image, $imageAttr);
	}

	/**
	 * @return array
	 */
	public function types() {
		$this->getTypes();

		return (array)$this->types;
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
			$MimeTypes = TableRegistry::getTableLocator()->get('Data.MimeTypes');
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
				throw new Exception('Write error');
			}
		} else {
			$content = $handle->read();
			if ($content === false) {
				return [];
			}
			$content = unserialize($content);
			if ($content === false || !is_array($content)) {
				return [];
			}
		}

		return $content;
	}

}
