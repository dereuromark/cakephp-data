<?php
declare(strict_types = 1);

namespace Data\Controller\Admin;

use App\Controller\AppController;
use Cake\Utility\Hash;
use Data\Sync\Timezones;

/**
 * @property \Data\Model\Table\TimezonesTable $Timezones
 * @method \Data\Model\Entity\Timezone[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TimezonesController extends AppController {

	/**
	 * @return \Cake\Http\Response|null|void Renders view
	 */
	public function index() {
		$timezones = $this->paginate($this->Timezones);

		$this->set(compact('timezones'));
	}

	/**
	 * @return void
	 */
	public function sync() {
		$storedTimezones = $this->Timezones->find()->all()->toArray();
		$storedTimezones = Hash::combine($storedTimezones, '{n}.name', '{n}');

		$fields = $this->request->getQuery('fields') ? explode(',', $this->request->getQuery('fields')) : [];
		$diff = (new Timezones())->diff($storedTimezones, $fields);

		if ($this->request->is('post')) {
			$data = (array)$this->request->getData();
			foreach ($data as $action => $rows) {
				foreach ($rows as $key => $row) {
					dd($row);
				}

			}
		}

		$this->set(compact('diff', 'storedTimezones'));
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
