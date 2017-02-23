<?php
namespace Data\Controller\Admin;

use Data\Controller\DataAppController;
use ToolsExtra\Lib\GeolocateLib;

/**
 * PostalCodes Controller
 */
/**
 * @property \Data\Model\Table\PostalCodesTable $PostalCodes
 */
class PostalCodesController extends DataAppController {

	/**
	 * @return void
	 */
	public function index() {
		$query = $this->PostalCodes->find('search', ['search' => $this->request->query]);

		$postalCodes = $this->paginate($query);

		$countries = $this->PostalCodes->Countries->find('list');
		$this->set(compact('postalCodes', 'countries'));
	}

	/*
	public function geolocate() {
		if (($ipData = $this->request->session()->read('GeoLocation.data')) === null) {
			$this->GeolocateLib = new Geolocater();
			if ($this->GeolocateLib->locate()) {
				$ipData = $this->GeolocateLib->getResult();
			} else {
				$ipData = [];
			}
			$this->request->session()->write('GeoLocation.data', $ipData);
		}

		$this->set(compact('ipData'));
		$this->helpers = array_merge($this->helpers, ['Geo.GoogleMap']);
		$this->render('geolocate');
	}
	*/

	/**
	 * @param int|null $id
	 * @return \Cake\Network\Response|null
	 */
	public function view($id = null) {
		if (empty($id) || !($postalCode = $this->PostalCodes->find('first', ['contain' => ['Countries'], 'conditions' => ['PostalCodes.id' => $id]]))) {
			$this->Flash->error(__('invalidRecord'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}

		$this->set(compact('postalCode'));
	}

	/**
	 * @return \Cake\Network\Response|null
	 */
	public function add() {
		$postalCode = $this->PostalCodes->newEntity();

		if ($this->Common->isPosted()) {
			$postalCode = $this->PostalCodes->patchEntity($postalCode, $this->request->data);
			if ($this->PostalCodes->save($postalCode)) {
				$var = $postalCode['code'];
				$this->Flash->success(__('record add {0} saved', h($var)));
				return $this->Common->postRedirect(['action' => 'index']);
			}

			$this->Flash->error(__('formContainsErrors'));
		}

		$this->set(compact('postalCode'));
	}

	/**
	 * @param int|null $id
	 * @return \Cake\Network\Response|null
	 */
	public function edit($id = null) {
		if (empty($id) || !($postalCode = $this->PostalCodes->find('first', ['conditions' => ['PostalCode.id' => $id]]))) {
			$this->Flash->error(__('invalidRecord'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		if ($this->Common->isPosted()) {
			$postalCode = $this->PostalCodes->patchEntity($postalCode, $this->request->data);

			if ($this->PostalCodes->save($postalCode)) {
				$var = $postalCode['code'];
				$this->Flash->success(__('record edit {0} saved', h($var)));
				return $this->Common->postRedirect(['action' => 'index']);
			}

			$this->Flash->error(__('formContainsErrors'));
		}

		$this->set(compact('postalCode'));
	}

	/**
	 * @param int|null $id
	 * @return \Cake\Network\Response|null
	 */
	public function delete($id = null) {
		$this->request->allowMethod('post');

		$postalCode = $this->PostalCodes->get($id);
		$var = $postalCode['code'];

		if ($this->PostalCodes->delete($postalCode)) {
			$this->Flash->success(__('record del {0} done', h($var)));
			return $this->redirect(['action' => 'index']);
		}
		$this->Flash->error(__('record del {0} not done exception', h($var)));
		return $this->Common->autoRedirect(['action' => 'index']);
	}

}
