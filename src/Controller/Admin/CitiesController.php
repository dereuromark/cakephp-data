<?php
namespace Data\Controller\Admin;

use Data\Controller\DataAppController;

/**
 * Cities Controller
 */
class CitiesController extends DataAppController {

	/**
	 * @var array
	 */
	public $paginate = ['order' => ['Cities.modified' => 'DESC']];

	/**
	 * @return \Cake\Network\Response|null
	 */
	public function index() {
		$cities = $this->paginate();
		$this->set(compact('cities'));
	}

	/**
	 * @param int|null $id
	 * @return \Cake\Network\Response|null
	 */
	public function view($id = null) {
		if (empty($id) || !($city = $this->City->find('first', ['conditions' => ['City.id' => $id]]))) {
			$this->Flash->error(__('invalidRecord'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$this->set(compact('city'));
	}

	/**
	 * @return \Cake\Network\Response|null
	 */
	public function add() {
		if ($this->Common->isPosted()) {
			$this->City->create();
			if ($this->City->save($this->request->data)) {
				$var = $this->request->data['name'];
				$this->Flash->success(__('record add {0} saved', h($var)));
				return $this->Common->postRedirect(['action' => 'index']);
			}
			$this->Flash->error(__('formContainsErrors'));

		}

		$countries = $this->City->Country->find('list');
		$this->set(compact('countries'));
	}

	/**
	 * @param int|null $id
	 * @return \Cake\Network\Response|null
	 */
	public function edit($id = null) {
		if (empty($id) || !($city = $this->City->find('first', ['conditions' => ['City.id' => $id]]))) {
			$this->Flash->error(__('invalidRecord'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		if ($this->Common->isPosted()) {
			if ($this->City->save($this->request->data)) {
				$var = $this->request->data['name'];
				$this->Flash->success(__('record edit {0} saved', h($var)));
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
	 * @param int|null $id
	 * @return \Cake\Network\Response|null
	 */
	public function delete($id = null) {
		$this->request->allowMethod(['post', 'delete']);

		if (empty($id) || !($city = $this->City->find('first', ['conditions' => ['City.id' => $id], 'fields' => ['id', 'name']]))) {
			$this->Flash->error(__('invalidRecord'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$var = $city['name'];

		if ($this->City->delete($id)) {
			$this->Flash->success(__('record del {0} done', h($var)));
			return $this->redirect(['action' => 'index']);
		}
		$this->Flash->error(__('record del {0} not done exception', h($var)));
		return $this->Common->autoRedirect(['action' => 'index']);
	}

}
