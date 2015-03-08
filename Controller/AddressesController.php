<?php
App::uses('DataAppController', 'Data.Controller');

class AddressesController extends DataAppController {

	public $paginate = [];

	public function beforeFilter() {
		parent::beforeFilter();
	}

/****************************************************************************************
 * USER functions
 ****************************************************************************************/

	/*
	public function index() {
		$this->Address->recursive = 0;
		$addresses = $this->paginate();
		$this->set(compact('addresses'));
	}

	public function view($id = null) {
		$this->Address->recursive = 0;
		if (empty($id) || !($address = $this->Address->find('first', array('conditions'=>array('Address.id'=>$id))))) {
			$this->Flash->message(__('invalid record'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$this->set(compact('address'));
	}

	public function add() {
		if ($this->Common->isPosted()) {
			$this->Address->create();
			if ($this->Address->save($this->request->data)) {
				$var = $this->request->data['Address']['formatted_address'];
				$this->Flash->message(__('record add %s saved', h($var)), 'success');
				return $this->redirect(array('action' => 'index'));
			}
			$this->Flash->message(__('formContainsErrors'), 'error');
			}
		}
		$countries = $this->Address->Country->find('list');
		$countryProvinces = array();
		if (Configure::read('Address.CountryProvince')) {
			$countryProvinces = $this->Address->CountryProvince->find('list');
		}
		$this->set(compact('countries', 'countryProvinces'));
	}

	public function edit($id = null) {
		if (empty($id) || !($address = $this->Address->find('first', array('conditions'=>array('Address.id'=>$id))))) {
			$this->Flash->message(__('invalid record'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		if ($this->Common->isPosted()) {
			if ($this->Address->save($this->request->data)) {
				$var = $this->request->data['Address']['formatted_address'];
				$this->Flash->message(__('record edit %s saved', h($var)), 'success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->message(__('formContainsErrors'), 'error');
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $address;
		}
		$countries = $this->Address->Country->find('list');
		$countryProvinces = array();
		if (Configure::read('Address.CountryProvince')) {
			$countryProvinces = $this->Address->CountryProvince->find('list');
		}
		$this->set(compact('countries', 'countryProvinces'));
	}

	public function delete($id = null) {
		$this->request->allowMethod('post');
		if (empty($id) || !($address = $this->Address->find('first', array('conditions'=>array('Address.id'=>$id), 'fields'=>array('id', 'formatted_address'))))) {
			$this->Flash->message(__('invalid record'), 'error');
			return $this->Common->autoRedirect(array('action'=>'index'));
		}
		$var = $address['Address']['formatted_address'];

		if ($this->Address->delete($id)) {
			$this->Flash->message(__('record del %s done', h($var)), 'success');
			return $this->redirect(array('action' => 'index'));
		}
		$this->Flash->message(__('record del %s not done exception', h($var)), 'error');
		return $this->Common->autoRedirect(array('action' => 'index'));
	}
	*/

/****************************************************************************************
 * ADMIN functions
 ****************************************************************************************/

	public function admin_index() {
		$this->Address->recursive = 0;
		$addresses = $this->paginate();
		$this->set(compact('addresses'));
		$this->Common->loadHelper('Tools.GoogleMapV3');
	}

	public function admin_view($id = null) {
		$this->Address->recursive = 0;
		if (empty($id) || !($address = $this->Address->find('first', ['conditions' => ['Address.id' => $id]]))) {
			$this->Flash->message(__('invalid record'), 'error');
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$this->set(compact('address'));
		$this->Common->loadHelper('Tools.GoogleMapV3');
	}

	public function admin_add() {
		if ($this->Common->isPosted()) {
			$this->Address->create();
			if ($this->Address->save($this->request->data)) {
				$var = $this->request->data['Address']['formatted_address'];
				$this->Flash->message(__('record add %s saved', h($var)), 'success');
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->message(__('formContainsErrors'), 'error');

		} else {
			# TODO: geolocate via IP? only for frontend
			$options = ['Country.iso2' => 'DE'];
			$this->request->data['Address']['country_id'] = $this->Address->Country->field('id', $options);
		}

		$countries = $this->Address->Country->find('list');
		$countryProvinces = [];
		if (Configure::read('Address.CountryProvince')) {
			$countryProvinces = $this->Address->CountryProvince->find('list');
		}

		$this->set(compact('countries', 'countryProvinces'));
	}

	public function admin_edit($id = null) {
		if (empty($id) || !($address = $this->Address->find('first', ['conditions' => ['Address.id' => $id]]))) {
			$this->Flash->message(__('invalid record'), 'error');
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		if ($this->Common->isPosted()) {
			if ($this->Address->save($this->request->data)) {
				$var = $this->request->data['Address']['formatted_address'];
				$this->Flash->message(__('record edit %s saved', h($var)), 'success');
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->message(__('formContainsErrors'), 'error');

		}
		if (empty($this->request->data)) {
			$this->request->data = $address;
			$belongsTo = ['' => ' - keine Auswahl - '];
			foreach ($this->Address->belongsTo as $b => $content) {
				if ($b === 'Country') {
					continue;
				}
				$belongsTo[$b] = $b;
			}
			if (!empty($belongsTo)) {
				$this->set('models', $belongsTo);
			}
		}
		$countries = $this->Address->Country->find('list');
		$countryProvinces = [];
		if (Configure::read('Address.CountryProvince')) {
			$countryProvinces = $this->Address->CountryProvince->find('list');
		}

		$this->set(compact('countries', 'countryProvinces'));
	}

	public function admin_delete($id = null) {
		$this->request->allowMethod('post');
		if (empty($id) || !($address = $this->Address->find('first', ['conditions' => ['Address.id' => $id], 'fields' => ['id', 'formatted_address']]))) {
			$this->Flash->message(__('invalid record'), 'error');
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$var = $address['Address']['formatted_address'];

		if ($this->Address->delete($id)) {
			$this->Flash->message(__('record del %s done', h($var)), 'success');
			return $this->redirect(['action' => 'index']);
		}
		$this->Flash->message(__('record del %s not done exception', h($var)), 'error');
		return $this->Common->autoRedirect(['action' => 'index']);
	}

	public function admin_mark_as_used($id = null) {
		if (empty($id) || !($address = $this->Address->find('first', ['conditions' => ['Address.id' => $id], 'fields' => ['id', 'formatted_address']]))) {
			$this->Flash->message(__('invalid record'), 'error');
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$this->Address->touch($id);
		$var = $address['Address']['formatted_address'];
		$this->Flash->message(__('Address \'%s\' marked as last used', h($var)), 'success');
		return $this->Common->autoRedirect(['action' => 'index']);
	}

/****************************************************************************************
 * protected/interal functions
 ****************************************************************************************/

/****************************************************************************************
 * deprecated/test functions
 ****************************************************************************************/

}
