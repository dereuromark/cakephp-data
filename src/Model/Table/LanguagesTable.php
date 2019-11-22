<?php
namespace Data\Model\Table;

use Cake\Cache\Cache;
use Cake\Core\Plugin;
use Data\Model\Entity\Language;
use Tools\HtmlDom\HtmlDom;
use Tools\Model\Table\Table;
use Tools\Utility\L10n;

/**
 * Languages and their locales
 * for details see
 * http://www.loc.gov/standards/iso639-2/php/code_list.php
 *
 * @mixin \Search\Model\Behavior\SearchBehavior
 * @method \Data\Model\Entity\Language get($primaryKey, $options = [])
 * @method \Data\Model\Entity\Language newEntity($data = null, array $options = [])
 * @method \Data\Model\Entity\Language[] newEntities(array $data, array $options = [])
 * @method \Data\Model\Entity\Language|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Data\Model\Entity\Language patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Data\Model\Entity\Language[] patchEntities($entities, array $data, array $options = [])
 * @method \Data\Model\Entity\Language findOrCreate($search, callable $callback = null, $options = [])
 * @method \Data\Model\Entity\Language|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 */
class LanguagesTable extends Table {

	/**
	 * @var array
	 */
	public $order = ['name' => 'ASC'];

	/**
	 * @var \Tools\Utility\L10n
	 */
	public $L10n;

	/**
	 * @var array
	 */
	public $validate = [
		'name' => [
			'notBlank' => [
				'rule' => ['notBlank'],
				'message' => 'valErrMandatoryField',
			],
		],
		'ori_name' => [
			'notBlank' => [
				'rule' => ['notBlank'],
				'message' => 'valErrMandatoryField',
			],
		],
		'code' => [
			/*
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'valErrMandatoryField',
			),
			*/
		],
		'locale' => [
			'notBlank' => [
				'rule' => ['notBlank'],
				'message' => 'valErrMandatoryField',
				'last' => true,
			],
			'isUnique' => [
				'rule' => ['isUnique'],
				'message' => 'valErrRecordNameExists',
				'provider' => 'table',
			],
		],
		'locale_fallback' => [
			'notBlank' => [
				'rule' => ['notBlank'],
				'message' => 'valErrMandatoryField',
				'last' => true,
			],
		],
		'status' => [
			'numeric' => [
				'rule' => ['numeric'],
				'message' => 'valErrMandatoryField',
			],
		],
	];

	/**
	 * @param array $config
	 * @return void
	 */
	public function initialize(array $config) {
		parent::initialize($config);

		if (!Plugin::isLoaded('Search')) {
			return;
		}

		$this->addBehavior('Search.Search');
		$this->searchManager()
			->value('dir', ['field' => 'direction'])
			->like('search', ['field' => ['name', 'ori_name', 'code', 'locale', 'locale_fallback']]);
	}

	/**
	 * For language switch etc
	 *
	 * @param string $type
	 * @return \Cake\ORM\Query
	 */
	public function getActive($type = 'all') {
		$options = [
			'conditions' => ['status' => Language::STATUS_ACTIVE],
		];
		return $this->find($type, $options);
	}

	/**
	 * @param string $type
	 * @param array $customOptions
	 * @return \Cake\ORM\Query
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
	 * @param array $conditions
	 * @return array
	 */
	public function getList($conditions = []) {
		$conditions += ['status' => 1];
		$res = $this->find('all', ['conditions' => $conditions, 'fields' => ['id', 'name']]);
		$ret = [];
		foreach ($res as $language) {
			$ret[$language['id']] = $language['name'];
		}
		return $ret;
	}

	/**
	 * DE => Deutsch, ...
	 *
	 * @param array $conditions
	 * @return array
	 */
	public function codeList($conditions = []) {
		$conditions += ['status' => 1];
		$res = $this->find('all', ['conditions' => $conditions, 'fields' => ['code', 'name']]);
		$ret = [];
		foreach ($res as $language) {
			$ret[$language['code']] = $language['name'];
		}
		return $ret;
	}

	/**
	 * Maps ISO 639-3 to I10n::__l10nCatalog (iso2?)
	 *
	 * @param string|null $iso3 Language
	 * @return string|array|null Lang: iso2
	 */
	public function iso3ToIso2($iso3 = null) {
		if (!isset($this->L10n)) {
			$this->L10n = new L10n();
		}
		$languages = $this->L10n->map();
		if ($iso3) {
			if (array_key_exists($iso3, $languages)) {
				return $languages[$iso3];
			}
			return null;
		}

		return $languages;
	}

	/**
	 * @param string|null $lang lang: iso2 or iso3
	 * @return array|null String if lang passed (or false on failure) - or complete array if null is passed
	 */
	public function catalog($lang = null) {
		if (!isset($this->L10n)) {
			$this->L10n = new L10n();
		}
		return $this->L10n->catalog($lang);
	}

	/**
	 * @return array Array 2d heading and values
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
			$languageArray = explode("\t" . "\t", $languageArray);
			array_shift($languageArray);
			$max = count($languageArray);

			$pieces = explode(' ', $languageArray[($max - 1)]);
			$languageArray[($max - 1)] = array_shift($pieces);
			foreach ($languageArray as $key => $val) {
				$languageArray[$key] = trim(str_replace(['&lt;', '&gt;', '&amp;', '&#039;', '&quot;', '&nbsp;'], ['<', '>', '&', '\'', '"', ' '], $val));
			}

			$languages = [];
			for ($i = 0; $i < $max; $i = $i + 4) {
				$iso3 = $languageArray[$i];
				if (isset($languages[$iso3])) {
					continue;
				}

				$iso2 = $languageArray[$i + 1];
				if (strpos($iso3, '(') !== false) {
					$iso3array = explode("\n", $iso3);
					foreach ($iso3array as $key => $val) {
						if (strpos($val, '(T)') === false) {
							continue;
						}
						$pieces = explode('(', $val);
						$iso3 = trim(array_shift($pieces));
					}
				}
				$languages[$iso3] = ['iso3' => $iso3, 'iso2' => $iso2, 'ori_name' => $languageArray[$i + 2]];
			}

			$heading = ['ISO 639-2 Code (alpha3)', 'ISO 639-1 Code (alpha2)', 'English name of Language'];
			break;
		}

		return ['heading' => $heading, 'values' => $languages];
	}

}
