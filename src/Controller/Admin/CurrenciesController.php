<?php

namespace Data\Controller\Admin;

use Data\Controller\DataAppController;

/**
 * @property \Data\Model\Table\CurrenciesTable $Currencies
 * @method \Data\Model\Entity\Currency[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CurrenciesController extends DataAppController {

	/**
	 * @var array
	 */
	public $paginate = ['order' => ['Currencies.base' => 'DESC', 'Currencies.modified' => 'DESC']];

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();
	}

	/**
	 * @return void
	 */
	public function table() {
		$currencies = $this->Currencies->availableCurrencies();
		$this->set(compact('currencies'));
	}

	/**
	 * @return \Cake\Http\Response
	 */
	public function update() {
		$this->Currencies->updateValues();
		$this->Flash->success('Currencies Updated');

		return $this->Common->autoRedirect(['action' => 'index']);
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function index() {
		$currencies = $this->paginate()->toArray();

		$baseCurrency = [];
		foreach ($currencies as $currency) {
			if ($currency['base']) {
				$baseCurrency = $currency;

				break;
			}
		}
		if (empty($baseCurrency)) {
			$baseCurrency = $this->Currencies->find('all', ['conditions' => ['base' => true]])->first();
			if (!$baseCurrency) {
				$this->Flash->warning(__('noBaseCurrency'));
			}
		}

		$this->set(compact('baseCurrency', 'currencies'));
	}

	/**
	 * @param int|null $id
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function view($id = null) {
		$currency = $this->Currencies->get($id);
		if (empty($currency)) {
			$this->Flash->error(__('record not exists'));

			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$this->set(compact('currency'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function add() {
		$currency = $this->Currencies->newEmptyEntity();

		if ($this->Common->isPosted()) {
			$currency = $this->Currencies->patchEntity($currency, $this->request->getData());
			if ($this->Currencies->save($currency)) {
				$id = $currency->id;
				//$name = $this->request->data['Currency']['name'];
				$this->Flash->success(__('record add {0} saved', $id));

				return $this->redirect(['action' => 'index']);
			}

			$this->Flash->error(__('record add not saved'));
		} else {
			$this->request = $this->request->withData('decimal_places', 2);
		}

		$currencies = $this->Currencies->currencyList();
		$this->set(compact('currency', 'currencies'));
	}

	/**
	 * @param int|null $id
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function edit($id = null) {
		$currency = $this->Currencies->get($id);
		if ($this->Common->isPosted()) {
			$currency = $this->Currencies->patchEntity($currency, $this->request->getData());
			if ($this->Currencies->save($currency)) {
				//$name = $this->request->data['Currency']['name'];
				$this->Flash->success(__('record edit {0} saved', $id));

				return $this->redirect(['action' => 'index']);
			}

			$this->Flash->error(__('record edit not saved'));
		}

		$this->set(compact('currency'));
	}

	/**
	 * @param int|null $id
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function delete($id = null) {
		$currency = $this->Currencies->get($id);

		if ($this->Currencies->delete($currency)) {
			$this->Flash->success(__('record del {0} done', $id));

			return $this->redirect(['action' => 'index']);
		}

		$this->Flash->error(__('record del {0} not done exception', $id));

		return $this->Common->autoRedirect(['action' => 'index']);
	}

	/**
	 * Set as primary (base)
	 *
	 * @param int|null $id
	 * @return \Cake\Http\Response|null|void
	 */
	public function base($id = null) {
		$this->_setAsPrimary($id);
	}

	/**
	 * @param int|null $id
	 *
	 * @return \Cake\Http\Response
	 */
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
	 *
	 * @param string|null $field
	 * @param int|null $id
	 * @return \Cake\Http\Response|null|void
	 */
	public function toggle($field = null, $id = null) {
		 $fields = ['active'];

		if (!empty($field) && in_array($field, $fields) && !empty($id)) {
			$value = $this->{$this->modelClass}->toggleField($field, $id);
		}

		# http get request + redirect
		if (!$this->request->is('ajax')) {
			$this->Flash->success(__('Saved'));

			return $this->Common->autoRedirect(['action' => 'index']);
		}

		# ajax
		$model = $this->{$this->modelClass}->getAlias();
		$this->autoRender = false;
		if (isset($value)) {
			$this->set('ajaxToggle', $value);
			$this->set(compact('field', 'model'));

			//FIXME
			$this->render('admin_toggle', 'ajax');
		}
	}

}
