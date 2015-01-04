<?php
/**
 * Import data into Country model
 *
 */
class GeoImportLib {

	public function __construct() {
		$this->Country = ClassRegistry::init('Data.Country');
	}

	public function import($countryCode = 'AT') {
		switch ($countryCode) {
			case 'AT':
				return $this->_importAt();
			case 'CH':
				return $this->_importCh();
			case 'DE':
				//TODO
		}
		return null;
	}

	public function importCounties($countryCode = 'AT') {
		switch ($countryCode) {
			case 'AT':
				return null;
			case 'CH':
				return $this->_importChCounties();
			case 'DE':
				//TODO
		}
		return null;
	}

	protected function _importChCounties() {
		$url = 'http://de.wikipedia.org/w/index.php?title=Kanton_(Schweiz)&action=edit&section=4';
		if (file_exists(TMP . 'import.txt')) {
			$res = file_get_contents(TMP . 'import.txt');
		} else {
			$content = $this->_getFromUrl($url);
			App::uses('HtmlDomLib', 'Tools.Lib');
			$HtmlDom = new HtmlDomLib();
			$res = $HtmlDom->domFromString($content)->find('textarea', 0)->innertext;
		}
		if (empty($res)) {
			trigger_error('/tmp/import.txt missing or url not accessable');
			return false;
		}

		$res = substr($res, strpos($res, 'Amtssprache(n)]]&lt;br />') + 25);
		$res = substr($res, 0, strpos($res, '|}'));

		$array = array();
		$res = explode('|-', $res);
		foreach ($res as $key => $val) {
			if (empty($val)) {
				continue;
			}
			$tmp = explode(' | ', $val);

			if (count($tmp) < 20) {
				continue;
			}

			$t = array();
			$t['state'] = $this->_parse($tmp[4]);
			$t['abbr'] = substr($tmp[4], strpos($tmp[4], '(') + 1, 2);
			$tmp[13] = substr($tmp[13], 0, strpos($tmp[13], '&lt;'));
			$tmp[13] = substr($tmp[13], strrpos($tmp[13], '}') + 1);

			$t['citizens'] = (int)str_replace('\'', '', $this->_parse($tmp[13]));
			$t['country'] = 'AT';
			$t['country_id'] = $this->Country->getIdByIso('AT');

			$array[] = $t;
		}

		return $array;
	}

	/**
	 * Manually import from import.txt using content from input textarea on
	 * http://de.wikipedia.org/w/index.php?title=Liste_der_St%C3%A4dte_in_%C3%96sterreich&action=edit&section=4
	 *
	 * @return array cities or FALSE on failure
	 */
	protected function _importCh() {
		$urls = array(
			'http://de.wikipedia.org/w/index.php?title=Liste_der_St%C3%A4dte_in_der_Schweiz&action=edit&section=3',
			'http://de.wikipedia.org/w/index.php?title=Liste_der_St%C3%A4dte_in_der_Schweiz&action=edit&section=4'
		);
		$array = array();
		foreach ($urls as $key => $url) {
			if (file_exists(TMP . 'import.txt')) {
				$res = file_get_contents(TMP . 'import.txt');
			} else {
				$content = $this->_getFromUrl($url);
				App::uses('HtmlDomLib', 'Tools.Lib');
				$HtmlDom = new HtmlDomLib();
				$res = $HtmlDom->domFromString($content)->find('textarea', 0)->innertext;
			}
			if (empty($res)) {
				trigger_error('/tmp/import.txt missing or url not accessable');
				continue;
			}

			switch ($key) {
				case 0:
					$res = substr($res, strpos($res, 'F 2008 !! Kanton') + 16);
					$res = substr($res, 0, strpos($res, '|}'));
					$res = explode('|-', $res);
					foreach ($res as $key => $val) {
						if (empty($val)) {
							continue;
						}
						$tmp = explode('||', $val);
						if (count($tmp) < 7) {
							continue;
						}
						//die(returns($tmp));

						$t = array();
						$t['city'] = $this->_parse($tmp[1]);
						$t['county'] = $t['city'];
						$t['state'] = $this->_parse($tmp[6]);
						$t['citizens'] = (int)str_replace('.', '', $this->_parse($tmp[5]));
						$t['country'] = 'AT';
						$t['country_id'] = $this->Country->getIdByIso('AT');

						$array[] = $t;
					}
					break;

				case 1:
					$res = substr($res, strpos($res, '(VZ 2000)') + 9);
					$res = substr($res, 0, strpos($res, '|}'));
					$res = explode('|-', $res);
					foreach ($res as $key => $val) {
						if (empty($val)) {
							continue;
						}
						$tmp = explode('||', $val);

						//echo returns($tmp);

						if (count($tmp) < 4) {
							continue;
						}

						$t = array();
						$t['city'] = $this->_parse($tmp[0]);
						$t['county'] = $this->_parse($tmp[1]);
						$t['state'] = $this->_parse($tmp[2]);
						$t['citizens'] = (int)str_replace('.', '', $this->_parse($tmp[3]));
						$t['country'] = 'AT';
						$t['country_id'] = $this->Country->getIdByIso('AT');

						if (mb_strlen($t['county']) < 2) {
							$t['county'] = $t['city'];
						}

						$array[] = $t;
					}
					break;
			}

			//die(returns($array));

		}

		return $array;
	}

