<?php
declare(strict_types = 1);

namespace Data\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Utility\Hash;
use Data\Sync\Timezones;
use Shim\Datasource\Paging\NumericPaginator;

/**
 * @property \Data\Model\Table\TimezonesTable $Timezones
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\Timezone> paginate($object = null, array $settings = [])
 * @property \Search\Controller\Component\SearchComponent $Search
 */
class TimezonesController extends AppController {

	/**
	 * @var array<string, mixed>
	 */
	protected array $paginate = [
		'order' => ['Timezones.name' => 'ASC'],
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
	 * @return \Cake\Http\Response|null|void Renders view
	 */
	public function index() {
		$this->paginate['contain'] = [
			'CanonicalTimezones',
		];
		if (Configure::read('Data.Timezone.Country') !== false) {
			$this->paginate['contain'][] = 'Countries';
		}

		if (Plugin::isLoaded('Search')) {
			$query = $this->Timezones->find('search', search: $this->request->getQuery());
			$timezones = $this->paginate($query);
		} else {
			$timezones = $this->paginate();
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
					if (empty($row['execute']) || empty($diff[$action][$key])) {
						continue;
					}

					$element = $diff[$action][$key];

					switch ($action) {
						case 'add':
							$entity = $this->Timezones->newEntity($element['data']);
							$this->Timezones->saveOrFail($entity);

							break;
						case 'edit':
							/** @var \Data\Model\Entity\Timezone $entity */
							$entity = $element['entity'];
							$entity = $this->Timezones->patchEntity($entity, $element['fields']);
							$this->Timezones->saveOrFail($entity);

							break;
						case 'delete':
							/** @var \Data\Model\Entity\Timezone $entity */
							$entity = $element['entity'];
							$this->Timezones->deleteOrFail($entity);

							break;
					}

					$count++;
				}
			}

			$this->Flash->success($count . ' timezones updated.');

			return $this->redirect(['action' => 'sync']);
		}

		$this->set(compact('diff', 'storedTimezones'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function link() {
		/** @var array<\Data\Model\Entity\Timezone> $storedTimezones */
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
		$contain = ['CanonicalTimezones'];
		if (Configure::read('Data.Timezone.Country') !== false) {
			$contain[] = 'Countries';
		}
		$timezone = $this->Timezones->get($id, contain: $contain);

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
		$timezone = $this->Timezones->get($id);
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
