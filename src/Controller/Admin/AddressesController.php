<?php
namespace Data\Controller\Admin;

use Cake\Core\Configure;
use Cake\Network\Exception\MethodNotAllowedException;
use Data\Controller\DataAppController;

/**
 * @property \Data\Model\Table\AddressesTable $Addresses
 */
class AddressesController extends DataAppController {

	/**
	 * @return void
	 */
	public function index() {
		$addresses = $this->paginate();
		$this->set(compact('addresses'));
		$this->helpers[] = 'Geo.GoogleMap';
	}

	/**
	 * @param int|null $id
	 * @return \Cake\Network\Response|null
	 */
	public function view($id = null) {
		if (empty($id) || !($address = $this->Address->find('first', ['conditions' => ['Addresses.id' => $id]]))) {
			$this->Flash->error(__('invalid record'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$this->set(compact('address'));
		$this->helpers[] = 'Geo.GoogleMap';
	}

	/**
	 * @return \Cake\Network\Response|null
	 */
	public function add() {
		$address = $this->Addresses->newEntity();
		if ($this->Common->isPosted()) {
			$address = $this->Addresses->patchEntity($address, $this->request->data);
			if ($this->Address->save($address)) {
				$var = $address['formatted_address'];
				$this->Flash->success(__('record add {0} saved', h($var)));
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('formContainsErrors'));

		} else {
			# TODO: geolocate via IP? only for frontend
			$options = ['Countries.iso2' => 'DE'];
			$this->request->data['country_id'] = $this->Address->Country->fieldByConditions('id', $options);
		}

		$countries = $this->Address->Country->find('list');
		$countryProvinces = [];
		if (Configure::read('Address.CountryProvince')) {
			$countryProvinces = $this->Address->CountryProvince->find('list');
		}

		$this->set(compact('countries', 'countryProvinces'));
	}

	public function edit($id = null) {
		if (empty($id) || !($address = $this->Address->find('first', ['conditions' => ['Addresses.id' => $id]]))) {
			$this->Flash->error(__('invalid record'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		if ($this->Common->isPosted()) {
			if ($this->Address->save($this->request->data)) {
				$var = $this->request->data['formatted_address'];
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
		$countries = $this->Addresses->Countries->find('list');
		$countryProvinces = [];
		if (Configure::read('Address.CountryProvince')) {
			$countryProvinces = $this->Addresses->CountryProvinces->find('list');
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

		if (empty($id) || !($address = $this->Address->find('first', ['conditions' => ['Addresses.id' => $id], 'fields' => ['id', 'formatted_address']]))) {
			$this->Flash->error(__('invalid record'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$var = $address['formatted_address'];

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
		$var = $address['formatted_address'];
		$this->Flash->success(__('Address \'{0}\' marked as last used', h($var)));
		return $this->Common->autoRedirect(['action' => 'index']);
	}

}
