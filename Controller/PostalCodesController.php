<?php
App::uses('DataAppController', 'Data.Controller');
App::uses('GeocodeLib', 'Tools.Lib');

/**
 * PostalCodes Controller
 *
 */
class PostalCodesController extends DataAppController {

	public $paginate = [];

	public function beforeFilter() {
		parent::beforeFilter();
	}

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
		$options = [
			'fields' => ['SUM(lng) as lng_sum', 'SUM(lat) as lat_sum', 'COUNT(*) as count', 'SUBSTRING(code FROM 1 FOR ' . $length . ') as sub', 'PostalCode.*'],
			'conditions' => ['code LIKE' => $term . '%', 'country_id' => 1],
			//'limit' => 50,
			'group' => ['sub']
		];
		$postalCodes = $this->PostalCode->find('all', $options);
		if (!empty($term)) {
			$overviewCode = $postalCodes[0];
			$this->set(compact('overviewCode'));

			$options = [
				'fields' => ['SUM(lng) as lng_sum', 'SUM(lat) as lat_sum', 'COUNT(*) as count', 'SUBSTRING(code FROM 1 FOR ' . ($length + 1) . ') as sub', 'PostalCode.*'],
				'conditions' => ['code LIKE' => $term . '%', 'country_id' => 1],
				//'limit' => 50,
				'group' => ['sub']
			];
			$postalCodes = $this->PostalCode->find('all', $options);
			//pr($postalCodes);
		}

		$numbers = strlen($term);
		$this->set(compact('postalCodes', 'numbers'));
		$this->helpers = array_merge($this->helpers, ['Tools.GoogleMapV3']);
	}

	/**
	 * @return void
	 */
	public function admin_index() {
		$this->PostalCode->bindModel(['belongsTo' => ['Country' => ['className' => 'Data.Country']]], false);

		$this->PostalCode->Behaviors->load('Search.Searchable');
		$this->Common->loadComponent(['Search.Prg']);
		$this->Prg->commonProcess();
		$this->paginate['contain'] = ['Country'];
		$this->paginate['conditions'] = $this->PostalCode->parseCriteria($this->Prg->parsedParams());

		$postalCodes = $this->paginate();

		$countries = $this->PostalCode->Country->find('list');
		$this->set(compact('postalCodes', 'countries'));
	}

	public function admin_geolocate() {
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
		$this->helpers = array_merge($this->helpers, ['Tools.GoogleMapV3']);
		$this->render('geolocate');
	}

	public function admin_query() {
		$this->GeocodeLib = new GeocodeLib();
		$results = [];
		if ($this->Common->isPosted()) {
			$this->PostalCode->validate['address'] = [
				'notEmpty' => [
					'rule' => ['notEmpty'],
					'message' => 'valErrMandatoryField',
					'last' => true
				]];
			$this->PostalCode->set($this->request->data);

			$address = $this->request->data['PostalCode']['address'];
			$settings = [
				'allow_inconclusive' => $this->request->data['PostalCode']['allow_inconclusive'],
				'min_accuracy' => $this->request->data['PostalCode']['min_accuracy']
			];
			$this->GeocodeLib->setOptions($settings);

			if ($this->PostalCode->validates() && $this->GeocodeLib->geocode($address)) {
				$results = $this->GeocodeLib->getResult();
			} else {
				$this->Flash->error(__('formContainsErrors'));
			}
		} else {
			$this->request->data['PostalCode']['allow_inconclusive'] = 1;
			$this->request->data['PostalCode']['min_accuracy'] = GeocodeLib::ACC_COUNTRY;
		}

		$this->helpers = array_merge($this->helpers, ['Tools.GoogleMapV3']);
		$minAccuracies = $this->GeocodeLib->accuracyTypes();
		$this->set(compact('results', 'minAccuracies'));
	}

	/**
	 * @return void
	 */
	public function admin_view($id = null) {
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
	public function admin_add() {
		if ($this->Common->isPosted()) {
			$this->PostalCode->create();
			if ($this->PostalCode->save($this->request->data)) {
				$var = $this->request->data['PostalCode']['code'];
				$this->Flash->success(__('record add %s saved', h($var)));
				return $this->Common->postRedirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('formContainsErrors'));
			}
		}
	}

	/**
	 * @return void
	 */
	public function admin_edit($id = null) {
		if (empty($id) || !($postalCode = $this->PostalCode->find('first', ['conditions' => ['PostalCode.id' => $id]]))) {
			$this->Flash->error(__('invalidRecord'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		if ($this->Common->isPosted()) {
			if ($this->PostalCode->save($this->request->data)) {
				$var = $this->request->data['PostalCode']['code'];
				$this->Flash->success(__('record edit %s saved', h($var)));
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
	public function admin_delete($id = null) {
		$this->request->allowMethod('post');
		if (empty($id) || !($postalCode = $this->PostalCode->find('first', ['conditions' => ['PostalCode.id' => $id], 'fields' => ['id', 'code']]))) {
			$this->Flash->error(__('invalidRecord'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$var = $postalCode['PostalCode']['code'];

		if ($this->PostalCode->delete($id)) {
			$this->Flash->success(__('record del %s done', h($var)));
			return $this->redirect(['action' => 'index']);
		}
		$this->Flash->error(__('record del %s not done exception', h($var)));
		return $this->Common->autoRedirect(['action' => 'index']);
	}

/****************************************************************************************
 * protected/interal functions
 ****************************************************************************************/

/****************************************************************************************
 * deprecated/test functions
 ****************************************************************************************/

}
