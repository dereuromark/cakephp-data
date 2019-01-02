<?php
namespace Data\Controller\Admin;

use Data\Controller\DataAppController;

/**
 * Cities Controller
 */
/**
 * @property \Data\Model\Table\CitiesTable $Cities
 * @method \Cake\ORM\Entity[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CitiesController extends DataAppController {

	/**
	 * @var array
	 */
	public $paginate = ['order' => ['Cities.modified' => 'DESC']];

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function index() {
		$cities = $this->paginate();
		$this->set(compact('cities'));
	}

	/**
	 * @param int|null $id
	 * @return \Cake\Http\Response|null
	 */
	public function view($id = null) {
		if (empty($id) || !($city = $this->Cities->find('first', ['conditions' => ['City.id' => $id]]))) {
			$this->Flash->error(__('invalidRecord'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$this->set(compact('city'));
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function add() {
		if ($this->Common->isPosted()) {
			//$this->Cities->create();
			if ($this->Cities->save($this->request->data)) {
				$var = $this->request->data['name'];
				$this->Flash->success(__('record add {0} saved', h($var)));
				return $this->Common->postRedirect(['action' => 'index']);
			}
			$this->Flash->error(__('formContainsErrors'));

		}

		$countries = $this->Cities->Countries->find('list');
		$this->set(compact('countries'));
	}

	/**
	 * @param int|null $id
	 * @return \Cake\Http\Response|null
	 */
	public function edit($id = null) {
		if (empty($id) || !($city = $this->Cities->find('first', ['conditions' => ['City.id' => $id]]))) {
			$this->Flash->error(__('invalidRecord'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		if ($this->Common->isPosted()) {
			if ($this->Cities->save($this->request->data)) {
				$var = $this->request->data['name'];
				$this->Flash->success(__('record edit {0} saved', h($var)));
				return $this->Common->postRedirect(['action' => 'index']);
			}
			$this->Flash->error(__('formContainsErrors'));

		} else {
			$this->request->data = $city;
		}
		$countries = $this->Cities->Countries->find('list');
		$this->set(compact('countries'));
	}

	/**
	 * @param int|null $id
	 * @return \Cake\Http\Response|null
	 */
	public function delete($id = null) {
		$this->request->allowMethod(['post', 'delete']);

		if (empty($id) || !($city = $this->Cities->find('first', ['conditions' => ['City.id' => $id], 'fields' => ['id', 'name']]))) {
			$this->Flash->error(__('invalidRecord'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$var = $city['name'];

		if ($this->Cities->delete($city)) {
			$this->Flash->success(__('record del {0} done', h($var)));
			return $this->redirect(['action' => 'index']);
		}
		$this->Flash->error(__('record del {0} not done exception', h($var)));
		return $this->Common->autoRedirect(['action' => 'index']);
	}

}
