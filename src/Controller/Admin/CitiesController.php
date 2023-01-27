<?php

namespace Data\Controller\Admin;

use Data\Controller\DataAppController;

/**
 * Cities Controller
 */
/**
 * @property \Data\Model\Table\CitiesTable $Cities
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\City> paginate($object = null, array $settings = [])
 */
class CitiesController extends DataAppController {

	/**
	 * @var array<string, mixed>
	 */
	protected array $paginate = ['order' => ['Cities.modified' => 'DESC']];

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function index() {
		$cities = $this->paginate();
		$this->set(compact('cities'));
	}

	/**
	 * @param int|null $id
	 * @return \Cake\Http\Response|null|void
	 */
	public function view($id = null) {
		$city = $this->Cities->get($id);

		$this->set(compact('city'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function add() {
		$city = $this->Cities->newEmptyEntity();

		if ($this->Common->isPosted()) {
			if ($this->Cities->save($this->request->getData())) {
				$var = $city['name'];
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
	 * @return \Cake\Http\Response|null|void
	 */
	public function edit($id = null) {
		$city = $this->Cities->get($id);

		if ($this->Common->isPosted()) {
			$city = $this->Cities->patchEntity($city, $this->request->getData());

			if ($this->Cities->save($city)) {
				$var = $city['name'];
				$this->Flash->success(__('record edit {0} saved', h($var)));

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
	public function delete($id = null) {
		$this->request->allowMethod(['post', 'delete']);

		$city = $this->Cities->get($id);
		$var = $city['name'];

		if ($this->Cities->delete($city)) {
			$this->Flash->success(__('record del {0} done', h($var)));

			return $this->redirect(['action' => 'index']);
		}
		$this->Flash->error(__('record del {0} not done exception', h($var)));

		return $this->Common->autoRedirect(['action' => 'index']);
	}

}
