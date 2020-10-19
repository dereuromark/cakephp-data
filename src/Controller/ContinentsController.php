<?php

namespace Data\Controller;

/**
 * @property \Data\Model\Table\ContinentsTable $Continents
 * @method \Cake\ORM\Entity[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContinentsController extends DataAppController {

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function index() {
		$continents = $this->paginate();
		$this->set(compact('continents'));
	}

	/**
	 * @param int|null $id
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function view($id = null) {
		$continent = $this->Continents->get($id);

		$this->set(compact('continent'));
	}

}
