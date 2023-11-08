<?php

namespace Data\Controller\Admin;

use Cake\Core\Plugin;
use Data\Controller\DataAppController;
use Shim\Datasource\Paging\NumericPaginator;

/**
 * @property \Data\Model\Table\StatesTable $States
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\State> paginate($object = null, array $settings = [])
 * @property \Search\Controller\Component\SearchComponent $Search
 */
class StatesController extends DataAppController {

	/**
	 * @var array<string, mixed>
	 */
	protected array $paginate = [
		'order' => ['States.modified' => 'DESC'],
		'className' => NumericPaginator::class,
	];

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		if (Plugin::isLoaded('Search')) {
			$this->loadComponent('Search.Search', [
				'actions' => ['index'],
			]);
		}
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function index() {
		$this->paginate['contain'] = ['Countries'];

		if (Plugin::isLoaded('Search')) {
			$query = $this->States->find('search', search: $this->request->getQuery());
			$states = $this->paginate($query);
		} else {
			$states = $this->paginate();
		}
		$countries = $this->States->Countries->find('list')->toArray();

		$this->set(compact('states', 'countries'));
		$this->viewBuilder()->setHelpers(['Geo.GoogleMap']);
	}

	/**
	 * Ajax function
	 * new: optional true/false for default field label
	 *
	 * @param int|null $id
	 * @throws \Exception
	 * @return \Cake\Http\Response|null|void
	 */
	public function updateSelect($id = null) {
		//$this->request->allowMethod('ajax');

		$this->viewBuilder()->setLayout('ajax');
		$states = $this->States->getListByCountry($id);
		$defaultFieldLabel = 'pleaseSelect';
		if ($this->request->getQuery('optional')) {
			$defaultFieldLabel = 'doesNotMatter';
		}

		$this->set(compact('states', 'defaultFieldLabel'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function add() {
		$state = $this->States->newEmptyEntity();

		if ($this->Common->isPosted()) {
			$state = $this->States->patchEntity($state, $this->request->getData());
			if ($this->States->save($state)) {
				$id = $state->id;
				$name = $this->request->getData('name');
				$this->Flash->success(__('record add {0} saved', h($name)));

				return $this->redirect(['action' => 'index']);
			}

			$this->Flash->error(__('record add not saved'));
		}

		$countries = $this->States->Countries->find('list');
		$this->set(compact('state', 'countries'));
	}

	/**
	 * @param mixed $id
	 * @return \Cake\Http\Response|null|void
	 */
	public function edit($id = null) {
		$state = $this->States->get($id);

		if ($this->Common->isPosted()) {
			$state = $this->States->patchEntity($state, $this->request->getData());

			if ($this->States->save($state)) {
				$name = $this->request->getData('name');
				$this->Flash->success(__('record edit {0} saved', h($name)));

				return $this->redirect(['action' => 'index']);
			}

			$this->Flash->error(__('record edit not saved'));
		}

		$countries = $this->States->Countries->find('list');
		$this->set(compact('state', 'countries'));
	}

	/**
	 * @param int|null $id
	 * @return \Cake\Http\Response|null
	 */
	public function delete($id = null) {
		$this->request->allowMethod('post');

		$state = $this->States->get($id);

		$name = $state['name'];
		if ($this->States->delete($state)) {
			$this->Flash->success(__('record del {0} done', h($name)));

			return $this->redirect(['action' => 'index']);
		}

		$this->Flash->error(__('record del {0} not done exception', $name));

		return $this->redirect(['action' => 'index']);
	}

}
