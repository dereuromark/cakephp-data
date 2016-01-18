<?php
App::uses('DataAppModel', 'Data.Model');
App::uses('L10n', 'I18n');
App::uses('HtmlDomLib', 'Tools.Lib');

/**
 * Languages and their locales
 * for details see
 * http://www.loc.gov/standards/iso639-2/php/code_list.php
 *
 */
class Language extends DataAppModel {

	public $order = ['name' => 'ASC'];

	public $validate = [
		'name' => [
			'notEmpty' => [
				'rule' => ['notEmpty'],
				'message' => 'valErrMandatoryField',
			],
		],
		'ori_name' => [
			'notEmpty' => [
				'rule' => ['notEmpty'],
				'message' => 'valErrMandatoryField',
			],
		],
		'code' => [
			/*
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'valErrMandatoryField',
			),
			*/
		],
		'locale' => [
			'notEmpty' => [
				'rule' => ['notEmpty'],
				'message' => 'valErrMandatoryField',
				'last' => true
			],
			'isUnique' => [
				'rule' => ['isUnique'],
				'message' => 'valErrRecordNameExists',
			],
		],
		'locale_fallback' => [
			'notEmpty' => [
				'rule' => ['notEmpty'],
				'message' => 'valErrMandatoryField',
				'last' => true
			],
		],
		'status' => [
			'numeric' => [
				'rule' => ['numeric'],
				'message' => 'valErrMandatoryField',
			],
		],
	];

	public $filterArgs = [
		'search' => ['type' => 'like', 'field' => ['name', 'ori_name', 'code', 'locale', 'locale_fallback']],
		'dir' => ['type' => 'value', 'field' => 'direction']
	];

	/**
	 * For language switch etc
	 *
	 * @return array
	 */
	public function getActive($type = 'all') {
		$options = [
			'conditions' => ['status' => self::STATUS_ACTIVE],
		];
		return $this->find($type, $options);
	}

	/**
	 * Language::getPrimaryLanguages()
	 *
	 * @param string $type
	 * @param array $customOptions
	 * @return array
	 */
	public function getPrimaryLanguages($type = 'all', $customOptions = []) {
		$options = [
			'conditions' => ['locale_fallback = locale'],
		];
		return $this->find($type, $options);
	}

	/**
	 * FIXME: can have errors due to group and wrong locales
	 * 1 => Deutsch, ...
	 *
	 * @return array
	 */
	public function getList($conditions = []) {
		$res = $this->find('all', ['group' => ['code'], 'conditions' => $conditions, 'fields' => ['id', 'name']]);
		$ret = [];
		foreach ($res as $language) {
			$ret[$language[$this->alias]['id']] = $language[$this->alias]['name'];
		}
		return $ret;
	}

	/**
	 * DE => Deutsch, ...
	 *
	 * @return array
	 */
	public function codeList($conditions = []) {
		$res = $this->find('all', ['group' => ['code'], 'conditions' => $conditions, 'fields' => ['code', 'name']]);
		$ret = [];
		foreach ($res as $language) {
			$ret[$language[$this->alias]['code']] = $language[$this->alias]['name'];
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
		$this->HtmlDom = new HtmlDomLib();
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
				$languageArray[$key] = trim(str_replace(["&lt;", "&gt;", '&amp;', '&#039;', '&quot;', '&nbsp;'], ["<", ">", '&', '\'', '"', ' '], $val));
			}

			$languages = [];
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
				$languages[$iso3] = ['iso3' => $iso3, 'iso2' => $iso2, 'ori_name' => $languageArray[$i + 2]];
			}

			$heading = ['ISO 639-2 Code (alpha3)', 'ISO 639-1 Code (alpha2)', 'English name of Language'];
			break;
		}

		return ['heading' => $heading, 'values' => $languages];
	}

	/**
	 * Language::directions()
	 *
	 * @param mixed $value
	 * @return mixed
	 */
	public static function directions($value = null) {
		$options = [
			self::DIR_LTR => 'LTR',
			self::DIR_RTL => 'RTL'
		];
		return parent::enum($value, $options);
	}

	const DIR_LTR = 0;

	const DIR_RTL = 1;

	const STATUS_ACTIVE = 1;

	const STATUS_INACTIVE = 0;

}
