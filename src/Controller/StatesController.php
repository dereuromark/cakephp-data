<?php
namespace Data\Controller;

use Cake\Core\Plugin;
use Cake\Event\Event;
use Data\Controller\DataAppController;
use Exception;

/**
 * @property \Data\Model\Table\StatesTable $States
 * @property \Search\Controller\Component\PrgComponent $Prg
 * @method \Data\Model\Entity\State[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StatesController extends DataAppController {

	/**
	 * @var array
	 */
	public $paginate = ['order' => ['States.modified' => 'DESC']];

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function initialize() {
		parent::initialize();

		if (Plugin::loaded('Search')) {
			$this->loadComponent('Search.Prg', [
				'actions' => ['index']
			]);
		}
	}

	/**
	 * @param \Cake\Event\Event $event
	 * @return \Cake\Http\Response|null
	 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		if (isset($this->Auth)) {
			$this->Auth->allow(['index', 'update_select']);
		}
	}

	/**
	 * @param mixed $cid
	 * @return \Cake\Http\Response|null
	 */
	public function index($cid = null) {
		$this->paginate['contain'] = ['Countries'];
		$this->paginate['order'] = ['States.name' => 'ASC'];

		if (Plugin::loaded('Search')) {
			$query = $this->States->find('search', ['search' => $this->request->query]);
			$states = $this->paginate($query);
		} else {
			$states = $this->paginate();
		}

		$countries = $this->States->Countries->findActive()->find('list');
		$this->set(compact('states', 'countries'));
	}

	/**
	 * Ajax function
	 * new: optional true/false for default field label
	 *
	 * @param int|null $id
	 * @return \Cake\Http\Response|null
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

}
