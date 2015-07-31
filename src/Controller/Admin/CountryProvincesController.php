<?php
namespace Data\Controller\Admin;

use Data\Controller\DataAppController;
use Cake\Event\Event;

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
	public function updateSelect($id = null) {
		//$this->autoRender = false;
		if (!$this->request->is('post') || !$this->request->is('ajax')) {
			die(__('not a valid request'));
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
	 * CountryProvincesController::admin_update_coordinates()
	 *
	 * @param mixed $id
	 * @return void
	 */
	public function updateCoordinates($id = null) {
		set_time_limit(120);
		$res = $this->CountryProvince->updateCoordinates($id);
		if (!$res) {
			$this->Common->flashMessage(__('coordinates not updated'), 'error');
		} else {
			$this->Common->flashMessage(__('coordinates {0} updated', $res), 'success');
		}

		$this->autoRender = false;
		return $this->redirect(array('action' => 'index'));
	}

	/**
	 * CountryProvincesController::admin_index()
	 *
	 * @param mixed $cid
	 * @return void
	 */
	public function index($cid = null) {
		$cid = $this->_processCountry($cid);

		$countryProvinces = $this->paginate();
		$countries = $this->CountryProvince->Country->find('list');

		$this->set(compact('countryProvinces', 'countries'));
		$this->Common->loadHelper(array('Geo.GoogleMapV3'));
	}

	/**
	 * CountryProvincesController::admin_view()
	 *
	 * @param mixed $id
	 * @return void
	 */
	public function view($id = null) {
		if (empty($id)) {
			$this->Common->flashMessage(__('record invalid'), 'error');
			return $this->redirect(array('action' => 'index'));
		}
		$countryProvince = $this->CountryProvince->get($id);
		if (empty($countryProvince)) {
			$this->Common->flashMessage(__('record not exists'), 'error');
			return $this->redirect(array('action' => 'index'));
		}
		$this->set(compact('countryProvince'));
	}

	/**
	 * CountryProvincesController::admin_add()
	 *
	 * @return void
	 */
	public function add() {
		if ($this->Common->isPosted()) {
			$this->CountryProvince->create();
			if ($this->CountryProvince->save($this->request->data)) {
				$id = $this->CountryProvince->id;
				$name = $this->request->data['CountryProvince']['name'];
				$this->Common->flashMessage(__('record add {0} saved', h($name)), 'success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Common->flashMessage(__('record add not saved'), 'error');
			}
		} else {
			$cid = $this->Session->read('CountryProvince.cid');
			if (!empty($cid)) {
				$this->request->data['CountryProvince']['country_id'] = $cid;
			}
		}
		$countries = $this->CountryProvince->Country->find('list');
		$this->set(compact('countries'));
	}

	/**
	 * CountryProvincesController::admin_edit()
	 *
	 * @param mixed $id
	 * @return void
	 */
	public function edit($id = null) {
		if (empty($id)) {
			$this->Common->flashMessage(__('record invalid'), 'error');
			return $this->redirect(array('action' => 'index'));
		}
		if ($this->Common->isPosted()) {
			if ($this->CountryProvince->save($this->request->data)) {
				$name = $this->request->data['CountryProvince']['name'];
				$this->Common->flashMessage(__('record edit {0} saved', h($name)), 'success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Common->flashMessage(__('record edit not saved'), 'error');
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->CountryProvince->get($id);
			if (empty($this->request->data)) { # still no record found
				$this->Common->flashMessage(__('record not exists'), 'error');
				return $this->redirect(array('action' => 'index'));
			}
		}
		$countries = $this->CountryProvince->Country->find('list');
		$this->set(compact('countries'));
	}

	/**
	 * CountryProvincesController::admin_delete()
	 *
	 * @param mixed $id
	 * @return void
	 */
	public function delete($id = null) {
		if (!$this->Common->isPosted()) {
			throw new MethodNotAllowedException();
		}
		if (empty($id)) {
			$this->Common->flashMessage(__('record invalid'), 'error');
			return $this->redirect(array('action' => 'index'));
		}
		$res = $this->CountryProvince->find('first', array('fields' => array('id', 'name'), 'conditions' => array('CountryProvince.id' => $id)));
		if (empty($res)) {
			$this->Common->flashMessage(__('record del not exists'), 'error');
			return $this->redirect(array('action' => 'index'));
		}

		$name = $res['CountryProvince']['name'];
		if ($this->CountryProvince->delete($id)) {
			$this->Common->flashMessage(__('record del {0} done', h($name)), 'success');
			return $this->redirect(array('action' => 'index'));
		} else {
			$this->Common->flashMessage(__('record del {0} not done exception', $name), 'error');
			return $this->redirect(array('action' => 'index'));
		}
	}

	/****************************************************************************************
	* protected/internal functions
	****************************************************************************************/

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
			$this->paginate = Set::merge($this->paginate, array('conditions' => array('country_id' => $cid)));
			$this->request->data['Filter']['id'] = $cid;
		}
	}

}
