<?php
namespace Data\Controller\Admin;

use Cake\Core\Configure;
use Cake\Network\Exception\MethodNotAllowedException;
use Data\Controller\DataAppController;
use Cake\Event\Event;

class AddressesController extends DataAppController {

	public $paginate = [];

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
	}

	public function index() {
		$addresses = $this->paginate();
		$this->set(compact('addresses'));
		$this->helpers[] = 'Geo.GoogleMap';
	}

	public function view($id = null) {
		if (empty($id) || !($address = $this->Address->find('first', ['conditions' => ['Address.id' => $id]]))) {
			$this->Flash->error(__('invalid record'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$this->set(compact('address'));
		$this->helpers[] = 'Geo.GoogleMap';
	}

	public function add() {
		if ($this->Common->isPosted()) {
			$this->Address->create();
			if ($this->Address->save($this->request->data)) {
				$var = $this->request->data['Address']['formatted_address'];
				$this->Flash->success(__('record add {0} saved', h($var)));
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('formContainsErrors'));

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

	public function edit($id = null) {
		if (empty($id) || !($address = $this->Address->find('first', ['conditions' => ['Address.id' => $id]]))) {
			$this->Flash->error(__('invalid record'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		if ($this->Common->isPosted()) {
			if ($this->Address->save($this->request->data)) {
				$var = $this->request->data['Address']['formatted_address'];
				$this->Flash->success(__('record edit {0} saved', h($var)));
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('formContainsErrors'));

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

	/**
	 * @param int|null $id
	 * @return \Cake\Network\Response|null
	 */
	public function delete($id = null) {
		if (!$this->Common->isPosted()) {
			throw new MethodNotAllowedException();
		}

		if (empty($id) || !($address = $this->Address->find('first', ['conditions' => ['Address.id' => $id], 'fields' => ['id', 'formatted_address']]))) {
			$this->Flash->error(__('invalid record'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$var = $address['Address']['formatted_address'];

		if ($this->Address->delete($id)) {
			$this->Flash->success(__('record del {0} done', h($var)));
			return $this->redirect(['action' => 'index']);
		}
		$this->Flash->error(__('record del {0} not done exception', h($var)));
		return $this->Common->autoRedirect(['action' => 'index']);
	}

	public function mark_as_used($id = null) {
		if (empty($id) || !($address = $this->Address->find('first', ['conditions' => ['Address.id' => $id], 'fields' => ['id', 'formatted_address']]))) {
			$this->Flash->error(__('invalid record'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$this->Address->touch($id);
		$var = $address['Address']['formatted_address'];
		$this->Flash->success(__('Address \'{0}\' marked as last used', h($var)));
		return $this->Common->autoRedirect(['action' => 'index']);
	}

}
