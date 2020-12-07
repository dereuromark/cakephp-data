<?php

namespace Data\Controller;

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Event\EventInterface;
use Cake\Filesystem\Folder;

/**
 * @property \Data\Model\Table\CountriesTable $Countries
 * @method \Data\Model\Entity\Country[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 * @property \Search\Controller\Component\SearchComponent $Search
 */
class CountriesController extends DataAppController {

	/**
	 * @var array
	 */
	public $paginate = ['order' => ['Countries.sort' => 'DESC']];

	/**
	 * @var string
	 */
	protected $imageFolder;

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
	 * @return \Cake\Http\Response|null|void
	 */
	public function index() {
		$countries = $this->paginate();
		$this->set(compact('countries'));
	}

	/**
	 * @return string[]
	 */
	protected function _icons() {
		$useCache = true;
		if ($this->request->getQuery('reset')) {
			$useCache = false;
		}

		if ($useCache && ($iconNames = Cache::read('country_icon_names')) !== false) {
			$this->Flash->info('Cache Used');

			return $iconNames;
		}

		$handle = new Folder($this->imageFolder);
		$icons = $handle->read(true, true);

		$iconNames = [];
		foreach ($icons[1] as $icon) { # only use files (not folders)
			$iconNames[] = strtoupper(pathinfo($icon, PATHINFO_FILENAME));
		}
		Cache::write('country_icon_names', $iconNames);

		return $iconNames;
	}

}
