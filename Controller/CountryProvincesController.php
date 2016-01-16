<?php
App::uses('DataAppController', 'Data.Controller');

class CountryProvincesController extends DataAppController {

	public $paginate = ['order' => ['CountryProvince.modified' => 'DESC']];

	public function beforeFilter() {
		parent::beforeFilter();

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
		if (!$this->Common->isPosted() || !$this->request->is('ajax')) {
			throw new MethodNotAllowedException(__('not a valid request'));
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
		$this->paginate['contain'] = ['Country'];
		$this->paginate['order'] = ['CountryProvince.name' => 'ASC'];
		$this->paginate['conditions'] = ['Country.status' => 1];

		$cid = $this->_processCountry($cid);

		$countryProvinces = $this->paginate();

		$countries = $this->CountryProvince->Country->active('list');
		$this->set(compact('countryProvinces', 'countries'));
	}

	/****************************************************************************************
	* ADMIN functions
	****************************************************************************************/

	/**
	 * CountryProvincesController::admin_update_coordinates()
	 *
	 * @param mixed $id
	 * @return void
	 */
	public function admin_update_coordinates($id = null) {
		set_time_limit(120);
		$res = $this->CountryProvince->updateCoordinates($id);
		if (!$res) {
			$this->Flash->error(__('coordinates not updated'));
		} else {
			$this->Flash->success(__('coordinates %s updated', $res));
		}

		$this->autoRender = false;
		return $this->redirect(['action' => 'index']);
	}

	/**
	 * CountryProvincesController::admin_index()
	 *
	 * @param mixed $cid
	 * @return void
	 */
	public function admin_index($cid = null) {
		$cid = $this->_processCountry($cid);

		$this->paginate['contain'] = ['Country'];
		$countryProvinces = $this->paginate();
		$countries = $this->CountryProvince->Country->find('list');

		$this->set(compact('countryProvinces', 'countries'));
		$this->Common->loadHelper(['Tools.GoogleMapV3']);
	}

	/**
	 * CountryProvincesController::admin_view()
	 *
	 * @param mixed $id
	 * @return void
	 */
	public function admin_view($id = null) {
		$countryProvince = $this->CountryProvince->get($id, ['contain' => ['Country']]);

		$this->set(compact('countryProvince'));
	}

	/**
	 * CountryProvincesController::admin_add()
	 *
	 * @return void
	 */
	public function admin_add() {
		if ($this->Common->isPosted()) {
			$this->CountryProvince->create();
			if ($this->CountryProvince->save($this->request->data)) {
				$id = $this->CountryProvince->id;
				$name = $this->request->data['CountryProvince']['name'];
				$this->Flash->success(__('record add %s saved', h($name)));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('record add not saved'));
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
	public function admin_edit($id = null) {
		if (empty($id)) {
			$this->Flash->error(__('record invalid'));
			return $this->redirect(['action' => 'index']);
		}
		if ($this->Common->isPosted()) {
			if ($this->CountryProvince->save($this->request->data)) {
				$name = $this->request->data['CountryProvince']['name'];
				$this->Flash->success(__('record edit %s saved', h($name)));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('record edit not saved'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->CountryProvince->record($id);
			if (empty($this->request->data)) { # still no record found
				$this->Flash->error(__('record not exists'));
				return $this->redirect(['action' => 'index']);
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
	public function admin_delete($id = null) {
		$this->request->allowMethod('post');
		if (empty($id)) {
			$this->Flash->error(__('record invalid'));
			return $this->redirect(['action' => 'index']);
		}
		$res = $this->CountryProvince->find('first', ['fields' => ['id', 'name'], 'conditions' => ['CountryProvince.id' => $id]]);
		if (empty($res)) {
			$this->Flash->error(__('record del not exists'));
			return $this->redirect(['action' => 'index']);
		}

		$name = $res['CountryProvince']['name'];
		if ($this->CountryProvince->delete($id)) {
			$this->Flash->success(__('record del %s done', h($name)));
			return $this->redirect(['action' => 'index']);
		} else {
			$this->Flash->error(__('record del %s not done exception', $name));
			return $this->redirect(['action' => 'index']);
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
			$this->paginate = Hash::merge($this->paginate, ['conditions' => ['country_id' => $cid]]);
			$this->request->data['Filter']['id'] = $cid;
		}
	}

}
