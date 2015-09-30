<?php
namespace Data\Controller;

use Data\Controller\DataAppController;

class ContinentsController extends DataAppController {

	public $paginate = [];


	public function index() {
		$continents = $this->paginate();
		$this->set(compact('continents'));
	}

	public function view($id = null) {
		if (empty($id) || !($continent = $this->Continent->find('first', ['conditions' => ['Continent.id' => $id]]))) {
			$this->Flash->error(__('invalid record'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$this->set(compact('continent'));
	}

	public function add() {
		if ($this->Common->isPosted()) {
			$this->Continent->create();
			if ($this->Continent->save($this->request->data)) {
				$var = $this->request->data['Continent']['name'];
				$this->Flash->success(__('record add {0} saved', h($var)));
				return $this->Common->postRedirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('formContainsErrors'));
			}
		}
		$parents = [0 => __('Root')] + $this->Continent->ParentContinent->find('treeList', ['spacer' => '» ']);
		$this->set(compact('parents'));
	}

	public function edit($id = null) {
		if (empty($id) || !($continent = $this->Continent->find('first', ['conditions' => ['Continent.id' => $id]]))) {
			$this->Flash->error(__('invalid record'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		if ($this->Common->isPosted()) {
			if ($this->Continent->save($this->request->data)) {
				$var = $this->request->data['Continent']['name'];
				$this->Flash->success(__('record edit {0} saved', h($var)));
				return $this->Common->postRedirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('formContainsErrors'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $continent;
		}
		$parents = [0 => __('Root')] + $this->Continent->ParentContinent->find('treeList', ['spacer' => '» ']);
		$this->set(compact('parents'));
	}

	public function delete($id = null) {
		if (!$this->Common->isPosted()) {
			throw new MethodNotAllowedException();
		}
		if (empty($id) || !($continent = $this->Continent->find('first', ['conditions' => ['Continent.id' => $id], 'fields' => ['id', 'name']]))) {
			$this->Flash->error(__('invalid record'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$var = $continent['Continent']['name'];

		if ($this->Continent->delete($id)) {
			$this->Flash->success(__('record del {0} done', h($var)));
			return $this->redirect(['action' => 'index']);
		}
		$this->Flash->error(__('record del {0} not done exception', h($var)));
		return $this->Common->autoRedirect(['action' => 'index']);
	}

}
