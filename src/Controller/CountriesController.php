<?php
namespace Data\Controller;

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Event\Event;
use Cake\Filesystem\Folder;
use Data\Controller\DataAppController;

/**
 * @property \Data\Model\Table\CountriesTable $Countries
 */
class CountriesController extends DataAppController {

	/**
	 * @var array
	 */
	public $paginate = ['order' => ['Countries.sort' => 'DESC']];

	/**
	 * @param \Cake\Event\Event $event
	 * @return void
	 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		$specific = Configure::read('Country.image_path');
		if ($specific) {
			$this->imageFolder = WWW_ROOT . 'img' . DS . $specific . DS;
		} else {
			$this->imageFolder = Plugin::path('Data') . DS . 'webroot' . DS . 'img' . DS . 'country_flags' . DS;
		}

		if (isset($this->Auth)) {
			$this->Auth->allow('index');
			/*
			$this->Auth->actionMap = array_merge($this->Auth->actionMap, array(
				'admin_down' => 'edit',
				'admin_up' => 'edit'
			));
			*/
		}
	}

	/**
	 * @return void
	 */
	public function index() {
		$countries = $this->paginate();
		$this->set(compact('countries'));
	}

	protected function _icons() {
		$useCache = true;
		if (!empty($this->request->query['reset'])) {
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
			$iconNames[] = strtoupper(extractPathInfo($icon, 'filename'));
		}
		Cache::write('country_icon_names', $iconNames);

		return $iconNames;
	}

}
