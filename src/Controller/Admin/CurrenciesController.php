<?php
namespace Data\Controller\Admin;

use Cake\Core\Plugin;
use Data\Controller\DataAppController;

class CurrenciesController extends DataAppController {

	public $paginate = ['order' => ['Currency.base' => 'DESC', 'Currency.modified' => 'DESC']];

	public function table() {
		$currencies = $this->Currencies->availableCurrencies();
		$this->set(compact('currencies'));
	}

	public function update() {
		$this->Currencies->updateValues();
		$this->Flash->success('Currencies Updated');
		return $this->Common->autoRedirect(['action' => 'index']);
	}

	public function index() {
		if (Plugin::loaded('Search')) {
			$this->Currencies->addBehavior('Search.Searchable');
			$this->Common->loadComponent('Search.Prg');

			$this->Prg->commonProcess();
			$currencies = $this->paginate($this->Currencies->find('searchable', $this->Prg->parsedParams()));
		} else {
			$currencies = $this->paginate();
		}

		$baseCurrency = [];
		foreach ($currencies as $currency) {
			if ($currency['Currency']['base']) {
				$baseCurrency = $currency;
				break;
			}
		}
		if (empty($baseCurrency)) {
			$baseCurrency = $this->Currencies->find('first', ['conditions' => ['base' => true]]);
			if (!$baseCurrency) {
				$this->Flash->warning(__('noBaseCurrency'));
			}
		}

		$this->set(compact('baseCurrency', 'currencies'));
	}

	public function view($id = null) {
		if (empty($id)) {
			$this->Flash->error(__('record invalid'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$currency = $this->Currencies->get($id);
		if (empty($currency)) {
			$this->Flash->error(__('record not exists'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$this->set(compact('currency'));
	}

	public function add() {
		if ($this->Common->isPosted()) {
			$this->Currencies->create();
			if ($this->Currencies->save($this->request->data)) {
				$id = $this->Currencies->id;
				//$name = $this->request->data['Currency']['name'];
				$this->Flash->success(__('record add {0} saved', $id));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->request->data = $this->Currencies->data;

				$this->Flash->error(__('record add not saved'));
			}
		} else {
			$this->request->data['Currency']['decimal_places'] = 2;
		}

		$currencies = $this->Currencies->currencyList();
		$this->set(compact('currencies'));
	}

	public function edit($id = null) {
		if (empty($id)) {
			$this->Flash->error(__('record invalid'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		if ($this->Common->isPosted()) {
			if ($this->Currencies->save($this->request->data)) {
				//$name = $this->request->data['Currency']['name'];
				$this->Flash->success(__('record edit {0} saved', $id));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('record edit not saved'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Currencies->get($id);
			if (empty($this->request->data)) { # still no record found
				$this->Flash->error(__('record not exists'));
				return $this->redirect(['action' => 'index']);
			}
		}
	}

	public function delete($id = null) {
		if (!$this->Common->isPosted()) {
			throw new MethodNotAllowedException();
		}
		if (empty($id)) {
			$this->Flash->error(__('record invalid'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$res = $this->Currencies->find('first', ['fields' => ['id'], 'conditions' => ['Currency.id' => $id]]);
		if (empty($res)) {
			$this->Flash->error(__('record del not exists'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}

		//$name = $res['Currency']['name'];
		if ($this->Currencies->delete($id)) {
			$this->Flash->success(__('record del {0} done', $id));
			return $this->redirect(['action' => 'index']);
		} else {
			$this->Flash->error(__('record del {0} not done exception', $id));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
	}

	/**
	 * Set as primary (base)
	 */
	public function base($id = null) {
		$this->_setAsPrimary($id);
	}

	public function _setAsPrimary($id) {
		if (!empty($id)) {
			$value = $this->Currencies->setAsBase($id);
		}

		$name = '';
		if (!empty($value)) {
			$this->Flash->success(__('set as primary {0} done', h($name)));
		} else {
			$this->Flash->error(__('set as primary not done exception', $name));

		}
		return $this->Common->autoRedirect(['action' => 'index']);
	}

	/**
	 * Toggle - ajax
	 */
	public function toggle($field = null, $id = null) {
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
