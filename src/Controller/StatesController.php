<?php
namespace Data\Controller;

use Cake\Event\Event;
use Cake\Utility\Hash;
use Data\Controller\DataAppController;
use Exception;

/**
 * @property \Data\Model\Table\StatesTable $States
 */
class StatesController extends DataAppController {

	/**
	 * @var array
	 */
	public $paginate = ['order' => ['States.modified' => 'DESC']];

	/**
	 * @param \Cake\Event\Event $event
	 * @return void
	 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		if (isset($this->Auth)) {
			$this->Auth->allow(['index', 'update_select']);
		}
	}

	/**
	 * Ajax function
	 * new: optional true/false for default field label
	 *
	 * @param int|null $id
	 * @return void
	 */
	public function updateSelect($id = null) {
		if (!$this->request->is('post') || !$this->request->is('ajax')) {
			throw new Exception(__('not a valid request'));
		}
		$this->viewBuilder()->layout('ajax');
		$states = $this->States->getListByCountry($id);

		$defaultFieldLabel = 'pleaseSelect';
		if ($this->request->query('optional')) {
			$defaultFieldLabel = 'doesNotMatter';
		}

		$this->set(compact('states', 'defaultFieldLabel'));
	}

	/**
	 * @param mixed $cid
	 * @return void
	 */
	public function index($cid = null) {
		$this->paginate['contain'] = ['Countries'];
		$this->paginate['order'] = ['States.name' => 'ASC'];
		//$this->paginate['conditions'] = array('Country.status' => 1);

		$this->_processCountry($cid);

		$query = $this->States->find();
		$states = $this->paginate($query);

		$countries = $this->States->Countries->findActive()->find('list');
		$this->set(compact('states', 'countries'));
	}

	/**
	 * For both index views
	 *
	 * @return void
	 */
	protected function _processCountry($cid) {
		$saveCid = true;
		if (empty($cid)) {
			$saveCid = false;
			$cid = $this->request->session()->read('State.cid');
		}
		if (!empty($cid) && $cid < 0) {
			$this->request->session()->delete('State.cid');
			$cid = null;
		} elseif (!empty($cid) && $saveCid) {
			$this->request->session()->write('State.cid', $cid);
		}

		if (!empty($cid)) {
			$this->paginate = Hash::merge($this->paginate, ['conditions' => ['country_id' => $cid]]);
			$this->request->data['id'] = $cid;
		}
	}

}