	/**
	 * Manually import from import.txt using content from input textarea on
	 * http://de.wikipedia.org/w/index.php?title=Liste_der_St%C3%A4dte_in_%C3%96sterreich&action=edit&section=4
	 *
	 * @return array cities or FALSE on failure
	 */
	protected function _importAt() {
		$url = 'http://de.wikipedia.org/w/index.php?title=Liste_der_St%C3%A4dte_in_%C3%96sterreich&action=edit&section=4';

		if (file_exists(TMP . 'import.txt')) {
			$res = file_get_contents(TMP . 'import.txt');
		} else {
			$content = $this->_getFromUrl($url);
			App::uses('HtmlDomLib', 'Tools.Lib');
			$HtmlDom = new HtmlDomLib();
			$res = $HtmlDom->domFromString($content)->find('textarea', 0)->innertext;
		}
		if (empty($res)) {
			trigger_error('/tmp/import.txt missing or url not accessable');
			return false;
		}

		$res = substr($res, strpos($res, '(F 2007)') + 8);
		$res = substr($res, 0, strpos($res, '|}'));

		$array = array();
		$res = explode('|-', $res);
		foreach ($res as $key => $val) {
			if (empty($val)) {
				continue;
			}
			$tmp = explode('||', $val);
			if (count($tmp) < 5) {
				continue;
			}
			# bug in wikipedia bbcode markup
			if (count($tmp) === 6) {
				$tmp[6] = $tmp[5];
			}

			$t = array();
			$t['city'] = $this->_parse($tmp[0]);
			$t['county'] = $this->_parse($tmp[1]);
			$t['state'] = $this->_parse($tmp[2]);
			$t['citizens'] = (int)str_replace('.', '', $this->_parse($tmp[6]));
			$t['country'] = 'AT';
			$t['country_id'] = $this->Country->getIdByIso('AT');

			if ($t['county'] === '<sup>2</sup>') {
				$t['county'] = $t['city'];
			}

			$array[] = $t;
		}

		$counties = array();
		foreach ($array as $city) {
			if (!isset($counties[$city['county']])) {
				$counties[$city['county']] = 1;
			} else {
			$counties[$city['county']]++;
			}
		}
		foreach ($array as $key => $city) {
			$county = $city['county'];
			$array[$key]['single_city'] = (!empty($counties[$county]) && $counties[$county] > 1) ? 0 : 1;
		}

		return $array;
	}

	protected function _getFromUrl($url, $resetCache = false) {
		if ($resetCache) {
			Cache::delete('geo_import_' . md5($url));
		}
		if ($cache = Cache::read('geo_import_' . md5($url))) {
			return $cache;
		}
		App::uses('HttpSocketLib', 'Tools.Lib');
		$HttpSocket = new HttpSocketLib();
		$res = $HttpSocket->fetch($url);
		Cache::write('geo_import_' . md5($url), $res);
		return $res;
	}

	protected function _parse($row) {
		if (($pos = strpos($row, '[[')) !== false) {
			$row = substr($row, $pos + 2);
			$row = substr($row, 0, strpos($row, ']]'));
		} elseif (($pos = strpos($row, '{{')) !== false) {
			$row = substr($row, $pos + 2);
			$row = substr($row, 0, strpos($row, '}}'));
		}

		$values = explode('|', $row);
		$value = array_pop($values);
		return trim($value);
	}

}
