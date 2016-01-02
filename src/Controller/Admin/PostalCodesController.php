<?php
namespace Data\Controller\Admin;

use Data\Controller\DataAppController;
use Geo\Geocode\Geocode;
use ToolsExtra\Lib\GeolocateLib;

/**
 * PostalCodes Controller
 *
 */
class PostalCodesController extends DataAppController {

	public $paginate = [];

	/**
	 * @return void
	 */
	public function index() {
		$this->PostalCode->bindModel(['belongsTo' => ['Country' => ['className' => 'Data.Country']]], false);

		$this->PostalCode->addBehavior('Search.Searchable');
		$this->Common->loadComponent('Search.Prg');
		$this->Prg->commonProcess();
		$this->paginate['conditions'] = $this->PostalCode->find('searchable', $this->Prg->parsedParams());

		$postalCodes = $this->paginate();

		$countries = $this->PostalCode->Country->find('list');
		$this->set(compact('postalCodes', 'countries'));
	}

	public function geolocate() {
		if (($ipData = $this->Session->read('GeoLocation.data')) === null) {
			$this->GeolocateLib = new GeolocateLib();
			if ($this->GeolocateLib->locate()) {
				$ipData = $this->GeolocateLib->getResult();
			} else {
				$ipData = [];
			}
			$this->Session->write('GeoLocation.data', $ipData);
		}

		$this->set(compact('ipData'));
		$this->helpers = array_merge($this->helpers, ['Geo.GoogleMapV3']);
		$this->render('geolocate');
	}

	/**
	 * @return void
	 */
	public function view($id = null) {
		$this->PostalCode->bindModel(['belongsTo' => ['Country' => ['className' => 'Data.Country']]], false);

		if (empty($id) || !($postalCode = $this->PostalCode->find('first', ['contain' => ['Country'], 'conditions' => ['PostalCode.id' => $id]]))) {
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
			$this->PostalCode->create();
			if ($this->PostalCode->save($this->request->data)) {
				$var = $this->request->data['PostalCode']['code'];
				$this->Flash->success(__('record add {0} saved', h($var)));
				return $this->Common->postRedirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('formContainsErrors'));
			}
		}
	}

	/**
	 * @return void
	 */
	public function edit($id = null) {
		if (empty($id) || !($postalCode = $this->PostalCode->find('first', ['conditions' => ['PostalCode.id' => $id]]))) {
			$this->Flash->error(__('invalidRecord'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		if ($this->Common->isPosted()) {
			if ($this->PostalCode->save($this->request->data)) {
				$var = $this->request->data['PostalCode']['code'];
				$this->Flash->success(__('record edit {0} saved', h($var)));
				return $this->Common->postRedirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('formContainsErrors'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $postalCode;
		}
	}

	/**
	 * @return void
	 */
	public function delete($id = null) {
		if (!$this->Common->isPosted()) {
			throw new MethodNotAllowedException();
		}
		if (empty($id) || !($postalCode = $this->PostalCode->find('first', ['conditions' => ['PostalCode.id' => $id], 'fields' => ['id', 'code']]))) {
			$this->Flash->error(__('invalidRecord'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$var = $postalCode['PostalCode']['code'];

		if ($this->PostalCode->delete($id)) {
			$this->Flash->success(__('record del {0} done', h($var)));
			return $this->redirect(['action' => 'index']);
		}
		$this->Flash->error(__('record del {0} not done exception', h($var)));
		return $this->Common->autoRedirect(['action' => 'index']);
	}

/****************************************************************************************
 * protected/interal functions
 ****************************************************************************************/

/****************************************************************************************
 * deprecated/test functions
 ****************************************************************************************/

}
