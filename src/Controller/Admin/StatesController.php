<?php
namespace Data\Controller\Admin;

use Cake\Core\Plugin;
use Cake\Event\Event;
use Data\Controller\DataAppController;
use Exception;

/**
 * @property \Data\Model\Table\StatesTable $States
 */
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
		$states = $this->States->getListByCountry($id);
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
			//$states = $this->paginate($this->States->find('searchable', $this->Prg->parsedParams()));
		} else {
			$states = $this->paginate();
		}

		$countries = $this->States->Countries->find('list');

		$this->set(compact('states', 'countries'));
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
		$this->set(compact('state'));
	}

	/**
	 * @return \Cake\Network\Response|null
	 */
	public function add() {
		$state = $this->States->newEntity();

		if ($this->Common->isPosted()) {
			$state = $this->States->patchEntity($state, $this->request->data);
			if ($this->States->save($state)) {
				$id = $this->States->id;
				$name = $this->request->data['State']['name'];
				$this->Flash->success(__('record add {0} saved', h($name)));
				return $this->redirect(['action' => 'index']);
			}

			$this->Flash->error(__('record add not saved'));
		}

		$countries = $this->States->Countries->find('list');
		$this->set(compact('state', 'countries'));
	}

	/**
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
		$this->set(compact('state', 'countries'));
	}

	/**
	 * @param mixed $id
	 * @return \Cake\Network\Response|null
	 */
	public function delete($id = null) {
		$this->request->allowMethod('post');

		$state = $this->States->get($id);

		$name = $state['name'];
		if ($this->States->delete($id)) {
			$this->Flash->success(__('record del {0} done', h($name)));
			return $this->redirect(['action' => 'index']);
		}

		$this->Flash->error(__('record del {0} not done exception', $name));
		return $this->redirect(['action' => 'index']);
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
