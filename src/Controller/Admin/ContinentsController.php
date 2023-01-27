<?php

namespace Data\Controller\Admin;

use Data\Controller\DataAppController;

/**
 * @property \Data\Model\Table\ContinentsTable $Continents
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\Continent> paginate($object = null, array $settings = [])
 */
class ContinentsController extends DataAppController {

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function index() {
		$this->paginate = [
			'contain' => ['ParentContinents'],
		];

		$continents = $this->paginate();
		$this->set(compact('continents'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function tree() {
		$continents = $this->Continents->find('threaded');

		$countries = $this->Continents->Countries->find()
			->select(['count' => 'COUNT(*)', 'continent_id'])
			->group('continent_id')
			->find('list', ['keyField' => 'continent_id', 'valueField' => 'count'])
			->toArray();

		$this->set(compact('continents', 'countries'));

		$this->viewBuilder()->addHelper('Tools.Tree');
	}

	/**
	 * @param int|null $id
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function view($id = null) {
		$continent = $this->Continents->get($id, ['contain' => ['ParentContinents']]);

		$this->set(compact('continent'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function add() {
		$continent = $this->Continents->newEmptyEntity();

		if ($this->Common->isPosted()) {
			$continent = $this->Continents->patchEntity($continent, $this->request->getData());
			if ($this->Continents->save($continent)) {
				$var = $continent['name'];
				$this->Flash->success(__('record add {0} saved', h($var)));

				return $this->Common->postRedirect(['action' => 'index']);
			}

			$this->Flash->error(__('formContainsErrors'));
		}
		$parents = ['' => __(' - n/a - ')] + $this->Continents->ParentContinents->find('treeList', ['spacer' => '» '])->toArray();
		$this->set(compact('continent', 'parents'));
	}

	/**
	 * @param int|null $id
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function edit($id = null) {
		$continent = $this->Continents->get($id);

		if ($this->Common->isPosted()) {
			$continent = $this->Continents->patchEntity($continent, $this->request->getData());
			if ($this->Continents->save($continent)) {
				$var = $continent['name'];
				$this->Flash->success(__('record edit {0} saved', h($var)));

				return $this->Common->postRedirect(['action' => 'index']);
			}

			$this->Flash->error(__('formContainsErrors'));
		}

		$parents = ['' => __(' - n/a - ')] + $this->Continents->ParentContinents->find('treeList', ['spacer' => '» '])->toArray();
		$this->set(compact('continent', 'parents'));
	}

	/**
	 * @param int|null $id
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function delete($id = null) {
		$this->request->allowMethod('post');

		$continent = $this->Continents->get($id);
		$var = $continent['name'];

		if ($this->Continents->delete($continent)) {
			$this->Flash->success(__('record del {0} done', h($var)));

			return $this->redirect(['action' => 'index']);
		}
		$this->Flash->error(__('record del {0} not done exception', h($var)));

		return $this->Common->autoRedirect(['action' => 'index']);
	}

}
