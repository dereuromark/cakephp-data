<?php
App::uses('DataAppController', 'Data.Controller');

/**
 * Cities Controller
 *
 */
class CitiesController extends DataAppController {

	public $paginate = array('order' => array('City.modified' => 'DESC'));

	public function beforeFilter() {
		parent::beforeFilter();
	}

/****************************************************************************************
 * USER functions
 ****************************************************************************************/

/****************************************************************************************
 * ADMIN functions
 ****************************************************************************************/

	/**
	 * @return void
	 */
	public function admin_index() {
		$this->City->recursive = 0;
		$cities = $this->paginate();
		$this->set(compact('cities'));
	}

	/**
	 * @return void
	 */
	public function admin_view($id = null) {
		$this->City->recursive = 0;
		if (empty($id) || !($city = $this->City->find('first', array('conditions' => array('City.id' => $id))))) {
			$this->Flash->message(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$this->set(compact('city'));
	}

	/**
	 * @return void
	 */
	public function admin_add() {
		if ($this->Common->isPosted()) {
			$this->City->create();
			if ($this->City->save($this->request->data)) {
				$var = $this->request->data['City']['name'];
				$this->Flash->message(__('record add %s saved', h($var)), 'success');
				return $this->Common->postRedirect(array('action' => 'index'));
			}
			$this->Flash->message(__('formContainsErrors'), 'error');

		}

		$countries = $this->City->Country->find('list');
		$this->set(compact('countries'));
	}

	/**
	 * @return void
	 */
	public function admin_edit($id = null) {
		if (empty($id) || !($city = $this->City->find('first', array('conditions' => array('City.id' => $id))))) {
			$this->Flash->message(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		if ($this->Common->isPosted()) {
			if ($this->City->save($this->request->data)) {
				$var = $this->request->data['City']['name'];
				$this->Flash->message(__('record edit %s saved', h($var)), 'success');
				return $this->Common->postRedirect(array('action' => 'index'));
			}
			$this->Flash->message(__('formContainsErrors'), 'error');

		} else {
			$this->request->data = $city;
		}
		$countries = $this->City->Country->find('list');
		$this->set(compact('countries'));
	}

	/**
	 * @throws MethodNotAllowedException
	 * @return void
	 * @throws NotFoundException
	 * @throws MethodNotAllowedException
	 */
	public function admin_delete($id = null) {
		$this->request->allowMethod(array('post', 'delete'));
		if (empty($id) || !($city = $this->City->find('first', array('conditions' => array('City.id' => $id), 'fields' => array('id', 'name'))))) {
			$this->Flash->message(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$var = $city['City']['name'];

		if ($this->City->delete($id)) {
			$this->Flash->message(__('record del %s done', h($var)), 'success');
			return $this->redirect(array('action' => 'index'));
		}
		$this->Flash->message(__('record del %s not done exception', h($var)), 'error');
		return $this->Common->autoRedirect(array('action' => 'index'));
	}

}
