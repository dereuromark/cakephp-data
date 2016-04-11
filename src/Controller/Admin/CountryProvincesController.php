<?php
namespace Data\Controller\Admin;

use Data\Controller\DataAppController;
use Cake\Event\Event;
use Cake\Core\Plugin;

class CountryProvincesController extends DataAppController {

	public $paginate = ['order' => ['CountryProvince.modified' => 'DESC']];

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
	 * CountryProvincesController::admin_update_coordinates()
	 *
	 * @param mixed $id
	 * @return void
	 */
	public function updateCoordinates($id = null) {
		set_time_limit(120);
		$res = $this->CountryProvinces->updateCoordinates($id);
		if (!$res) {
			$this->Flash->error(__('coordinates not updated'));
		} else {
			$this->Flash->success(__('coordinates {0} updated', $res));
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
	public function index($cid = null) {
		$cid = $this->_processCountry($cid);

		if (Plugin::loaded('Search')) {
			$this->CountryProvinces->addBehavior('Search.Searchable');
			$this->Common->loadComponent('Search.Prg');

			$this->Prg->commonProcess();
			$countryProvinces = $this->paginate($this->CountryProvinces->find('searchable', $this->Prg->parsedParams()));
		} else {
			$countryProvinces = $this->paginate();
		}

		$countries = $this->CountryProvinces->Countries->find('list');

		$this->set(compact('countryProvinces', 'countries'));
		$this->helpers[] = 'Geo.GoogleMap';
	}

	/**
	 * CountryProvincesController::admin_view()
	 *
	 * @param mixed $id
	 * @return void
	 */
	public function view($id = null) {
		if (empty($id)) {
			$this->Flash->error(__('record invalid'));
			return $this->redirect(['action' => 'index']);
		}
		$countryProvince = $this->CountryProvinces->get($id);
		if (empty($countryProvince)) {
			$this->Flash->error(__('record not exists'));
			return $this->redirect(['action' => 'index']);
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
			$this->CountryProvinces->create();
			if ($this->CountryProvinces->save($this->request->data)) {
				$id = $this->CountryProvinces->id;
				$name = $this->request->data['CountryProvince']['name'];
				$this->Flash->success(__('record add {0} saved', h($name)));
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
		$countries = $this->CountryProvinces->Countries->find('list');
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
			$this->Flash->error(__('record invalid'));
			return $this->redirect(['action' => 'index']);
		}
		if ($this->Common->isPosted()) {
			if ($this->CountryProvinces->save($this->request->data)) {
				$name = $this->request->data['CountryProvince']['name'];
				$this->Flash->success(__('record edit {0} saved', h($name)));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('record edit not saved'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->CountryProvinces->get($id);
			if (empty($this->request->data)) { # still no record found
				$this->Flash->error(__('record not exists'));
				return $this->redirect(['action' => 'index']);
			}
		}
		$countries = $this->CountryProvinces->Countries->find('list');
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
			$this->Flash->error(__('record invalid'));
			return $this->redirect(['action' => 'index']);
		}
		$res = $this->CountryProvinces->find('first', ['fields' => ['id', 'name'], 'conditions' => ['CountryProvince.id' => $id]]);
		if (empty($res)) {
			$this->Flash->error(__('record del not exists'));
			return $this->redirect(['action' => 'index']);
		}

		$name = $res['CountryProvince']['name'];
		if ($this->CountryProvinces->delete($id)) {
			$this->Flash->success(__('record del {0} done', h($name)));
			return $this->redirect(['action' => 'index']);
		} else {
			$this->Flash->error(__('record del {0} not done exception', $name));
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
			$this->paginate = Set::merge($this->paginate, ['conditions' => ['country_id' => $cid]]);
			$this->request->data['Filter']['id'] = $cid;
		}
	}

}