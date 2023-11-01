<?php

namespace Data\Controller\Admin;

use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Event\EventInterface;
use Cake\Utility\Hash;
use Cake\View\View;
use Data\Controller\DataAppController;
use Data\Sync\Countries;
use Data\View\Helper\DataHelper;
use Shim\Datasource\Paging\NumericPaginator;
use Shim\Filesystem\Folder;

/**
 * @property \Data\Model\Table\CountriesTable $Countries
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\Country> paginate($object = null, array $settings = [])
 * @property \Search\Controller\Component\SearchComponent $Search
 */
class CountriesController extends DataAppController {

	/**
	 * @var array<string, mixed>
	 */
	protected array $paginate = [
		'order' => ['Countries.sort' => 'DESC'],
		'className' => NumericPaginator::class,
	];

	/**
	 * @var string|null
	 */
	public $imageFolder;

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
	 * @param \Cake\Event\EventInterface $event
	 * @return \Cake\Http\Response|null|void
	 */
	public function beforeFilter(EventInterface $event) {
		parent::beforeFilter($event);

		$specific = Configure::read('Country.image_path');
		if ($specific) {
			$this->imageFolder = WWW_ROOT . 'img' . DS . $specific . DS;
		} else {
			$this->imageFolder = Plugin::path('Data') . DS . 'webroot' . DS . 'img' . DS . 'country_flags' . DS;
		}
	}

	/**
	 * Check for missing or unused country flag icons
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function icons() {
		$icons = $this->_icons();

		$countries = $this->Countries->find('all', ['fields' => ['id', 'name', 'iso2', 'iso3']])->toArray();
		$countriesWithoutIcons = [];

		$iconFontClass = (bool)Configure::read('Country.iconFontClass');
		if (!$iconFontClass) {
			foreach ($countries as $country) {
				$icon = strtolower($country['iso2']);
				if (!isset($icons[$icon])) {
					$countriesWithoutIcons[] = $country;
				}
			}
		}

		$this->set(compact('icons', 'countries', 'countriesWithoutIcons', 'iconFontClass'));
	}

	/**
	 * @return array<string>
	 */
	protected function _icons(): array {
		[$wwwPath, $path] = (new DataHelper(new View()))->getCountryIconPaths();

		$content = (new Folder($path))->read();
		$files = $content[1];

		$icons = [];
		foreach ($files as $file) {
			$name = pathinfo($file, PATHINFO_FILENAME);
			$icons[$name] = $file;
		}

		return $icons;
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function sync() {
		$storedCountries = $this->Countries->find()->all()->toArray();
		$storedCountries = Hash::combine($storedCountries, '{n}.iso3', '{n}');

		$fields = $this->request->getQuery('fields') ? explode(',', $this->request->getQuery('fields')) : [];
		$diff = (new Countries())->diff($storedCountries, $fields);

		if ($this->request->is('post')) {
			$data = (array)$this->request->getData('Form');
			$count = 0;
			foreach ($data as $action => $rows) {
				foreach ($rows as $key => $row) {
					if (empty($row['execute']) || empty($diff[$action][$key])) {
						continue;
					}

					$element = $diff[$action][$key];

					switch ($action) {
						case 'add':
							$entity = $this->Countries->newEntity($element['data']);
							$this->Countries->saveOrFail($entity);

							break;
						case 'edit':
							/** @var \Data\Model\Entity\Country $entity */
							$entity = $element['entity'];
							$entity = $this->Countries->patchEntity($entity, $element['fields']);
							$this->Countries->saveOrFail($entity);

							break;
						case 'delete':
							/** @var \Data\Model\Entity\Country $entity */
							$entity = $element['entity'];
							$this->Countries->deleteOrFail($entity);

							break;
					}

					$count++;
				}
			}

			$this->Flash->success($count . ' countries updated.');

			return $this->redirect(['action' => 'sync']);
		}

		$this->set(compact('diff', 'storedCountries'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function index() {
		if (Plugin::isLoaded('Search')) {
			$query = $this->Countries->find('search', ['search' => $this->request->getQuery()]);
			$countries = $this->paginate($query)->toArray();
		} else {
			$countries = $this->paginate();
		}

		$this->set(compact('countries'));

		$this->viewBuilder()->setHelpers(['Geo.GoogleMap']);
	}

	/**
	 * @param int|null $id
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function view($id = null) {
		$contain = [];
		if (Configure::read('Data.Country.Timezone') !== false) {
			$contain[] = 'Timezones';
		}
		$country = $this->Countries->get($id, ['contain' => $contain]);

		$this->set(compact('country'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function add() {
		$country = $this->Countries->newEmptyEntity();

		if ($this->Common->isPosted()) {
			$country = $this->Countries->patchEntity($country, $this->request->getData());
			if ($this->Countries->save($country)) {
				$id = $country->id;
				//$name = $this->request->data['name'];
				$this->Flash->success(__('record add {0} saved', $id));

				return $this->redirect(['action' => 'index']);
			}

			$this->Flash->error(__('record add not saved'));
		}

		$this->set(compact('country'));
	}

	/**
	 * @param int|null $id
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function edit($id = null) {
		$country = $this->Countries->get($id);

		if ($this->Common->isPosted()) {
			$country = $this->Countries->patchEntity($country, $this->request->getData());
			if ($this->Countries->save($country)) {
				$name = $country->name;
				$this->Flash->success(__('record edit {0} saved', h($name)));

				return $this->redirect(['action' => 'index']);
			}

			$this->Flash->error(__('record edit not saved'));
		}

		$continents = [];
		if (Configure::read('Data.Country.Continent') !== false) {
			$continents = $this->Countries->Continents->find('treeList', ['spacer' => '» '])->toArray();
		}
		$this->set(compact('country', 'continents'));
	}

	/**
	 * @param int|null $id
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function delete($id = null) {
		$country = $this->Countries->get($id);

		if ($this->Countries->delete($country)) {
			$this->Flash->success(__('record del {0} done', $id));

			return $this->redirect(['action' => 'index']);
		}

		$this->Flash->error(__('record del {0} not done exception', $id));

		return $this->redirect(['action' => 'index']);
	}

	/*
	public function up($id = null) {
		if (empty($id) || !($navigation = $this->Countries->find('first', ['conditions' => ['Countries.id' => $id]]))) {
			$this->Flash->error(__('invalid record'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$this->Countries->moveDown($id, 1);
		return $this->redirect(['action' => 'index']);
	}

	public function down($id = null) {
		if (empty($id) || !($navigation = $this->Countries->find('first', ['conditions' => ['Countries.id' => $id]]))) {
			$this->Flash->error(__('invalid record'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$this->Countries->moveUp($id, 1);
		return $this->redirect(['action' => 'index']);
	}
	*/

	/**
	 * Validate
	 * - code
	 * - zip length/regexp ?
	 * - EU ?
	 * - lat/lng available and correct ?
	 * - iso codes
	 * - address format?
	 * - timezones and summertime
	 *
	 * resources:
	 * - http://www.iso.org/iso/list-en1-semic-3.txt
	 * - http://www.worldtimeserver.com/country.html - http://api.geonames.org/timezone?lat=47.01&lng=10.2&username=demo
	 * - http://www.geonames.org/countries/ - http://api.geonames.org/postalCodeCountryInfo?username=demo
	 * - http://www.pixelenvision.com/1708/zip-postal-code-validation-regex-php-code-for-12-countries/
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function validate() {
		$countries = $this->Countries->find('all');

		//TODO.
		$this->set(compact('countries'));
	}

}
