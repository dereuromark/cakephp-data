<?php
namespace Data\Controller;

use Data\Controller\DataAppController;

class ContinentsController extends DataAppController {

	public $paginate = array();


	public function index() {
		$continents = $this->paginate();
		$this->set(compact('continents'));
	}

	public function view($id = null) {
		if (empty($id) || !($continent = $this->Continent->find('first', array('conditions' => array('Continent.id' => $id))))) {
			$this->Common->flashMessage(__('invalid record'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$this->set(compact('continent'));
	}

	public function add() {
		if ($this->Common->isPosted()) {
			$this->Continent->create();
			if ($this->Continent->save($this->request->data)) {
				$var = $this->request->data['Continent']['name'];
				$this->Common->flashMessage(__('record add {0} saved', h($var)), 'success');
				return $this->Common->postRedirect(array('action' => 'index'));
			} else {
				$this->Common->flashMessage(__('formContainsErrors'), 'error');
			}
		}
		$parents = array(0 => __('Root')) + $this->Continent->ParentContinent->generateTreeList(null, null, null, '» ');
		$this->set(compact('parents'));
	}

	public function edit($id = null) {
		if (empty($id) || !($continent = $this->Continent->find('first', array('conditions' => array('Continent.id' => $id))))) {
			$this->Common->flashMessage(__('invalid record'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		if ($this->Common->isPosted()) {
			if ($this->Continent->save($this->request->data)) {
				$var = $this->request->data['Continent']['name'];
				$this->Common->flashMessage(__('record edit {0} saved', h($var)), 'success');
				return $this->Common->postRedirect(array('action' => 'index'));
			} else {
				$this->Common->flashMessage(__('formContainsErrors'), 'error');
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $continent;
		}
		$parents = array(0 => __('Root')) + $this->Continent->ParentContinent->generateTreeList(null, null, null, '» ');
		$this->set(compact('parents'));
	}

	public function delete($id = null) {
		if (!$this->Common->isPosted()) {
			throw new MethodNotAllowedException();
		}
		if (empty($id) || !($continent = $this->Continent->find('first', array('conditions' => array('Continent.id' => $id), 'fields' => array('id', 'name'))))) {
			$this->Common->flashMessage(__('invalid record'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$var = $continent['Continent']['name'];

		if ($this->Continent->delete($id)) {
			$this->Common->flashMessage(__('record del {0} done', h($var)), 'success');
			return $this->redirect(array('action' => 'index'));
		}
		$this->Common->flashMessage(__('record del {0} not done exception', h($var)), 'error');
		return $this->Common->autoRedirect(array('action' => 'index'));
	}

	public function admin_index() {
		$continents = $this->paginate();
		$this->set(compact('continents'));
	}

	public function admin_view($id = null) {
		if (empty($id) || !($continent = $this->Continent->find('first', array('conditions' => array('Continent.id' => $id))))) {
			$this->Common->flashMessage(__('invalid record'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$this->set(compact('continent'));
	}

	public function admin_add() {
		if ($this->Common->isPosted()) {
			$this->Continent->create();
			if ($this->Continent->save($this->request->data)) {
				$var = $this->request->data['Continent']['name'];
				$this->Common->flashMessage(__('record add {0} saved', h($var)), 'success');
				return $this->Common->postRedirect(array('action' => 'index'));
			} else {
				$this->Common->flashMessage(__('formContainsErrors'), 'error');
			}
		}
		$parents = array(0 => __('Root')) + $this->Continent->ParentContinent->generateTreeList(null, null, null, '» ');
		$this->set(compact('parents'));
	}

	public function admin_edit($id = null) {
		if (empty($id) || !($continent = $this->Continent->find('first', array('conditions' => array('Continent.id' => $id))))) {
			$this->Common->flashMessage(__('invalid record'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		if ($this->Common->isPosted()) {
			if ($this->Continent->save($this->request->data)) {
				$var = $this->request->data['Continent']['name'];
				$this->Common->flashMessage(__('record edit {0} saved', h($var)), 'success');
				return $this->Common->postRedirect(array('action' => 'index'));
			} else {
				$this->Common->flashMessage(__('formContainsErrors'), 'error');
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $continent;
		}
		$parents = array(0 => __('Root')) + $this->Continent->ParentContinent->generateTreeList(null, null, null, '» ');
		$this->set(compact('parents'));
	}

	public function admin_delete($id = null) {
		if (!$this->Common->isPosted()) {
			throw new MethodNotAllowedException();
		}
		if (empty($id) || !($continent = $this->Continent->find('first', array('conditions' => array('Continent.id' => $id), 'fields' => array('id', 'name'))))) {
			$this->Common->flashMessage(__('invalid record'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$var = $continent['Continent']['name'];

		if ($this->Continent->delete($id)) {
			$this->Common->flashMessage(__('record del {0} done', h($var)), 'success');
			return $this->redirect(array('action' => 'index'));
		}
		$this->Common->flashMessage(__('record del {0} not done exception', h($var)), 'error');
		return $this->Common->autoRedirect(array('action' => 'index'));
	}

/****************************************************************************************
 * protected/interal functions
 ****************************************************************************************/

/****************************************************************************************
 * deprecated/test functions
 ****************************************************************************************/

}
