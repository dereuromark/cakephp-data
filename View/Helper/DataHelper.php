<?php
App::uses('TextHelper', 'View/Helper');

/**
 * DataHelper with basic html snippets
 *
 */
class DataHelper extends TextHelper {

	/**
	 * FormatHelper::countryAndProvince()
	 *
	 * @param mixed $array
	 * @param mixed $options
	 * @return string
	 */
	public function countryAndProvince($array, $options = array()) {
		$res = '<span class="help" title="%s">%s</span>';

		$countryTitle = '';
		if (!empty($array['Country']['name'])) {
			$country = $array['Country']['iso2'];
			$countryTitle .= h($array['Country']['name']) . '';
		} else {
			$country = '';
		}

		if (!empty($array['CountryProvince']['name'])) {
			$countyProvince = h($array['CountryProvince']['abbr']);
			$countryTitle .= (!empty($countryTitle) ? ' - ' : '') . h($array['CountryProvince']['name']);
		} else {
			$countyProvince = '';
			$countryTitle .= '';
		}

		$content = $this->countryIcon($country) . '&nbsp;' . $countyProvince;
		$res = sprintf($res, $countryTitle, $content);
		return $res;
	}

	/**
	 * DataHelper::getCountryIconPaths()
	 *
	 * @return array with wwwPath and path
	 */
	public function getCountryIconPaths() {
		if ($specific = Configure::read('Country.imagePath')) {
			list ($plugin, $specificPath) = pluginSplit($specific);
			$wwwPath = $specificPath;
			if ($plugin) {
				$wwwPath = '/' . Inflector::underscore($plugin) . '/' . $wwwPath;
			}
			if ($plugin) {
				$path = CakePlugin::path($plugin) . 'webroot' . DS;
			} else {
				$path = WWW_ROOT;
			}
			$path .= $specificPath . DS;
		} else {
			$wwwPath = '/data/img/country_flags/';
			$path = App::pluginPath('Data') . 'webroot' . DS . 'img' . DS . 'country_flags' . DS;
		}
		return array($wwwPath, $path);
	}

	/**
	 * Country icons
	 *
	 * Custom paths possible:
	 * 'imagePath' => 'PluginName./img/country_flags/',
	 *
	 * @param string $icon iso2 code (e.g. 'de' or 'gb')
	 * @return string
	 */
	public function countryIcon($icon = null, $returnFalseonFailure = false, $options = array(), $attr = array()) {
		$ending = 'gif';
		$image = 'unknown';

		list($wwwPath, $path) = $this->getCountryIconPaths();

		if (!empty($options) && is_array($options)) {
			if (!empty($options['ending'])) {
				$ending = $options['ending'];
			}
		}
		$icon = mb_strtolower($icon);

		if (empty($icon)) {
			if ($returnFalseonFailure) {
				return false;
			}
		} elseif (!file_exists($path . $icon . '.' . $ending)) {
			trigger_error($path . $icon . '.' . $ending . ' missing', E_USER_NOTICE);

			if ($returnFalseonFailure) {
				return false;
			}
		} else {
			$image = $icon;
		}
		return $this->Html->image($wwwPath . $image . '.' . $ending, $attr);
	}

	/**
	 * FormatHelper::languageFlag()
	 *
	 * @param mixed $iso2
	 * @param mixed $options
	 * @return string
	 */
	public function languageFlag($iso2, $options = array()) {
		$flag = '';

		$defaults = array('alt' => $iso2, 'title' => strtoupper($iso2));
		$options = array_merge($defaults, $options);

		$flag .= $this->Html->image('language_flags/' . strtolower($iso2) . '.gif', $options);
		return $flag;
	}

}