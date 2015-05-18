<?php
App::uses('DataAppController', 'Data.Controller');

class SmileysController extends DataAppController {

	public $paginate = ['order' => ['Smiley.is_base' => 'DESC', 'Smiley.sort' => 'ASC'], 'limit' => 100];

	public function beforeFilter() {
		parent::beforeFilter();
	}

/****************************************************************************************
 * ADMIN functions
 ****************************************************************************************/

	public function admin_index() {
		$this->Smiley->recursive = 0;
		$smileys = $this->paginate();
		$this->set(compact('smileys'));
	}

	public function admin_view($id = null) {
		if (empty($id) || !($smiley = $this->Smiley->find('first', ['conditions' => ['Smiley.id' => $id]]))) {
			$this->Flash->error(__('invalid record'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$this->set(compact('smiley'));
	}

	public function admin_add() {
		if ($this->Common->isPosted()) {
			$this->Smiley->create();
			if ($this->Smiley->save($this->request->data)) {
				$var = $this->Smiley->id; //$this->request->data['Smiley']['name'];
				$this->Flash->success(__('record add %s saved', h($var)));
				return $this->Common->autoRedirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('formContainsErrors'));
			}
		}
	}

	public function admin_edit($id = null) {
		if (empty($id) || !($smiley = $this->Smiley->find('first', ['conditions' => ['Smiley.id' => $id]]))) {
			$this->Flash->error(__('invalid record'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		if ($this->Common->isPosted()) {
			if ($this->Smiley->save($this->request->data)) {
				$var = $id; //$this->request->data['Smiley']['name'];
				$this->Flash->success(__('record edit %s saved', h($var)));
				return $this->Common->postRedirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('formContainsErrors'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $smiley;
		}
	}

	public function admin_delete($id = null) {
		$this->request->allowMethod('post');
		if (empty($id) || !($smiley = $this->Smiley->find('first', ['conditions' => ['Smiley.id' => $id], 'fields' => ['id']]))) {
			$this->Flash->error(__('invalid record'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		if ($this->Smiley->delete($id)) {
			$var = $smiley['Smiley']['id'];
			$this->Flash->success(__('record del %s done', h($var)));
			return $this->redirect(['action' => 'index']);
		}
		$this->Flash->error(__('record del %s not done exception', h($var)));
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
		$model = $this->{$this->modelClass}->alias;

		if (!$this->request->is('ajax')) {
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$this->autoRender = false;
		if (isset($value)) {
			$this->set('ajaxToggle', $value);
			$this->set(compact('field', 'model'));

			$this->render('admin_toggle', 'ajax');
		}
	}

/****************************************************************************************
 * protected/interal functions
 ****************************************************************************************/

/****************************************************************************************
 * deprecated/test functions
 ****************************************************************************************/

}
