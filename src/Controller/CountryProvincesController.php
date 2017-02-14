<?php
namespace Data\Controller;

use Data\Controller\DataAppController;
use Cake\Event\Event;
use Cake\Utility\Hash;
use Cake\Core\Plugin;

class CountryProvincesController extends DataAppController {

	public $paginate = ['order' => ['CountryProvince.modified' => 'DESC']];

	/**
	 * @param Event $event
	 */
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
	public function updateSelect($id = null) {
		//$this->autoRender = false;
		if (!$this->request->is('post') || !$this->request->is('ajax')) {
			throw new \Exception(__('not a valid request'));
		}
		$this->viewBuilder()->layout('ajax');
		$countryProvinces = $this->CountryProvinces->getListByCountry($id);
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
		$this->paginate['contain'] = ['Countries'];
		$this->paginate['order'] = ['CountryProvinces.name' => 'ASC'];
		//$this->paginate['conditions'] = array('Country.status' => 1);

		$this->_processCountry($cid);

		$query = $this->CountryProvinces->find();
		$countryProvinces = $this->paginate($query);

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
			$cid = $this->request->session()->read('CountryProvince.cid');
		}
		if (!empty($cid) && $cid < 0) {
			$this->request->session()->delete('CountryProvince.cid');
			$cid = null;
		} elseif (!empty($cid) && $saveCid) {
			$this->request->session()->write('CountryProvince.cid', $cid);
		}

		if (!empty($cid)) {
			$this->paginate = Hash::merge($this->paginate, ['conditions' => ['country_id' => $cid]]);
			$this->request->data['id'] = $cid;
		}
	}

}
