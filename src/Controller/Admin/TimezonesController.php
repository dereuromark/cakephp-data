<?php
declare(strict_types = 1);

namespace Data\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Plugin;
use Cake\Utility\Hash;
use Data\Sync\Timezones;

/**
 * @property \Data\Model\Table\TimezonesTable $Timezones
 * @method \Data\Model\Entity\Timezone[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TimezonesController extends AppController {

	/**
	 * @var array
	 */
	public $paginate = ['order' => ['Timezones.name' => 'ASC']];

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
	 * @return \Cake\Http\Response|null|void Renders view
	 */
	public function index() {
		$this->paginate['contain'] = [
			'CanonicalTimezones',
		];

		if (Plugin::isLoaded('Search')) {
			$query = $this->Timezones->find('search', ['search' => $this->request->getQuery()]);
			$timezones = $this->paginate($query)->toArray();
		} else {
			$timezones = $this->paginate()->toArray();
		}

		$this->set(compact('timezones'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function sync() {
		$storedTimezones = $this->Timezones->find()->all()->toArray();
		$storedTimezones = Hash::combine($storedTimezones, '{n}.name', '{n}');

		$fields = $this->request->getQuery('fields') ? explode(',', $this->request->getQuery('fields')) : [];
		$diff = (new Timezones())->diff($storedTimezones, $fields);

		if ($this->request->is('post')) {
			$data = (array)$this->request->getData('Form');
			$count = 0;
			foreach ($data as $action => $rows) {
				foreach ($rows as $key => $row) {
					dd($row);
				}
			}

			$this->Flash->success($count . ' timezones updated.');

			return $this->redirect(['action' => 'link']);
		}

		$this->set(compact('diff', 'storedTimezones'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function link() {
		/** @var \Data\Model\Entity\Timezone[] $storedTimezones */
		$storedTimezones = $this->Timezones->find()->all()->toArray();
		$storedTimezones = Hash::combine($storedTimezones, '{n}.name', '{n}');

		$todo = [];
		foreach ($storedTimezones as $storedTimezone) {
			$canonicalTimezone = $this->Timezones->findCanonical($storedTimezone, $storedTimezones);
			if (!$canonicalTimezone || $canonicalTimezone->id === $storedTimezone->linked_id) {
				continue;
			}

			$storedTimezone->canonical_timezone = $canonicalTimezone;

			$todo[$storedTimezone->id] = $storedTimezone;
		}

		if ($this->request->is('post')) {
			$data = (array)$this->request->getData('Form.link');
			$count = 0;
			foreach ($data as $id => $row) {
				if (empty($row['execute']) || empty($todo[$id])) {
					continue;
				}

				$timezone = $todo[$id];
				$this->Timezones->saveOrFail($timezone);
				$count++;
			}
			$this->Flash->success($count . ' timezones updated.');

			return $this->redirect(['action' => 'link']);
		}

		$this->set(compact('todo', 'storedTimezones'));
	}

	/**
	 * View method
	 *
	 * @param string|null $id Timezone id.
	 * @return \Cake\Http\Response|null|void Renders view
	 */
	public function view($id = null) {
		$timezone = $this->Timezones->get($id, [
			'contain' => [],
		]);

		$this->set(compact('timezone'));
	}

	/**
	 * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
	 */
	public function add() {
		$timezone = $this->Timezones->newEmptyEntity();
		if ($this->request->is('post')) {
			$timezone = $this->Timezones->patchEntity($timezone, $this->request->getData());
			if ($this->Timezones->save($timezone)) {
				$this->Flash->success(__('The timezone has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The timezone could not be saved. Please, try again.'));
		}
		$this->set(compact('timezone'));
	}

	/**
	 * @param string|null $id Timezone id.
	 * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
	 */
	public function edit($id = null) {
		$timezone = $this->Timezones->get($id, [
			'contain' => [],
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$timezone = $this->Timezones->patchEntity($timezone, $this->request->getData());
			if ($this->Timezones->save($timezone)) {
				$this->Flash->success(__('The timezone has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The timezone could not be saved. Please, try again.'));
		}
		$this->set(compact('timezone'));
	}

	/**
	 * @param string|null $id Timezone id.
	 * @return \Cake\Http\Response|null|void Redirects to index.
	 */
	public function delete($id = null) {
		$this->request->allowMethod(['post', 'delete']);
		$timezone = $this->Timezones->get($id);
		if ($this->Timezones->delete($timezone)) {
			$this->Flash->success(__('The timezone has been deleted.'));
		} else {
			$this->Flash->error(__('The timezone could not be deleted. Please, try again.'));
		}

		return $this->redirect(['action' => 'index']);
	}

}
