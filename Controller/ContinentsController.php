<?php
App::uses('DataAppController', 'Data.Controller');

class ContinentsController extends DataAppController {

	public $paginate = [];

	public function beforeFilter() {
		parent::beforeFilter();
	}

/****************************************************************************************
 * USER functions
 ****************************************************************************************/

	public function index() {
		$this->paginate['contain'] = ['ParentContinent'];

		$continents = $this->paginate();
		$this->set(compact('continents'));
	}

	public function view($id = null) {
		if (empty($id) || !($continent = $this->Continent->find('first', ['conditions' => ['Continent.id' => $id]]))) {
			$this->Flash->error(__('invalid record'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$this->set(compact('continent'));
	}

	public function add() {
		if ($this->Common->isPosted()) {
			$this->Continent->create();
			if ($this->Continent->save($this->request->data)) {
				$var = $this->request->data['Continent']['name'];
				$this->Flash->success(__('record add %s saved', h($var)));
				return $this->Common->postRedirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('formContainsErrors'));
			}
		}
		$parents = [0 => __('Root')] + $this->Continent->ParentContinent->generateTreeList(null, null, null, '» ');
		$this->set(compact('parents'));
	}

	public function edit($id = null) {
		if (empty($id) || !($continent = $this->Continent->find('first', ['conditions' => ['Continent.id' => $id]]))) {
			$this->Flash->error(__('invalid record'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		if ($this->Common->isPosted()) {
			if ($this->Continent->save($this->request->data)) {
				$var = $this->request->data['Continent']['name'];
				$this->Flash->success(__('record edit %s saved', h($var)));
				return $this->Common->postRedirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('formContainsErrors'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $continent;
		}
		$parents = [0 => __('Root')] + $this->Continent->ParentContinent->generateTreeList(null, null, null, '» ');
		$this->set(compact('parents'));
	}

	public function delete($id = null) {
		$this->request->allowMethod('post');
		if (empty($id) || !($continent = $this->Continent->find('first', ['conditions' => ['Continent.id' => $id], 'fields' => ['id', 'name']]))) {
			$this->Flash->error(__('invalid record'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$var = $continent['Continent']['name'];

		if ($this->Continent->delete($id)) {
			$this->Flash->success(__('record del %s done', h($var)));
			return $this->redirect(['action' => 'index']);
		}
		$this->Flash->error(__('record del %s not done exception', h($var)));
		return $this->Common->autoRedirect(['action' => 'index']);
	}

/****************************************************************************************
 * ADMIN functions
 ****************************************************************************************/

	public function admin_index() {
		$this->paginate['contain'] = ['ParentContinent'];

		$continents = $this->paginate();
		$this->set(compact('continents'));
	}

	public function admin_view($id = null) {
		if (empty($id) || !($continent = $this->Continent->find('first', ['contain' => ['ParentContinent'], 'conditions' => ['Continent.id' => $id]]))) {
			$this->Flash->error(__('invalid record'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$this->set(compact('continent'));
	}

	public function admin_add() {
		if ($this->Common->isPosted()) {
			$this->Continent->create();
			if ($this->Continent->save($this->request->data)) {
				$var = $this->request->data['Continent']['name'];
				$this->Flash->success(__('record add %s saved', h($var)));
				return $this->Common->postRedirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('formContainsErrors'));
			}
		}
		$parents = [0 => __('Root')] + $this->Continent->ParentContinent->generateTreeList(null, null, null, '» ');
		$this->set(compact('parents'));
	}

	public function admin_edit($id = null) {
		if (empty($id) || !($continent = $this->Continent->find('first', ['conditions' => ['Continent.id' => $id]]))) {
			$this->Flash->error(__('invalid record'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		if ($this->Common->isPosted()) {
			if ($this->Continent->save($this->request->data)) {
				$var = $this->request->data['Continent']['name'];
				$this->Flash->success(__('record edit %s saved', h($var)));
				return $this->Common->postRedirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('formContainsErrors'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $continent;
		}
		$parents = [0 => __('Root')] + $this->Continent->ParentContinent->generateTreeList(null, null, null, '» ');
		$this->set(compact('parents'));
	}

	public function admin_delete($id = null) {
		$this->request->allowMethod('post');
		if (empty($id) || !($continent = $this->Continent->find('first', ['conditions' => ['Continent.id' => $id], 'fields' => ['id', 'name']]))) {
			$this->Flash->error(__('invalid record'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$var = $continent['Continent']['name'];

		if ($this->Continent->delete($id)) {
			$this->Flash->success(__('record del %s done', h($var)));
			return $this->redirect(['action' => 'index']);
		}
		$this->Flash->error(__('record del %s not done exception', h($var)));
		return $this->Common->autoRedirect(['action' => 'index']);
	}

/****************************************************************************************
 * protected/interal functions
 ****************************************************************************************/

/****************************************************************************************
 * deprecated/test functions
 ****************************************************************************************/

}
