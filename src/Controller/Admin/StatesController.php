<?php
namespace Data\Controller\Admin;

use Cake\Core\Plugin;
use Cake\Event\Event;
use Data\Controller\DataAppController;
use Exception;

class StatesController extends DataAppController {

	public $paginate = ['order' => ['States.modified' => 'DESC']];

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		if (isset($this->Auth)) {
			$this->Auth->allow(['index', 'update_select']);
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
			throw new Exception(__('not a valid request'));
		}
		$this->viewBuilder()->layout('ajax');
		$States = $this->States->getListByCountry($id);
		$defaultFieldLabel = 'pleaseSelect';
		if ($this->request->query('optional')) {
			$defaultFieldLabel = 'doesNotMatter';
		}

		$this->set(compact('States', 'defaultFieldLabel'));
	}

	/**
	 * StatesController::admin_update_coordinates()
	 *
	 * @param mixed $id
	 * @return void
	 */
	public function updateCoordinates($id = null) {
		set_time_limit(120);
		$res = $this->States->updateCoordinates($id);
		if (!$res) {
			$this->Flash->error(__('coordinates not updated'));
		} else {
			$this->Flash->success(__('coordinates {0} updated', $res));
		}

		$this->autoRender = false;
		return $this->redirect(['action' => 'index']);
	}

	/**
	 * StatesController::admin_index()
	 *
	 * @param mixed $cid
	 * @return void
	 */
	public function index($cid = null) {
		$cid = $this->_processCountry($cid);

		if (Plugin::loaded('Search')) {
			//$this->States->addBehavior('Search.Searchable');
			//$this->Common->loadComponent('Search.Prg');

			//$this->Prg->commonProcess();
			//$States = $this->paginate($this->States->find('searchable', $this->Prg->parsedParams()));
		} else {
			$States = $this->paginate();
		}

		$countries = $this->States->Countries->find('list');

		$this->set(compact('States', 'countries'));
		$this->helpers[] = 'Geo.GoogleMap';
	}

	/**
	 * StatesController::admin_view()
	 *
	 * @param mixed $id
	 * @return void
	 */
	public function view($id = null) {
		if (empty($id)) {
			$this->Flash->error(__('record invalid'));
			return $this->redirect(['action' => 'index']);
		}
		$State = $this->States->get($id);
		if (empty($State)) {
			$this->Flash->error(__('record not exists'));
			return $this->redirect(['action' => 'index']);
		}
		$this->set(compact('State'));
	}

	/**
	 * StatesController::admin_add()
	 *
	 * @return void
	 */
	public function add() {
		if ($this->Common->isPosted()) {
			$this->States->create();
			if ($this->States->save($this->request->data)) {
				$id = $this->States->id;
				$name = $this->request->data['State']['name'];
				$this->Flash->success(__('record add {0} saved', h($name)));
				return $this->redirect(['action' => 'index']);
			}

			$this->Flash->error(__('record add not saved'));
		} else {
			$cid = $this->request->session()->read('State.cid');
			if (!empty($cid)) {
				$this->request->data['State']['country_id'] = $cid;
			}
		}
		$countries = $this->States->Countries->find('list');
		$this->set(compact('countries'));
	}

	/**
	 * StatesController::admin_edit()
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
			if ($this->States->save($this->request->data)) {
				$name = $this->request->data['State']['name'];
				$this->Flash->success(__('record edit {0} saved', h($name)));
				return $this->redirect(['action' => 'index']);
			}

			$this->Flash->error(__('record edit not saved'));
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->States->get($id);
			if (empty($this->request->data)) { # still no record found
				$this->Flash->error(__('record not exists'));
				return $this->redirect(['action' => 'index']);
			}
		}
		$countries = $this->States->Countries->find('list');
		$this->set(compact('countries'));
	}

	/**
	 * StatesController::admin_delete()
	 *
	 * @param mixed $id
	 * @return \Cake\Network\Response|null
	 */
	public function delete($id = null) {
		$this->request->allowMethod('post');

		if (empty($id)) {
			$this->Flash->error(__('record invalid'));
			return $this->redirect(['action' => 'index']);
		}
		$res = $this->States->find('first', ['fields' => ['id', 'name'], 'conditions' => ['State.id' => $id]]);
		if (empty($res)) {
			$this->Flash->error(__('record del not exists'));
			return $this->redirect(['action' => 'index']);
		}

		$name = $res['name'];
		if ($this->States->delete($id)) {
			$this->Flash->success(__('record del {0} done', h($name)));
			return $this->redirect(['action' => 'index']);
		}

		$this->Flash->error(__('record del {0} not done exception', $name));
		return $this->redirect(['action' => 'index']);
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
			$cid = $this->request->session()->read('State.cid');
		}
		if (!empty($cid) && $cid < 0) {
			$this->request->session()->delete('State.cid');
			$cid = null;
		} elseif (!empty($cid) && $saveCid) {
			$this->request->session()->write('State.cid', $cid);
		}

		if (!empty($cid)) {
			$this->paginate = ['conditions' => ['country_id' => $cid]] + $this->paginate;
			$this->request->data['Filter']['id'] = $cid;
		}
	}

}
