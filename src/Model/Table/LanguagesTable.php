<?php
namespace Data\Model\Table;

use App\I18n\L10n;
use Cake\Cache\Cache;
use Cake\Core\App;
use Data\Model\DataAppModel;
use Tools\HtmlDom\HtmlDom;
use Tools\Model\Table\Table;

/**
 * Languages and their locales
 * for details see
 * http://www.loc.gov/standards/iso639-2/php/code_list.php
 *
 */
class LanguagesTable extends Table {

	public $order = array('name' => 'ASC');

	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'valErrMandatoryField',
			),
		),
		'ori_name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'valErrMandatoryField',
			),
		),
		'code' => array(
			/*
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'valErrMandatoryField',
			),
			*/
		),
		'locale' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'valErrMandatoryField',
				'last' => true
			),
			'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'valErrRecordNameExists',
			),
		),
		'locale_fallback' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'valErrMandatoryField',
				'last' => true
			),
		),
		'status' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'valErrMandatoryField',
			),
		),
	);

	public $filterArgs = array(
		'search' => array('type' => 'like', 'field' => array('name', 'ori_name', 'code', 'locale', 'locale_fallback')),
		'dir' => array('type' => 'value', 'field' => 'direction')
	);

	/**
	 * For language switch etc
	 *
	 * @return array
	 */
	public function getActive($type = 'all') {
		$options = array(
			'conditions' => array('status' => self::STATUS_ACTIVE),
		);
		return $this->find($type, $options);
	}

	/**
	 * Language::getPrimaryLanguages()
	 *
	 * @param string $type
	 * @param array $customOptions
	 * @return array
	 */
	public function getPrimaryLanguages($type = 'all', $customOptions = array()) {
		$options = array(
			'conditions' => array('locale_fallback = locale'),
		);
		return $this->find($type, $options);
	}

	/**
	 * FIXME: can have errors due to group and wrong locales
	 * 1 => Deutsch, ...
	 *
	 * @return array
	 */
	public function getList($conditions = array()) {
		$res = $this->find('all', array('group' => array('code'), 'conditions' => $conditions, 'fields' => array('id', 'name')));
		$ret = array();
		foreach ($res as $language) {
			$ret[$language['id']] = $language['name'];
		}
		return $ret;
	}

	/**
	 * DE => Deutsch, ...
	 *
	 * @return array
	 */
	public function codeList($conditions = array()) {
		$res = $this->find('all', array('group' => array('code'), 'conditions' => $conditions, 'fields' => array('code', 'name')));
		$ret = array();
		foreach ($res as $language) {
			$ret[$language['code']] = $language['name'];
		}
		return $ret;
	}

	/**
	 * Maps ISO 639-3 to I10n::__l10nCatalog (iso2?)
	 *
	 * @param lang: iso3
	 * @return lang: iso2
	 */
	public function iso3ToIso2($iso3 = null) {
		if (!isset($this->L10n)) {
			$this->L10n = new L10n();
		}
		$languages = $this->L10n->__l10nMap;
		if ($iso3) {
			if (array_key_exists($iso3, $languages)) {
				return $languages[$iso3];
			}
			return false;
		}
		return $languages;
	}

	/**
	 * @param lang: iso2 or iso3
	 * @return mixed: string if lang passed (or false on failure) - or complete array if null is passed
	 */
	public function catalog($lang = null) {
		if (!isset($this->L10n)) {
			$this->L10n = new L10n();
		}
		return $this->L10n->catalog($lang);
	}

	/**
	 * @return Array 2d heading and values
	 */
	public function getOfficialIsoList() {
		$this->HtmlDom = new HtmlDom();
		if (!($res = Cache::read('lov_gov_iso_list'))) {
			$res = file_get_contents('http://www.loc.gov/standards/iso639-2/php/code_list.php');
			$res = $this->HtmlDom->domFromString($res);
			Cache::write('lov_gov_iso_list', $res);
		}

		foreach ($res->find('table') as $element) {
			$languageArray = $element->plaintext;
			$languageArray = explode(TB . TB, $languageArray);
			array_shift($languageArray);
			$max = count($languageArray);

			$languageArray[($max - 1)] = array_shift(explode(' ', $languageArray[($max - 1)]));
			foreach ($languageArray as $key => $val) {
				$languageArray[$key] = trim(str_replace(array("&lt;", "&gt;", '&amp;', '&#039;', '&quot;', '&nbsp;'), array("<", ">", '&', '\'', '"', ' '), $val));
			}

			$languages = array();
			for ($i = 0; $i < $max; $i = $i + 4) {
				$iso3 = $languageArray[$i];
				if (isset($languages[$iso3])) {
					continue;
				}

				$iso2 = $languageArray[$i + 1];
				if (strpos($iso3, '(') !== false) {
					$iso3array = explode(NL, $iso3);
					foreach ($iso3array as $key => $val) {
						if (strpos($val, '(T)') === false) {
							continue;
						}
						$iso3 = trim(array_shift(explode('(', $val)));
					}
				}
				$languages[$iso3] = array('iso3' => $iso3, 'iso2' => $iso2, 'ori_name' => $languageArray[$i + 2]);
			}

			$heading = array('ISO 639-2 Code (alpha3)', 'ISO 639-1 Code (alpha2)', 'English name of Language');
			break;
		}

		return array('heading' => $heading, 'values' => $languages);
	}

	/**
	 * Language::directions()
	 *
	 * @param mixed $value
	 * @return mixed
	 */
	public static function directions($value = null) {
		$options = array(
			self::DIR_LTR => 'LTR',
			self::DIR_RTL => 'RTL'
		);
		return parent::enum($value, $options);
	}

	const DIR_LTR = 0;

	const DIR_RTL = 1;

	const STATUS_ACTIVE = 1;

	const STATUS_INACTIVE = 0;

}
