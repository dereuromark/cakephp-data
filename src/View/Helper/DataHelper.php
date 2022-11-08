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
	 * Country icons
	 *
	 * Custom paths possible:
	 * 'imagePath' => 'PluginName./img/country_flags/',
	 *
	 * @param string|null $code iso2 code (e.g. 'de' or 'gb')
	 * @param array<string, mixed> $options
	 * @param array $attr
	 *
	 * @return string|null
	 */
	public function countryIcon(?string $code, array $options = [], array $attr = []): ?string {
		$iconFontClass = Configure::read('Country.iconFontClass');
		if ($iconFontClass) {
			$options['class'] = $iconFontClass;

			return $this->countryFontIcon($code, $options, $attr);
		}

		$ending = 'gif';
		$image = 'unknown';

		[$wwwPath, $path] = $this->getCountryIconPaths();

		if (!empty($options) && is_array($options)) {
			if (!empty($options['ending'])) {
				$ending = $options['ending'];
			}
		}

		if ($code) {
			$code = mb_strtolower($code);
		}
		$fileExists = $code && file_exists($path . $code . '.' . $ending);
		if ($code && !$fileExists) {
			trigger_error($path . $code . '.' . $ending . ' missing', E_USER_NOTICE);
		}
		if ($code && $fileExists) {
			$image = $code;
		}

		$defaults = ['alt' => $code, 'title' => $code ? strtoupper($code) : null];
		$attr += $defaults;

		return $this->Html->image($wwwPath . $image . '.' . $ending, $attr);
	}

	/**
	 * @param string|null $code
	 * @param array<string, mixed> $options
	 * @param array $attr
	 *
	 * @return string
	 */
	protected function countryFontIcon(?string $code, array $options = [], array $attr = []): string {
		$class = $options['class'] ?: 'flag-icon';
		$code = $code ? strtolower($code) : '';

		$template = '<span class="' . $class . ' ' . $class . '-' . $code . '" title="' . strtoupper($code) . '"></span>';

		return $template;
	}

	/**
	 * Some language codes do not directly refer to a country code.
	 * Here you need to use the map config.
	 *
	 * @param string $code iso2 code (e.g. 'en' or 'de')
	 * @param array<string, mixed> $options
	 * @param array $attr
	 *
	 * @return string
	 */
	public function languageFlag(string $code, array $options = [], array $attr = []): string {
		$iconFontClass = Configure::read('Language.iconFontClass');
		if ($iconFontClass) {
			$options['class'] = $iconFontClass;
			$icon = $this->mapLanguageToCountry($code);

			return $this->countryFontIcon($icon, $options, $attr);
		}

		$flag = '';

		$defaults = ['alt' => $code, 'title' => strtoupper($code)];
		$options += $defaults;

		$languageFlags = $this->getAvailableLanguageFlags();

		$name = strtolower($code) . '.gif';
		if (!in_array($name, $languageFlags, true)) {
			return $flag;
		}

		$defaults = ['alt' => $code, 'title' => strtoupper($code)];
		$attr += $defaults;

		return $this->Html->image('language_flags/' . $name, $attr);
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

	/**
	 * @param string $iso2
	 *
	 * @return string
	 */
	protected function mapLanguageToCountry(string $iso2): string {
		$code = strtolower($iso2);

		$map = (array)Configure::read('Language.map') + [
			'en' => 'gb',
		];

		if (!isset($map[$code])) {
			return $code;
		}

		return $map[$code];
	}

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

}
