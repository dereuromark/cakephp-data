<?php
App::uses('DataAppController', 'Data.Controller');

/**
 * PostalCodes Controller
 *
 */
class PostalCodesController extends DataAppController {

	public $paginate = array();

	public function beforeFilter() {
		parent::beforeFilter();
	}

/****************************************************************************************
 * USER functions
 ****************************************************************************************/

	public function index() {
	}

	public function geolocate() {
		$this->admin_geolocate();
	}

	public function map() {
		if ($this->Common->isPosted()) {
			$term = $this->request->data['PostalCode']['code'];

		} else {
			$term = '';
		}

		$length = max(1, strlen($term));
		$options = array(
			'fields' => array('SUM(lng) as lng_sum', 'SUM(lat) as lat_sum', 'COUNT(*) as count', 'SUBSTRING(code FROM 1 FOR ' . $length . ') as sub', 'PostalCode.*'),
			'conditions' => array('code LIKE' => $term . '%', 'country_id' => 1),
			//'limit' => 50,
			'group' => array('sub')
		);
		$postalCodes = $this->PostalCode->find('all', $options);
		if (!empty($term)) {
			$overviewCode = $postalCodes[0];
			$this->set(compact('overviewCode'));

			$options = array(
				'fields' => array('SUM(lng) as lng_sum', 'SUM(lat) as lat_sum', 'COUNT(*) as count', 'SUBSTRING(code FROM 1 FOR ' . ($length + 1) . ') as sub', 'PostalCode.*'),
				'conditions' => array('code LIKE' => $term . '%', 'country_id' => 1),
				//'limit' => 50,
				'group' => array('sub')
			);
			$postalCodes = $this->PostalCode->find('all', $options);
			//pr($postalCodes);
		}

		$numbers = strlen($term);
		$this->set(compact('postalCodes', 'numbers'));
		$this->helpers = array_merge($this->helpers, array('Tools.GoogleMapV3'));
	}

/****************************************************************************************
 * ADMIN functions
 ****************************************************************************************/

	/**
	 * @return void
	 */
	public function admin_index() {
		$this->PostalCode->bindModel(array('belongsTo' => array('Country' => array('className' => 'Data.Country'))), false);
		$this->PostalCode->recursive = 0;

		$this->PostalCode->Behaviors->load('Search.Searchable');
		$this->Common->loadComponent(array('Search.Prg'));
		$this->Prg->commonProcess();
		$this->paginate['conditions'] = $this->PostalCode->parseCriteria($this->Prg->parsedParams());

		$postalCodes = $this->paginate();

		$countries = $this->PostalCode->Country->find('list');
		$this->set(compact('postalCodes', 'countries'));
	}

	public function admin_geolocate() {
		if (($ipData = $this->Session->read('GeoLocation.data')) === null) {
			App::uses('GeolocateLib', 'Tools.Lib');
			$this->GeolocateLib = new GeolocateLib();
			if ($this->GeolocateLib->locate()) {
				$ipData = $this->GeolocateLib->getResult();
			} else {
				$ipData = array();
			}
			$this->Session->write('GeoLocation.data', $ipData);
		}

		$this->set(compact('ipData'));
		$this->helpers = array_merge($this->helpers, array('Tools.GoogleMapV3'));
		$this->render('geolocate');
	}

	public function admin_query() {
		App::uses('GeocodeLib', 'Tools.Lib');
		$this->GeocodeLib = new GeocodeLib();
		$results = array();
		if ($this->Common->isPosted()) {
			$this->PostalCode->validate['address'] = array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => 'valErrMandatoryField',
					'last' => true
				));
			$this->PostalCode->set($this->request->data);

			$address = $this->request->data['PostalCode']['address'];
			$settings = array(
				'allow_inconclusive' => $this->request->data['PostalCode']['allow_inconclusive'],
				'min_accuracy' => $this->request->data['PostalCode']['min_accuracy']
			);
			$this->GeocodeLib->setOptions($settings);

			if ($this->PostalCode->validates() && $this->GeocodeLib->geocode($address)) {
				$results = $this->GeocodeLib->getResult();
			} else {
				$this->Common->flashMessage(__('formContainsErrors'), 'error');
			}
		} else {
			$this->request->data['PostalCode']['allow_inconclusive'] = 1;
			$this->request->data['PostalCode']['min_accuracy'] = GeocodeLib::ACC_COUNTRY;
		}

		$this->helpers = array_merge($this->helpers, array('Tools.GoogleMapV3'));
		$minAccuracies = $this->GeocodeLib->accuracyTypes();
		$this->set(compact('results', 'minAccuracies'));
	}

	/**
	 * @return void
	 */
	public function admin_view($id = null) {
		$this->PostalCode->recursive = 0;
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
	public function admin_add() {
		if ($this->Common->isPosted()) {
			$this->PostalCode->create();
			if ($this->PostalCode->save($this->request->data)) {
				$var = $this->request->data['PostalCode']['code'];
				$this->Common->flashMessage(__('record add %s saved', h($var)), 'success');
				return $this->Common->postRedirect(array('action' => 'index'));
			} else {
				$this->Common->flashMessage(__('formContainsErrors'), 'error');
			}
		}
	}

	/**
	 * @return void
	 */
	public function admin_edit($id = null) {
		if (empty($id) || !($postalCode = $this->PostalCode->find('first', array('conditions' => array('PostalCode.id' => $id))))) {
			$this->Common->flashMessage(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		if ($this->Common->isPosted()) {
			if ($this->PostalCode->save($this->request->data)) {
				$var = $this->request->data['PostalCode']['code'];
				$this->Common->flashMessage(__('record edit %s saved', h($var)), 'success');
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
	public function admin_delete($id = null) {
		if (!$this->Common->isPosted()) {
			throw new MethodNotAllowedException();
		}
		if (empty($id) || !($postalCode = $this->PostalCode->find('first', array('conditions' => array('PostalCode.id' => $id), 'fields' => array('id', 'code'))))) {
			$this->Common->flashMessage(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$var = $postalCode['PostalCode']['code'];

		if ($this->PostalCode->delete($id)) {
			$this->Common->flashMessage(__('record del %s done', h($var)), 'success');
			return $this->redirect(array('action' => 'index'));
		}
		$this->Common->flashMessage(__('record del %s not done exception', h($var)), 'error');
		return $this->Common->autoRedirect(array('action' => 'index'));
	}

/****************************************************************************************
 * protected/interal functions
 ****************************************************************************************/

/****************************************************************************************
 * deprecated/test functions
 ****************************************************************************************/

}
