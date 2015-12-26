<?php
App::uses('DataAppController', 'Data.Controller');

/**
 * Cities Controller
 *
 */
class CitiesController extends DataAppController {

	public $paginate = ['order' => ['modified' => 'DESC']];

	public function beforeFilter() {
		parent::beforeFilter();
	}

	/**
	 * @return void
	 */
	public function admin_index() {
		$this->paginate['contain'] = ['Country'];

		$cities = $this->paginate();
		$this->set(compact('cities'));
	}

	/**
	 * @return void
	 */
	public function admin_view($id = null) {
		if (empty($id) || !($city = $this->City->find('first', ['conditions' => ['City.id' => $id]]))) {
			$this->Flash->error(__('invalidRecord'));
			return $this->Common->autoRedirect(['action' => 'index']);
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
				$this->Flash->success(__('record add %s saved', h($var)));
				return $this->Common->postRedirect(['action' => 'index']);
			}
			$this->Flash->error(__('formContainsErrors'));

		}

		$countries = $this->City->Country->find('list');
		$this->set(compact('countries'));
	}

	/**
	 * @return void
	 */
	public function admin_edit($id = null) {
		if (empty($id) || !($city = $this->City->find('first', ['conditions' => ['City.id' => $id]]))) {
			$this->Flash->error(__('invalidRecord'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		if ($this->Common->isPosted()) {
			if ($this->City->save($this->request->data)) {
				$var = $this->request->data['City']['name'];
				$this->Flash->success(__('record edit %s saved', h($var)));
				return $this->Common->postRedirect(['action' => 'index']);
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
	public function admin_delete($id = null) {
		$this->request->allowMethod(['post', 'delete']);
		if (empty($id) || !($city = $this->City->find('first', ['conditions' => ['City.id' => $id], 'fields' => ['id', 'name']]))) {
			$this->Flash->error(__('invalidRecord'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$var = $city['City']['name'];

		if ($this->City->delete($id)) {
			$this->Flash->success(__('record del %s done', h($var)));
			return $this->redirect(['action' => 'index']);
		}
		$this->Flash->error(__('record del %s not done exception', h($var)));
		return $this->Common->autoRedirect(['action' => 'index']);
	}

}
