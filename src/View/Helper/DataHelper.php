<?php

namespace Data\View\Helper;

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Filesystem\Folder;
use Cake\Utility\Inflector;
use Cake\View\Helper;

/**
 * DataHelper with basic html snippets
 *
 * @property \Cake\View\Helper\HtmlHelper $Html
 */
class DataHelper extends Helper {

	/**
	 * @var array
	 */
	protected $helpers = ['Html'];

	/**
	 * @var array|null
	 */
	protected $languageFlags;

	/**
	 * @return array with wwwPath and path
	 */
	public function getCountryIconPaths() {
		$specific = Configure::read('Country.imagePath');
		if ($specific) {
			[$plugin, $specificPath] = pluginSplit($specific);
			if (substr($specificPath, 0, 1) !== '/') {
				$specificPath = '/img/' . $specific;
			}
			$wwwPath = $specificPath;
			if ($plugin) {
				$wwwPath = '/' . Inflector::underscore($plugin) . '/' . $wwwPath;
			}
			if ($plugin) {
				$path = Plugin::path($plugin) . 'webroot' . DS;
			} else {
				$path = WWW_ROOT;
			}
			$specificPath = str_replace('/', DS, $specificPath);
			$path .= trim($specificPath, DS) . DS;
		} else {
			$wwwPath = 'Data.country_flags/';
			$path = Plugin::path('Data') . 'webroot' . DS . 'img' . DS . 'country_flags' . DS;
		}

		return [$wwwPath, $path];
	}

	/**
	 * @return array with wwwPath and path
	 */
	public function getLanguageIconPaths() {
		$specific = Configure::read('Language.imagePath');
		if (!$specific) {
			return $this->getCountryIconPaths();
		}

		[$plugin, $specificPath] = pluginSplit($specific);
		if (substr($specificPath, 0, 1) !== '/') {
			$specificPath = '/img/' . $specific;
		}
		$wwwPath = $specificPath;
		if ($plugin) {
			$wwwPath = '/' . Inflector::underscore($plugin) . '/' . $wwwPath;
		}
		if ($plugin) {
			$path = Plugin::path($plugin) . 'webroot' . DS;
		} else {
			$path = WWW_ROOT;
		}
		$specificPath = str_replace('/', DS, $specificPath);
		$path .= trim($specificPath, DS) . DS;

		return [$wwwPath, $path];
	}

	/**
	 * Country icons
	 *
	 * Custom paths possible:
	 * 'imagePath' => 'PluginName./img/country_flags/',
	 *
	 * @param string|null $icon iso2 code (e.g. 'de' or 'gb')
	 * @param bool $returnFalseOnFailure
	 * @param array $options
	 * @param array $attr
	 * @return string|false
	 */
	public function countryIcon($icon, $returnFalseOnFailure = false, $options = [], $attr = []) {
		$ending = 'gif';
		$image = 'unknown';

		[$wwwPath, $path] = $this->getCountryIconPaths();

		if (!empty($options) && is_array($options)) {
			if (!empty($options['ending'])) {
				$ending = $options['ending'];
			}
		}

		$icon = mb_strtolower($icon);

		if (empty($icon)) {
			if ($returnFalseOnFailure) {
				return false;
			}
		} elseif (!file_exists($path . $icon . '.' . $ending)) {
			trigger_error($path . $icon . '.' . $ending . ' missing', E_USER_NOTICE);

			if ($returnFalseOnFailure) {
				return false;
			}
		} else {
			$image = $icon;
		}

		$defaults = ['alt' => $icon, 'title' => strtoupper($icon)];
		$attr += $defaults;

		return $this->Html->image($wwwPath . $image . '.' . $ending, $attr);
	}

	/**
	 * @param string $iso2
	 * @param array $options
	 * @return string
	 */
	public function languageFlag($iso2, $options = []) {
		$flag = '';

		$defaults = ['alt' => $iso2, 'title' => strtoupper($iso2)];
		$options += $defaults;

		$languageFlags = $this->getAvailableLanguageFlags();

		$name = strtolower($iso2) . '.gif';
		if (!in_array($name, $languageFlags, true)) {
			return $flag;
		}

		$flag .= $this->Html->image('language_flags/' . $name, $options);

		return $flag;
	}

	/**
	 * @return array
	 */
	protected function getAvailableLanguageFlags() {
		if (isset($this->languageFlags)) {
			return $this->languageFlags;
		}

		$flags = Cache::read('language_flags');
		if ($flags !== null) {
			$this->languageFlags = $flags;

			return $this->languageFlags;
		}

		[$wwwPath, $path] = $this->getLanguageIconPaths();
		$handle = new Folder($path);
		$languageFlags = $handle->read(true, true);
		$languageFlags = $languageFlags[1];
		Cache::write('language_flags', $languageFlags);

		$this->languageFlags = $languageFlags;

		return $languageFlags;
	}

}
