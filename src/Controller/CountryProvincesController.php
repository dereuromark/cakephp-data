<?php
namespace Data\Controller;

use Data\Controller\DataAppController;
use Cake\Event\Event;
use Cake\Utility\Hash;
use Cake\Core\Plugin;

class CountryProvincesController extends DataAppController {

	public $paginate = array('order' => array('CountryProvince.modified' => 'DESC'));

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		if (isset($this->Auth)) {
			$this->Auth->allow('index', 'update_select');
		}
	}

	/**
	 * Ajax function
	 * new: optional true/false for default field label
	 *
	 * @return void
	 */
	public function update_select($id = null) {
		//$this->autoRender = false;
		if (!$this->request->is('post') || !$this->request->is('ajax')) {
			throw new \Exception(__('not a valid request'));
		}
		$this->layout = 'ajax';
		$countryProvinces = $this->CountryProvince->getListByCountry($id);
		$defaultFieldLabel = 'pleaseSelect';
		if ($this->request->query('optional')) {
			$defaultFieldLabel = 'doesNotMatter';
		}

		$this->set(compact('countryProvinces', 'defaultFieldLabel'));
	}

	/**
	 * CountryProvincesController::index()
	 *
	 * @param mixed $cid
	 * @return void
	 */
	public function index($cid = null) {
		$this->paginate['order'] = array('CountryProvinces.name' => 'ASC');
		//$this->paginate['conditions'] = array('Country.status' => 1);

		$cid = $this->_processCountry($cid);

		if (Plugin::loaded('Search')) {
			$this->CountryProvinces->addBehavior('Search.Searchable');
			$this->Common->loadComponent('Search.Prg');

			$this->Prg->commonProcess();
			$countryProvinces = $this->paginate($this->CountryProvinces->find('searchable', $this->Prg->parsedParams()));
		} else {
			$countryProvinces = $this->paginate();
		}

		$countries = $this->CountryProvinces->Countries->active('list');
		$this->set(compact('countryProvinces', 'countries'));
	}

	/**
	 * For both index views
	 *
	 * @return void
	 */
	protected function _processCountry($cid) {
		$saveCid = true;
		if (empty($cid)) {
			$saveCid = false;
			$cid = $this->Session->read('CountryProvince.cid');
		}
		if (!empty($cid) && $cid < 0) {
			$this->Session->delete('CountryProvince.cid');
			$cid = null;
		} elseif (!empty($cid) && $saveCid) {
			$this->Session->write('CountryProvince.cid', $cid);
		}

		if (!empty($cid)) {
			$this->paginate = Hash::merge($this->paginate, array('conditions' => array('country_id' => $cid)));
			$this->request->data['id'] = $cid;
		}
	}

}
