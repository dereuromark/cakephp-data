<?php

namespace Data\Controller\Admin;

use Cake\Core\Plugin;
use Data\Controller\DataAppController;

/**
 * PostalCodes Controller
 */
/**
 * @property \Data\Model\Table\PostalCodesTable $PostalCodes
 * @method \Data\Model\Entity\PostalCode[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PostalCodesController extends DataAppController {

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function index() {
		if (Plugin::isLoaded('Search')) {
			$query = $this->PostalCodes->find('search', ['search' => $this->request->getQuery()]);
			$postalCodes = $this->paginate($query);
		} else {
			$postalCodes = $this->paginate();
		}

		$countries = $this->PostalCodes->Countries->find('list');
		$this->set(compact('postalCodes', 'countries'));
	}

	/*
	public function geolocate() {
		if (($ipData = $this->request->getSession()->read('GeoLocation.data')) === null) {
			$this->GeolocateLib = new Geolocater();
			if ($this->GeolocateLib->locate()) {
				$ipData = $this->GeolocateLib->getResult();
			} else {
				$ipData = [];
			}
			$this->request->getSession()->write('GeoLocation.data', $ipData);
		}

		$this->set(compact('ipData'));
		$this->viewBuilder()->setHelpers(['Geo.GoogleMap']);
		$this->render('geolocate');
	}
	*/

	/**
	 * @param int|null $id
	 * @return \Cake\Http\Response|null
	 */
	public function view($id = null) {
		$postalCode = $this->PostalCodes->get($id, ['contain' => ['Countries']]);

		$this->set(compact('postalCode'));
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function add() {
		$postalCode = $this->PostalCodes->newEmptyEntity();

		if ($this->Common->isPosted()) {
			$postalCode = $this->PostalCodes->patchEntity($postalCode, $this->request->getData());
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
	 * @return \Cake\Http\Response|null
	 */
	public function edit($id = null) {
		$postalCode = $this->PostalCodes->get($id, []);

		if ($this->Common->isPosted()) {
			$postalCode = $this->PostalCodes->patchEntity($postalCode, $this->request->getData());

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
	 * @return \Cake\Http\Response|null
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
