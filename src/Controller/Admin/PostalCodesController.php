<?php
namespace Data\Controller\Admin;

use Data\Controller\DataAppController;
use Tools\Lib\GeocodeLib;
use Tools\Lib\GeolocateLib;

/**
 * PostalCodes Controller
 *
 */
class PostalCodesController extends DataAppController {

	public $paginate = array();

	/**
	 * @return void
	 */
	public function index() {
		$this->PostalCode->bindModel(array('belongsTo' => array('Country' => array('className' => 'Data.Country'))), false);

		$this->PostalCode->addBehavior('Search.Searchable');
		$this->Common->loadComponent(array('Search.Prg'));
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
				$ipData = array();
			}
			$this->Session->write('GeoLocation.data', $ipData);
		}

		$this->set(compact('ipData'));
		$this->helpers = array_merge($this->helpers, array('Geo.GoogleMapV3'));
		$this->render('geolocate');
	}

	/**
	 * @return void
	 */
	public function view($id = null) {
		$this->PostalCode->bindModel(array('belongsTo' => array('Country' => array('className' => 'Data.Country'))), false);

		if (empty($id) || !($postalCode = $this->PostalCode->find('first', array('contain' => array('Country'), 'conditions' => array('PostalCode.id' => $id))))) {
			$this->Common->flashMessage(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
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
				$this->Common->flashMessage(__('record add {0} saved', h($var)), 'success');
				return $this->Common->postRedirect(array('action' => 'index'));
			} else {
				$this->Common->flashMessage(__('formContainsErrors'), 'error');
			}
		}
	}

	/**
	 * @return void
	 */
	public function edit($id = null) {
		if (empty($id) || !($postalCode = $this->PostalCode->find('first', array('conditions' => array('PostalCode.id' => $id))))) {
			$this->Common->flashMessage(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		if ($this->Common->isPosted()) {
			if ($this->PostalCode->save($this->request->data)) {
				$var = $this->request->data['PostalCode']['code'];
				$this->Common->flashMessage(__('record edit {0} saved', h($var)), 'success');
				return $this->Common->postRedirect(array('action' => 'index'));
			} else {
				$this->Common->flashMessage(__('formContainsErrors'), 'error');
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
		if (empty($id) || !($postalCode = $this->PostalCode->find('first', array('conditions' => array('PostalCode.id' => $id), 'fields' => array('id', 'code'))))) {
			$this->Common->flashMessage(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$var = $postalCode['PostalCode']['code'];

		if ($this->PostalCode->delete($id)) {
			$this->Common->flashMessage(__('record del {0} done', h($var)), 'success');
			return $this->redirect(array('action' => 'index'));
		}
		$this->Common->flashMessage(__('record del {0} not done exception', h($var)), 'error');
		return $this->Common->autoRedirect(array('action' => 'index'));
	}

/****************************************************************************************
 * protected/interal functions
 ****************************************************************************************/

/****************************************************************************************
 * deprecated/test functions
 ****************************************************************************************/

}
