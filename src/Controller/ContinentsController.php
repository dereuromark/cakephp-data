<?php
namespace Data\Controller;

use Data\Controller\DataAppController;

/**
 * @property \Data\Model\Table\ContinentsTable $Continents
 * @method \Cake\ORM\Entity[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContinentsController extends DataAppController {

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function index() {
		$continents = $this->paginate();
		$this->set(compact('continents'));
	}

	/**
	 * @param int|null $id
	 *
	 * @return mixed
	 */
	public function view($id = null) {
		if (empty($id) || !($continent = $this->Continents->find('first', ['conditions' => ['Continent.id' => $id]]))) {
			$this->Flash->error(__('invalid record'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$this->set(compact('continent'));
	}

	/**
	 * @return mixed
	 */
	public function add() {
		if ($this->Common->isPosted()) {
			//$this->Continents->create();
			if ($this->Continents->save($this->request->getData())) {
				$var = $this->request->data['Continent']['name'];
				$this->Flash->success(__('record add {0} saved', h($var)));
				return $this->Common->postRedirect(['action' => 'index']);
			}

			$this->Flash->error(__('formContainsErrors'));
		}
		$parents = [0 => __('Root')] + $this->Continents->ParentContinents->find('treeList', ['spacer' => '» ']);
		$this->set(compact('parents'));
	}

	public function edit($id = null) {
		if (empty($id) || !($continent = $this->Continents->find('first', ['conditions' => ['Continent.id' => $id]]))) {
			$this->Flash->error(__('invalid record'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		if ($this->Common->isPosted()) {
			if ($this->Continents->save($this->request->data)) {
				$var = $this->request->data['Continent']['name'];
				$this->Flash->success(__('record edit {0} saved', h($var)));
				return $this->Common->postRedirect(['action' => 'index']);
			}

			$this->Flash->error(__('formContainsErrors'));
		}

		$parents = [0 => __('Root')] + $this->Continents->ParentContinents->find('treeList', ['spacer' => '» ']);
		$this->set(compact('parents'));
	}

	public function delete($id = null) {
		$this->request->allowMethod('post');

		if (empty($id) || !($continent = $this->Continents->find('first', ['conditions' => ['Continent.id' => $id], 'fields' => ['id', 'name']]))) {
			$this->Flash->error(__('invalid record'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$var = $continent['name'];

		if ($this->Continents->delete($continent)) {
			$this->Flash->success(__('record del {0} done', h($var)));
			return $this->redirect(['action' => 'index']);
		}
		$this->Flash->error(__('record del {0} not done exception', h($var)));
		return $this->Common->autoRedirect(['action' => 'index']);
	}

}
