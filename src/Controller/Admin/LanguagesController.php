<?php
namespace Data\Controller\Admin;

use Cake\Core\Plugin;
use Data\Controller\DataAppController;
use Data\Model\Entity\Language;

/**
 * @property \Data\Model\Table\LanguagesTable $Languages
 */
class LanguagesController extends DataAppController {

	/**
	 * @var array
	 */
	public $paginate = ['order' => ['Languages.name' => 'ASC']];

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function initialize() {
		parent::initialize();

		if (Plugin::loaded('Search')) {
			$this->loadComponent('Search.Prg', [
				'actions' => ['index']
			]);
		}
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function index() {
		if (Plugin::loaded('Search')) {
			$query = $this->Languages->find('search', ['search' => $this->request->query]);
			$languages = $this->paginate($query);
		} else {
			$languages = $this->paginate();
		}

		$language = $this->Languages->newEntity();

		$this->set(compact('languages', 'language'));
	}

	public function view($id = null) {
		if (empty($id) || !($language = $this->Languages->find('first', ['conditions' => ['Languages.id' => $id]]))) {
			$this->Flash->error(__('invalid record'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$this->set(compact('language'));
	}

	public function add() {
		$language = $this->Languages->newEntity();

		if ($this->Common->isPosted()) {
			//$this->Languages->create();
			$language = $this->Languages->patchEntity($language, $this->request->getData());
			if ($this->Languages->save($language)) {
				$var = $this->request->data['name'];
				$this->Flash->success(__('record add {0} saved', h($var)));
				return $this->redirect(['action' => 'index']);
			}

			$this->Flash->error(__('formContainsErrors'));
		}

		$this->set(compact('language'));
	}

	public function edit($id = null) {
		if (empty($id) || !($language = $this->Languages->find('first', ['conditions' => ['Languages.id' => $id]]))) {
			$this->Flash->error(__('invalid record'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		if ($this->Common->isPosted()) {
			if ($this->Languages->save($this->request->data)) {
				$var = $this->request->data['name'];
				$this->Flash->success(__('record edit {0} saved', h($var)));
				return $this->redirect(['action' => 'index']);
			}

			$this->Flash->error(__('formContainsErrors'));
		}

		$this->set(compact('language'));
	}

	public function delete($id = null) {
		$this->request->allowMethod('post');

		if (empty($id) || !($language = $this->Languages->find('first', ['conditions' => ['Languages.id' => $id], 'fields' => ['id', 'name']]))) {
			$this->Flash->error(__('invalid record'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		if ($this->Languages->delete($language)) {
			$var = $language['name'];
			$this->Flash->success(__('record del {0} done', h($var)));
			return $this->redirect(['action' => 'index']);
		}
		$this->Flash->error(__('record del {0} not done exception', h($var)));
		return $this->Common->autoRedirect(['action' => 'index']);
	}

	/**
	 * Should only be done once at the very beginning
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function importFromCore() {
		if (!empty($this->request->query['reset'])) {
			$this->Languages->truncate();
		}
		//$languages = $this->Languages->iso3ToIso2();
		$languages = $this->Languages->catalog();
		$count = 0;
		$errors = [];
		foreach ($languages as $language) {
			if (!($code = $this->Languages->iso3ToIso2($language['localeFallback']))) {
				$code = '';
			}
			$data = [
				'name' => $language,
				'ori_name' => $language,
				'code' => $code,
				'locale' => $language['locale'],
				'locale_fallback' => $language['localeFallback'],
				'direction' => $language['direction']
			];
			$language = $this->Languages->newEntity($data);
			if ($this->Languages->save($language)) {
				$count++;
			} else {
				$errors[] = ['data' => $language, 'errors' => $this->Languages->validationErrors];
			}
		}

		$this->Flash->success($count . ' of ' . count($languages) . ' ' . __('languages added'));

		$errorMessage = [];
		foreach ($errors as $error) {
			$errorMessage[] = $error['data'] . ' (' . returns($error['errors']) . ')';
		}
		$this->Flash->warning(__('not added') . ' ' . implode(', ', $errorMessage));
		return $this->redirect(['action' => 'index']);
	}

	/**
	 * http://www.loc.gov/standards/iso639-2/php/code_list.php
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function compareToIsoList() {
		$isoList = $this->Languages->getOfficialIsoList();

		$languages = $this->Languages->find('all', []);

		$this->set(compact('isoList', 'languages'));
	}

	/**
	 * http://www.loc.gov/standards/iso639-2/php/code_list.php
	 *
	 * @return \Cake\Http\Response|null
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
		$languages = $this->Languages->getPrimaryLanguages('list');
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
