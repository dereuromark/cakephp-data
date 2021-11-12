<?php

namespace Data\Controller\Admin;

use Cake\Core\Plugin;
use Data\Controller\DataAppController;
use Data\Model\Entity\Language;
use RuntimeException;

/**
 * @property \Data\Model\Table\LanguagesTable $Languages
 * @method \Data\Model\Entity\Language[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 * @property \Search\Controller\Component\SearchComponent $Search
 */
class LanguagesController extends DataAppController {

	/**
	 * @var array
	 */
	public $paginate = ['order' => ['Languages.name' => 'ASC']];

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		if (Plugin::isLoaded('Search')) {
			$this->loadComponent('Search.Search', [
				'actions' => ['index'],
			]);
		}
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function index() {
		if (Plugin::isLoaded('Search')) {
			$query = $this->Languages->find('search', ['search' => $this->request->getQuery()]);
			$languages = $this->paginate($query)->toArray();
		} else {
			$languages = $this->paginate()->toArray();
		}

		$language = $this->Languages->newEmptyEntity();

		$this->set(compact('languages', 'language'));
	}

	/**
	 * @param int|null $id
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function view($id = null) {
		$language = $this->Languages->get($id);

		$this->set(compact('language'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function add() {
		$language = $this->Languages->newEmptyEntity();

		if ($this->Common->isPosted()) {
			$language = $this->Languages->patchEntity($language, $this->request->getData());
			if ($this->Languages->save($language)) {
				$var = $language['name'];
				$this->Flash->success(__('record add {0} saved', h($var)));

				return $this->redirect(['action' => 'index']);
			}

			$this->Flash->error(__('formContainsErrors'));
		}

		$this->set(compact('language'));
	}

	/**
	 * @param int|null $id
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function edit($id = null) {
		$language = $this->Languages->get($id);

		if ($this->Common->isPosted()) {
			$language = $this->Languages->patchEntity($language, $this->request->getData());

			if ($this->Languages->save($language)) {
				$var = $language->name;
				$this->Flash->success(__('record edit {0} saved', h($var)));

				return $this->redirect(['action' => 'index']);
			}

			$this->Flash->error(__('formContainsErrors'));
		}

		$this->set(compact('language'));
	}

	/**
	 * @param int|null $id
	 * @throws \RuntimeException
	 * @return \Cake\Http\Response|null
	 */
	public function delete($id = null) {
		$this->request->allowMethod('post');

		$language = $this->Languages->get($id);
		if ($this->Languages->delete($language)) {
			$var = $language['name'];
			$this->Flash->success(__('record del {0} done', h($var)));

			return $this->redirect(['action' => 'index']);
		}

		throw new RuntimeException();
	}

	/**
	 * Should only be done once at the very beginning
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function importFromCore() {
		if ($this->request->getQuery('reset')) {
			$this->Languages->truncate();
		}

		//$languages = $this->Languages->iso3ToIso2();
		$languages = $this->Languages->catalog();
		$count = 0;
		$errors = [];
		foreach ($languages as $language) {
			$code = $this->Languages->iso3ToIso2($language['localeFallback']) ?: '';
			$data = [
				'name' => $language,
				'ori_name' => $language,
				'code' => $code,
				'locale' => $language['locale'],
				'locale_fallback' => $language['localeFallback'],
				'direction' => $language['direction'],
			];
			$language = $this->Languages->newEntity($data);
			if ($this->Languages->save($language)) {
				$count++;
			} else {
				$errors[] = ['data' => $language, 'errors' => $language->getErrors()];
			}
		}

		$this->Flash->success($count . ' of ' . count($languages) . ' ' . __('languages added'));

		$errorMessage = [];
		foreach ($errors as $error) {
			$errorMessage[] = $error['data'] . ' (' . json_encode($error['errors']) . ')';
		}
		$this->Flash->warning(__('not added') . ' ' . implode(', ', $errorMessage));

		return $this->redirect(['action' => 'index']);
	}

	/**
	 * http://www.loc.gov/standards/iso639-2/php/code_list.php
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function compareToIsoList() {
		$isoList = $this->Languages->getOfficialIsoList();

		$languages = $this->Languages->find('all', []);

		$this->set(compact('isoList', 'languages'));
	}

	/**
	 * http://www.loc.gov/standards/iso639-2/php/code_list.php
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function compareIsoListToCore() {
		$isoList = $this->Languages->getOfficialIsoList();

		$languages = $this->Languages->catalog();
		$locales = [];
		foreach ($languages as $key => $value) {
			if (strlen($key) === 2) {
				$locales[$key] = $value;
				$locales[$key]['regional'] = [];

				continue;
			}
			if (strlen($key) === 1) {
				//$locales[$key] = $value;
				//$locales[$key]['deprecated'] = 1;
				continue;
			}
			$baseLocale = substr($key, 0, 2);
			if (!isset($locales[$baseLocale])) {
				$locales[$baseLocale] = ['missing_base' => 1];
			}
			$locales[$baseLocale]['regional'][] = $value;
		}

		$this->set(compact('isoList', 'languages', 'locales'));
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function setPrimaryLanguagesActive() {
		$languages = $this->Languages->getPrimaryLanguages('list')->toArray();
		$count = $this->Languages->updateAll(['status' => Language::STATUS_ACTIVE], ['id' => array_keys($languages)]);

		$this->Flash->success(__('{0} of {1} set active', $count, count($languages)));

		return $this->redirect(['action' => 'index']);
	}

	/* probs:

	Array
	(
	[0] => Array
		(
			[data] => Array
				(
					[language] => Greek
					[locale] => gre
					[localeFallback] => gre
					[charset] => utf-8
					[direction] => ltr
				)

			[errors] => Array
				(
					[locale] => valErrRecordNameExists
				)

		)

	[1] => Array
		(
			[data] => Array
				(
					[language] => Indonesian
					[locale] => ind
					[localeFallback] => ind
					[charset] => utf-8
					[direction] => ltr
				)

			[errors] => Array
				(
					[locale] => valErrRecordNameExists
				)

		)

	[2] => Array
		(
			[data] => Array
				(
					[language] => Dutch (Standard)
					[locale] => dut
					[localeFallback] => dut
					[charset] => utf-8
					[direction] => ltr
				)

			[errors] => Array
				(
					[locale] => valErrRecordNameExists
				)

		)

	[3] => Array
		(
			[data] => Array
				(
					[language] => Polish
					[locale] => pol
					[localeFallback] => pol
					[charset] => utf-8
					[direction] => ltr
				)

			[errors] => Array
				(
					[locale] => valErrRecordNameExists
				)

		)

	)

	*/

}
