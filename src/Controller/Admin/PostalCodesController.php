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
		//$this->PostalCodes->bindModel(['belongsTo' => ['Country' => ['className' => 'Data.Country']]], false);

		//$this->PostalCodes->addBehavior('Search.Searchable');
		//$this->Common->loadComponent('Search.Prg');
		//$this->Prg->commonProcess();
		//$this->paginate['conditions'] = $this->PostalCodes->find('search', ['search' => $this->request->query]);

		$postalCodes = $this->paginate();

		$countries = $this->PostalCodes->Countries->find('list');
		$this->set(compact('postalCodes', 'countries'));
	}

	public function geolocate() {
		if (($ipData = $this->request->session()->read('GeoLocation.data')) === null) {
			$this->GeolocateLib = new GeolocateLib();
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

	/**
	 * @return void
	 */
	public function view($id = null) {
		$this->PostalCodes->bindModel(['belongsTo' => ['Country' => ['className' => 'Data.Country']]], false);

		if (empty($id) || !($postalCode = $this->PostalCodes->find('first', ['contain' => ['Country'], 'conditions' => ['PostalCode.id' => $id]]))) {
			$this->Flash->error(__('invalidRecord'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}

		$this->set(compact('postalCode'));
	}

	/**
	 * @return void
	 */
	public function add() {
		if ($this->Common->isPosted()) {
			$this->PostalCodes->create();
			if ($this->PostalCodes->save($this->request->data)) {
				$var = $this->request->data['code'];
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
			if ($this->PostalCodes->save($this->request->data)) {
				$var = $this->request->data['code'];
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
