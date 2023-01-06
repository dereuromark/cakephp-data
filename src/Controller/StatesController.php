<?php

namespace Data\Controller;

use Cake\Core\Plugin;
use Exception;

/**
 * @property \Data\Model\Table\StatesTable $States
 * @property \Search\Controller\Component\SearchComponent $Search
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\State> paginate($object = null, array $settings = [])
 */
class StatesController extends DataAppController {

	/**
	 * @var array<string, mixed>
	 */
	protected array $paginate = ['order' => ['States.modified' => 'DESC']];

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		if (Plugin::isLoaded('Search')) {
			$this->loadComponent('Search.Search', [
				'actions' => ['index'],
			]);
		}
	}

	/**
	 * @param mixed $cid
	 * @return \Cake\Http\Response|null|void
	 */
	public function index($cid = null) {
		$this->paginate['contain'] = ['Countries'];
		$this->paginate['order'] = ['States.name' => 'ASC'];

		if (Plugin::isLoaded('Search')) {
			$query = $this->States->find('search', ['search' => $this->request->getQuery()]);
			$states = $this->paginate($query)->toArray();
		} else {
			$states = $this->paginate()->toArray();
		}

		$countries = $this->States->Countries->findActive()->find('list');
		$this->set(compact('states', 'countries'));
	}

	/**
	 * Ajax function
	 * new: optional true/false for default field label
	 *
	 * @param int|null $id
	 * @return \Cake\Http\Response|null|void
	 */
	public function updateSelect($id = null) {
		if (!$this->request->is('post') || !$this->request->is('ajax')) {
			throw new Exception(__('not a valid request'));
		}
		$this->viewBuilder()->setLayout('ajax');
		$states = $this->States->getListByCountry($id);

		$defaultFieldLabel = 'pleaseSelect';
		if ($this->request->getQuery('optional')) {
			$defaultFieldLabel = 'doesNotMatter';
		}

		$this->set(compact('states', 'defaultFieldLabel'));
	}

}
