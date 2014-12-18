<?php
App::uses('DataAppController', 'Data.Controller');

class ContinentsController extends DataAppController {

	public $paginate = array();

	public function beforeFilter() {
		parent::beforeFilter();
	}

/****************************************************************************************
 * USER functions
 ****************************************************************************************/

	public function index() {
		$this->Continent->recursive = 0;
		$continents = $this->paginate();
		$this->set(compact('continents'));
	}

	public function view($id = null) {
		if (empty($id) || !($continent = $this->Continent->find('first', array('conditions' => array('Continent.id' => $id))))) {
			$this->Flash->message(__('invalid record'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$this->set(compact('continent'));
	}

	public function add() {
		if ($this->Common->isPosted()) {
			$this->Continent->create();
			if ($this->Continent->save($this->request->data)) {
				$var = $this->request->data['Continent']['name'];
				$this->Flash->message(__('record add %s saved', h($var)), 'success');
				return $this->Common->postRedirect(array('action' => 'index'));
			} else {
				$this->Flash->message(__('formContainsErrors'), 'error');
			}
		}
		$parents = array(0 => __('Root')) + $this->Continent->ParentContinent->generateTreeList(null, null, null, '» ');
		$this->set(compact('parents'));
	}

	public function edit($id = null) {
		if (empty($id) || !($continent = $this->Continent->find('first', array('conditions' => array('Continent.id' => $id))))) {
			$this->Flash->message(__('invalid record'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		if ($this->Common->isPosted()) {
			if ($this->Continent->save($this->request->data)) {
				$var = $this->request->data['Continent']['name'];
				$this->Flash->message(__('record edit %s saved', h($var)), 'success');
				return $this->Common->postRedirect(array('action' => 'index'));
			} else {
				$this->Flash->message(__('formContainsErrors'), 'error');
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $continent;
		}
		$parents = array(0 => __('Root')) + $this->Continent->ParentContinent->generateTreeList(null, null, null, '» ');
		$this->set(compact('parents'));
	}

	public function delete($id = null) {
		$this->request->allowMethod('post');
		if (empty($id) || !($continent = $this->Continent->find('first', array('conditions' => array('Continent.id' => $id), 'fields' => array('id', 'name'))))) {
			$this->Flash->message(__('invalid record'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$var = $continent['Continent']['name'];

		if ($this->Continent->delete($id)) {
			$this->Flash->message(__('record del %s done', h($var)), 'success');
			return $this->redirect(array('action' => 'index'));
		}
		$this->Flash->message(__('record del %s not done exception', h($var)), 'error');
		return $this->Common->autoRedirect(array('action' => 'index'));
	}

/****************************************************************************************
 * ADMIN functions
 ****************************************************************************************/

	public function admin_index() {
		$this->Continent->recursive = 0;
		$continents = $this->paginate();
		$this->set(compact('continents'));
	}

	public function admin_view($id = null) {
		if (empty($id) || !($continent = $this->Continent->find('first', array('conditions' => array('Continent.id' => $id))))) {
			$this->Flash->message(__('invalid record'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$this->set(compact('continent'));
	}

	public function admin_add() {
		if ($this->Common->isPosted()) {
			$this->Continent->create();
			if ($this->Continent->save($this->request->data)) {
				$var = $this->request->data['Continent']['name'];
				$this->Flash->message(__('record add %s saved', h($var)), 'success');
				return $this->Common->postRedirect(array('action' => 'index'));
			} else {
				$this->Flash->message(__('formContainsErrors'), 'error');
			}
		}
		$parents = array(0 => __('Root')) + $this->Continent->ParentContinent->generateTreeList(null, null, null, '» ');
		$this->set(compact('parents'));
	}

	public function admin_edit($id = null) {
		if (empty($id) || !($continent = $this->Continent->find('first', array('conditions' => array('Continent.id' => $id))))) {
			$this->Flash->message(__('invalid record'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		if ($this->Common->isPosted()) {
			if ($this->Continent->save($this->request->data)) {
				$var = $this->request->data['Continent']['name'];
				$this->Flash->message(__('record edit %s saved', h($var)), 'success');
				return $this->Common->postRedirect(array('action' => 'index'));
			} else {
				$this->Flash->message(__('formContainsErrors'), 'error');
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $continent;
		}
		$parents = array(0 => __('Root')) + $this->Continent->ParentContinent->generateTreeList(null, null, null, '» ');
		$this->set(compact('parents'));
	}

	public function admin_delete($id = null) {
		$this->request->allowMethod('post');
		if (empty($id) || !($continent = $this->Continent->find('first', array('conditions' => array('Continent.id' => $id), 'fields' => array('id', 'name'))))) {
			$this->Flash->message(__('invalid record'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$var = $continent['Continent']['name'];

		if ($this->Continent->delete($id)) {
			$this->Flash->message(__('record del %s done', h($var)), 'success');
			return $this->redirect(array('action' => 'index'));
		}
		$this->Flash->message(__('record del %s not done exception', h($var)), 'error');
		return $this->Common->autoRedirect(array('action' => 'index'));
	}

/****************************************************************************************
 * protected/interal functions
 ****************************************************************************************/

/****************************************************************************************
 * deprecated/test functions
 ****************************************************************************************/

}
