<?php
namespace Data\Controller\Admin;

use Cake\Core\Plugin;
use Data\Controller\DataAppController;

class CurrenciesController extends DataAppController {

	public $paginate = array('order' => array('Currency.base' => 'DESC', 'Currency.modified' => 'DESC'));

	public function table() {
		$currencies = $this->Currencies->availableCurrencies();
		$this->set(compact('currencies'));
	}

	public function update() {
		$this->Currencies->updateValues();
		$this->Common->flashMessage('Currencies Updated', 'success');
		return $this->Common->autoRedirect(array('action' => 'index'));
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

		$baseCurrency = array();
		foreach ($currencies as $currency) {
			if ($currency['Currency']['base']) {
				$baseCurrency = $currency;
				break;
			}
		}
		if (empty($baseCurrency)) {
			$baseCurrency = $this->Currencies->find('first', array('conditions' => array('base' => true)));
			if (!$baseCurrency) {
				$this->Common->flashMessage(__('noBaseCurrency'), 'warning');
			}
		}

		$this->set(compact('baseCurrency', 'currencies'));
	}

	public function view($id = null) {
		if (empty($id)) {
			$this->Common->flashMessage(__('record invalid'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$currency = $this->Currencies->get($id);
		if (empty($currency)) {
			$this->Common->flashMessage(__('record not exists'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$this->set(compact('currency'));
	}

	public function add() {
		if ($this->Common->isPosted()) {
			$this->Currencies->create();
			if ($this->Currencies->save($this->request->data)) {
				$id = $this->Currencies->id;
				//$name = $this->request->data['Currency']['name'];
				$this->Common->flashMessage(__('record add {0} saved', $id), 'success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->request->data = $this->Currencies->data;

				$this->Common->flashMessage(__('record add not saved'), 'error');
			}
		} else {
			$this->request->data['Currency']['decimal_places'] = 2;
		}

		$currencies = $this->Currencies->currencyList();
		$this->set(compact('currencies'));
	}

	public function edit($id = null) {
		if (empty($id)) {
			$this->Common->flashMessage(__('record invalid'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		if ($this->Common->isPosted()) {
			if ($this->Currencies->save($this->request->data)) {
				//$name = $this->request->data['Currency']['name'];
				$this->Common->flashMessage(__('record edit {0} saved', $id), 'success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Common->flashMessage(__('record edit not saved'), 'error');
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Currencies->get($id);
			if (empty($this->request->data)) { # still no record found
				$this->Common->flashMessage(__('record not exists'), 'error');
				return $this->redirect(array('action' => 'index'));
			}
		}
	}

	public function delete($id = null) {
		if (!$this->Common->isPosted()) {
			throw new MethodNotAllowedException();
		}
		if (empty($id)) {
			$this->Common->flashMessage(__('record invalid'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$res = $this->Currencies->find('first', array('fields' => array('id'), 'conditions' => array('Currency.id' => $id)));
		if (empty($res)) {
			$this->Common->flashMessage(__('record del not exists'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}

		//$name = $res['Currency']['name'];
		if ($this->Currencies->delete($id)) {
			$this->Common->flashMessage(__('record del {0} done', $id), 'success');
			return $this->redirect(array('action' => 'index'));
		} else {
			$this->Common->flashMessage(__('record del {0} not done exception', $id), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
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
			$this->Common->flashMessage(__('set as primary {0} done', h($name)), 'success');
		} else {
			$this->Common->flashMessage(__('set as primary not done exception', $name), 'error');

		}
		return $this->Common->autoRedirect(array('action' => 'index'));
	}

	/**
	 * Toggle - ajax
	 */
	public function toggle($field = null, $id = null) {
		 $fields = array('active');

		if (!empty($field) && in_array($field, $fields) && !empty($id)) {
			$value = $this->{$this->modelClass}->toggleField($field, $id);

		}

		//$this->request->isAll(array('post', 'ajax'))

		# http get request + redirect
		if (!$this->request->is('ajax')) {
			$this->Common->flashMessage(__('Saved'), 'success');
			return $this->Common->autoRedirect(array('action' => 'index'));
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
