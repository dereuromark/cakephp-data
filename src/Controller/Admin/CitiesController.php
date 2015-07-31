<?php
namespace Data\Controller\Admin;

use Data\Controller\DataAppController;

/**
 * Cities Controller
 *
 */
class CitiesController extends DataAppController {

	public $paginate = array('order' => array('City.modified' => 'DESC'));

	/**
	 * @return void
	 */
	public function index() {
		$cities = $this->paginate();
		$this->set(compact('cities'));
	}

	/**
	 * @return void
	 */
	public function view($id = null) {
		if (empty($id) || !($city = $this->City->find('first', array('conditions' => array('City.id' => $id))))) {
			$this->Flash->error(__('invalidRecord'));
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$this->set(compact('city'));
	}

	/**
	 * @return void
	 */
	public function add() {
		if ($this->Common->isPosted()) {
			$this->City->create();
			if ($this->City->save($this->request->data)) {
				$var = $this->request->data['City']['name'];
				$this->Flash->success(__('record add {0} saved', h($var)));
				return $this->Common->postRedirect(array('action' => 'index'));
			}
			$this->Flash->error(__('formContainsErrors'));

		}

		$countries = $this->City->Country->find('list');
		$this->set(compact('countries'));
	}

	/**
	 * @return void
	 */
	public function edit($id = null) {
		if (empty($id) || !($city = $this->City->find('first', array('conditions' => array('City.id' => $id))))) {
			$this->Flash->error(__('invalidRecord'));
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		if ($this->Common->isPosted()) {
			if ($this->City->save($this->request->data)) {
				$var = $this->request->data['City']['name'];
				$this->Flash->success(__('record edit {0} saved', h($var)));
				return $this->Common->postRedirect(array('action' => 'index'));
			}
			$this->Flash->error(__('formContainsErrors'));

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
	public function delete($id = null) {
		$this->request->allowMethod(array('post', 'delete'));
		if (empty($id) || !($city = $this->City->find('first', array('conditions' => array('City.id' => $id), 'fields' => array('id', 'name'))))) {
			$this->Flash->error(__('invalidRecord'));
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$var = $city['City']['name'];

		if ($this->City->delete($id)) {
			$this->Flash->success(__('record del {0} done', h($var)));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Flash->error(__('record del {0} not done exception', h($var)));
		return $this->Common->autoRedirect(array('action' => 'index'));
	}

}
