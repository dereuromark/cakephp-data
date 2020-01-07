<?php

namespace Data\Controller\Admin;

use Cake\Core\Plugin;
use Cake\Event\EventInterface;
use Data\Controller\DataAppController;
use Exception;

/**
 * @property \Data\Model\Table\StatesTable $States
 * @property \Search\Controller\Component\PrgComponent $Prg
 * @method \Data\Model\Entity\State[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StatesController extends DataAppController {

	/**
	 * @var array
	 */
	public $paginate = ['order' => ['States.modified' => 'DESC']];

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function initialize(): void {
		parent::initialize();

		if (Plugin::isLoaded('Search')) {
			$this->loadComponent('Search.Prg', [
				'actions' => ['index'],
			]);
		}
	}

	/**
	 * @param \Cake\Event\Event $event
	 * @return \Cake\Http\Response|null
	 */
	public function beforeFilter(EventInterface $event) {
		parent::beforeFilter($event);

		if (isset($this->Auth)) {
			$this->Auth->allow(['index', 'update_select']);
		}
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function index() {
		$this->paginate['contain'] = ['Countries'];

		if (Plugin::isLoaded('Search')) {
			$query = $this->States->find('search', ['search' => $this->request->query]);
			$states = $this->paginate($query);
		} else {
			$states = $this->paginate();
		}

		$countries = $this->States->Countries->find('list');

		$this->set(compact('states', 'countries'));
		$this->helpers[] = 'Geo.GoogleMap';
	}

	/**
	 * Ajax function
	 * new: optional true/false for default field label
	 *
	 * @param int|null $id
	 * @throws \Exception
	 * @return \Cake\Http\Response|null
	 */
	public function updateSelect($id = null) {
		//$this->autoRender = false;
		if (!$this->request->is('post') || !$this->request->is('ajax')) {
			throw new Exception(__('not a valid request'));
		}
		$this->viewBuilder()->layout('ajax');
		$states = $this->States->getListByCountry($id);
		$defaultFieldLabel = 'pleaseSelect';
		if ($this->request->getQuery('optional')) {
			$defaultFieldLabel = 'doesNotMatter';
		}

		$this->set(compact('states', 'defaultFieldLabel'));
	}

	/**
	 * @param int|null $id
	 * @return \Cake\Http\Response|null
	 */
	public function view($id = null) {
		$state = $this->States->get($id);

		$this->set(compact('state'));
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function add() {
		$state = $this->States->newEntity();

		if ($this->Common->isPosted()) {
			$state = $this->States->patchEntity($state, $this->request->getData());
			if ($this->States->save($state)) {
				$id = $this->States->id;
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
	 * @return \Cake\Http\Response|null
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

	/**
	 * For both index views
	 *
	 * @deprecated
	 * @param int $cid
	 * @return \Cake\Http\Response|null
	 */
	protected function _processCountry($cid) {
		$saveCid = true;
		if (empty($cid)) {
			$saveCid = false;
			$cid = $this->request->getSession()->read('State.cid');
		}
		if (!empty($cid) && $cid < 0) {
			$this->request->getSession()->delete('State.cid');
			$cid = null;
		} elseif (!empty($cid) && $saveCid) {
			$this->request->getSession()->write('State.cid', $cid);
		}

		if (!empty($cid)) {
			$this->paginate = ['conditions' => ['country_id' => $cid]] + $this->paginate;
			$this->request->data['Filter']['id'] = $cid;
		}
	}

}
