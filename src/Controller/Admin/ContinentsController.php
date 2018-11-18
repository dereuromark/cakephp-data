<?php
namespace Data\Controller\Admin;

use Data\Controller\DataAppController;

/**
 * @property \Data\Model\Table\ContinentsTable $Continents
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
	 * @return \Cake\Http\Response|null
	 */
	public function view($id = null) {
		if (empty($id) || !($continent = $this->Continents->find('first', ['conditions' => ['Continents.id' => $id]]))) {
			$this->Flash->error(__('invalid record'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$this->set(compact('continent'));
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function add() {
		$continent = $this->Continents->newEntity();

		if ($this->Common->isPosted()) {
			$continent = $this->Continents->patchEntity($continent, $this->request->getData());
			if ($this->Continents->save($continent)) {
				$var = $this->request->data['name'];
				$this->Flash->success(__('record add {0} saved', h($var)));
				return $this->Common->postRedirect(['action' => 'index']);
			}

			$this->Flash->error(__('formContainsErrors'));
		}
		$parents = [0 => __('Root')] + $this->Continents->ParentContinent->find('treeList', ['spacer' => '» ']);
		$this->set(compact('continent', 'parents'));
	}

	/**
	 * @param int|null $id
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function edit($id = null) {
		if (empty($id) || !($continent = $this->Continents->find('first', ['conditions' => ['Continents.id' => $id]]))) {
			$this->Flash->error(__('invalid record'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		if ($this->Common->isPosted()) {
			$continent = $this->Continents->patchEntity($continent, $this->request->getData());
			if ($this->Continents->save($continent)) {
				$var = $this->request->data['name'];
				$this->Flash->success(__('record edit {0} saved', h($var)));
				return $this->Common->postRedirect(['action' => 'index']);
			}

			$this->Flash->error(__('formContainsErrors'));
		}

		$parents = [0 => __('Root')] + $this->Continents->ParentContinent->find('treeList', ['spacer' => '» ']);
		$this->set(compact('continent', 'parents'));
	}

	/**
	 * @param int|null $id
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function delete($id = null) {
		$this->request->allowMethod('post');

		if (empty($id) || !($continent = $this->Continents->find('first', ['conditions' => ['Continents.id' => $id], 'fields' => ['id', 'name']]))) {
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
