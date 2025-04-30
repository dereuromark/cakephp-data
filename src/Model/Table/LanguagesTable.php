<?php

namespace Data\Model\Table;

use ArrayObject;
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Event\EventInterface;
use Data\HtmlDom\HtmlDom;
use Data\Model\Entity\Language;
use Data\Utility\L10n;
use Tools\Model\Table\Table;

/**
 * Languages and their locales
 * for details see
 * http://www.loc.gov/standards/iso639-2/php/code_list.php
 *
 * @mixin \Search\Model\Behavior\SearchBehavior
 * @method \Data\Model\Entity\Language get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \Data\Model\Entity\Language newEntity(array $data, array $options = [])
 * @method array<\Data\Model\Entity\Language> newEntities(array $data, array $options = [])
 * @method \Data\Model\Entity\Language|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \Data\Model\Entity\Language patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\Data\Model\Entity\Language> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Data\Model\Entity\Language findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \Data\Model\Entity\Language saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \Data\Model\Entity\Language newEmptyEntity()
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\Language>|false saveMany(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\Language> saveManyOrFail(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\Language>|false deleteMany(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\Language> deleteManyOrFail(iterable $entities, array $options = [])
 */
class LanguagesTable extends Table {

	/**
	 * @var array<int|string, mixed>
	 */
	protected array $order = ['name' => 'ASC'];

	/**
	 * @var \Data\Utility\L10n|null
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
	public function initialize(array $config): void {
		parent::initialize($config);

		if (!Plugin::isLoaded('Search')) {
			return;
		}

		$this->addBehavior('Search.Search');
		$this->searchManager()
			->value('dir', ['fields' => 'direction'])
			->like('search', ['fields' => ['name', 'ori_name', 'code', 'locale', 'locale_fallback']]);
	}

	/**
	 * @param \Cake\Event\EventInterface $event
	 * @param \ArrayObject $data
	 * @param \ArrayObject $options
	 * @return void
	 */
	public function beforeMarshal(EventInterface $event, ArrayObject $data, ArrayObject $options) {
		$dir = Configure::read('Data.Language.dir', 'lower'); // lower or upper casing
		if ($dir === 'upper') {
			$method = 'mb_strtoupper';
		} else {
			$method = 'mb_strtolower';
		}

		if (isset($data['code'])) {
			$data['code'] = $method($data['code']);
		}
		if (isset($data['iso2'])) {
			$data['iso2'] = $method($data['iso2']);
		}
		if (isset($data['iso3'])) {
			$data['iso3'] = $method($data['iso3']);
		}
		if (isset($data['locale'])) {
			if (strpos($data['locale'], '_') !== false) {
				$pieces = explode('_', $data['locale'], 2);
				$data['locale'] = mb_strtolower($pieces[0]) . '_' . mb_strtoupper($pieces[1]);
			} else {
				$data['locale'] = mb_strtolower($data['locale']);
			}
		}
		if (isset($data['locale_fallback'])) {
			if (strpos($data['locale_fallback'], '_') !== false) {
				$pieces = explode('_', $data['locale_fallback'], 2);
				$data['locale_fallback'] = mb_strtolower($pieces[0]) . '_' . mb_strtoupper($pieces[1]);
			} else {
				$data['locale_fallback'] = mb_strtolower($data['locale_fallback']);
			}
		}
	}

	/**
	 * For language switch etc
	 *
	 * @param string $type
	 * @return \Cake\ORM\Query\SelectQuery
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
	 * @return \Cake\ORM\Query\SelectQuery
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
		$res = $this->find('all', ...['conditions' => $conditions, 'fields' => ['id', 'name']]);
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
		$res = $this->find('all', ...['conditions' => $conditions, 'fields' => ['code', 'name']]);
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
	 * @return array<string, mixed>|string|null Lang: iso2
	 */
	public function iso3ToIso2($iso3 = null) {
		if (!isset($this->L10n)) {
			$this->L10n = new L10n();
		}
		/** @var array<string, mixed> $languages */
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
	public function catalog(?string $lang = null) {
		if (!isset($this->L10n)) {
			$this->L10n = new L10n();
		}

		return $this->L10n->catalog($lang) ?: null;
	}

	/**
	 * @return array Array 2d heading and values
	 */
	public function getOfficialIsoList() {
		$HtmlDom = new HtmlDom();
		$res = Cache::read('lov_gov_iso_list');
		if (!$res) {
			$res = (string)file_get_contents('http://www.loc.gov/standards/iso639-2/php/code_list.php');
			$res = $HtmlDom->domFromString($res);
			Cache::write('lov_gov_iso_list', $res);
		}

		/** @var array $elements */
		$elements = $res->find('table');
		$heading = $languages = [];

		foreach ($elements as $element) {
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
