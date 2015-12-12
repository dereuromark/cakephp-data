<?php
App::uses('DataAppController', 'Data.Controller');

class CurrenciesController extends DataAppController {

	//public $helpers = array('Data.Numeric', 'Data.FormExt');

	public $paginate = ['order' => ['Currency.base' => 'DESC', 'Currency.modified' => 'DESC']];

	public function beforeFilter() {
		parent::beforeFilter();
	}

	/**
	 * @deprecated
	 */
	public function admin_list() {
		$currencies = $this->Currency->availableCurrencies();
		$res = [];
		foreach ($currencies as $key => $currency) {
			$x = ['id' => $key, 'name' => $key];
			$res[] = $x;
		}

		echo json_encode(['results' => $res]);
		die();
	}

	public function admin_table() {
		$currencies = $this->Currency->availableCurrencies();
		$this->set(compact('currencies'));
	}

	public function admin_update() {
		$this->Currency->updateValues();
		$this->Flash->success('Currencies Updated');
		return $this->Common->autoRedirect(['action' => 'index']);
	}

	public function admin_index() {
		$this->Currency->recursive = 0;

		if (CakePlugin::loaded('Search')) {
			$this->Currency->Behaviors->load('Search.Searchable');
			$this->Common->loadComponent(['Search.Prg']);

			$this->Prg->commonProcess();
			$this->paginate['conditions'] = $this->Currency->parseCriteria($this->Prg->parsedParams());
		}

		$currencies = $this->paginate();

		$baseCurrency = [];
		foreach ($currencies as $currency) {
			if ($currency['Currency']['base']) {
				$baseCurrency = $currency;
				break;
			}
		}
		if (empty($baseCurrency)) {
			$baseCurrency = $this->Currency->find('first', ['conditions' => ['base' => true]]);
			if (!$baseCurrency) {
				$this->Flash->warning(__('noBaseCurrency'));
			}
		}

		$this->set(compact('baseCurrency', 'currencies'));
	}

	public function admin_view($id = null) {
		$this->Currency->recursive = 0;
		if (empty($id)) {
			$this->Flash->error(__('record invalid'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$currency = $this->Currency->record($id);
		if (empty($currency)) {
			$this->Flash->error(__('record not exists'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$this->set(compact('currency'));
	}

	public function admin_add() {
		if ($this->Common->isPosted()) {
			$this->Currency->create();
			if ($this->Currency->save($this->request->data)) {
				$id = $this->Currency->id;
				//$name = $this->request->data['Currency']['name'];
				$this->Flash->success(__('record add %s saved', $id));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->request->data = $this->Currency->data;

				$this->Flash->error(__('record add not saved'));
			}
		} else {
			$this->request->data['Currency']['decimal_places'] = 2;
		}

		$currencies = $this->Currency->currencyList();
		$this->set(compact('currencies'));
	}

	public function admin_edit($id = null) {
		if (empty($id)) {
			$this->Flash->error(__('record invalid'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		if ($this->Common->isPosted()) {
			if ($this->Currency->save($this->request->data)) {
				//$name = $this->request->data['Currency']['name'];
				$this->Flash->success(__('record edit %s saved', $id));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('record edit not saved'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Currency->record($id);
			if (empty($this->request->data)) { # still no record found
				$this->Flash->error(__('record not exists'));
				return $this->redirect(['action' => 'index']);
			}
		}
	}

	public function admin_delete($id = null) {
		$this->request->allowMethod('post');
		if (empty($id)) {
			$this->Flash->error(__('record invalid'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$res = $this->Currency->find('first', ['fields' => ['id'], 'conditions' => ['Currency.id' => $id]]);
		if (empty($res)) {
			$this->Flash->error(__('record del not exists'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}

		//$name = $res['Currency']['name'];
		if ($this->Currency->delete($id)) {
			$this->Flash->success(__('record del %s done', $id));
			return $this->redirect(['action' => 'index']);
		} else {
			$this->Flash->error(__('record del %s not done exception', $id));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
	}

	/**
	 * Set as primary (base)
	 */
	public function admin_base($id = null) {
		$this->_setAsPrimary($id);
	}

	public function _setAsPrimary($id) {
		if (!empty($id)) {
			$value = $this->Currency->setAsBase($id);
		}

		$name = '';
		if (!empty($value)) {
			$this->Flash->success(__('set as primary %s done', h($name)));
		} else {
			$this->Flash->error(__('set as primary not done exception', $name));

		}
		return $this->Common->autoRedirect(['action' => 'index']);
	}

	/**
	 * Toggle - ajax
	 */
	public function admin_toggle($field = null, $id = null) {
		 $fields = ['active'];

		if (!empty($field) && in_array($field, $fields) && !empty($id)) {
			$value = $this->{$this->modelClass}->toggleField($field, $id);

		}

		//$this->request->isAll(array('post', 'ajax'))

		# http get request + redirect
		if (!$this->request->is('ajax')) {
			$this->Flash->success(__('Saved'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}

		# ajax
		$model = $this->{$this->modelClass}->alias;
		$this->autoRender = false;
		if (isset($value)) {
			$this->set('ajaxToggle', $value);
			$this->set(compact('field', 'model'));

			$this->render('admin_toggle', 'ajax');
		}
	}

}